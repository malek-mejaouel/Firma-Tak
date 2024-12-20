<?php
require '../db.php';
require '../controllers/EventController.php';
require '../controllers/ParticipantController.php';

$participantController = new ParticipantController($conn);
$participants = $participantController->listParticipants();
$controller = new EventController($conn);
$events = $controller->listEvents();

// Start output buffering
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trend Blogger</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/searchbar.css">
    <link rel="stylesheet" href="../assets/dark.css">
    
</head>

<body>
    <header>
        <div class="nav container">
            <div class="logo-container">
                <img style="width: 50px;" src="../assets/images1/logo.png" alt="logo">
                <a href="#" class="logo">FIRMA <span>-TAK</span></a>
            </div>
            <a href="#" class="login">Login</a>
            <button id="theme-toggle" class="login">Switch Theme</button>
            
        </div>
        
    </header>

    <section class="home" id="home">
        <div class="home-text container">
            <h2 class="home-title">Enjoy Your Time With Us</h2>
            <span class="home-subtitle">Your source of great content</span>
        </div>
    </section>

    <section class="events-section container" id="events">
        <h2 class="titleText">Events</h2>
        <section class="search-section container">
        <input type="text" id="searchInput" placeholder="Search events..." class="search-bar">
<button id="searchBtn" class="btn">Search</button>

</section>
        <div class="post">
            <?php if (count($events) > 0): ?>
                <?php foreach ($events as $event): ?>
                    <div class="post-box">
                        <img src="<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" class="post-img">
                        <h2 class="category"><?php echo htmlspecialchars($event['title']); ?></h2>
                        <span class="post-date"><?php echo htmlspecialchars($event['event_date']); ?></span>
                        <div class="profile">
                            <button class="at" onclick="joinEvent(<?php echo $event['id']; ?>)">
                                Join Event
                            </button>
                            <span class="participant-count">
                                <?php echo count($participantController->listParticipantsByEvent($event['id'])); ?> Participants Joined
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No events found.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="upcoming-section container">
        <h2 class="titleText">Upcoming Events</h2>
        <div class="post">
            <?php
            $today = date('Y-m-d');
            $upcomingEvents = array_filter($events, fn($event) => $event['event_date'] >= $today);
            usort($upcomingEvents, fn($a, $b) => strtotime($a['event_date']) - strtotime($b['event_date']));
            ?>
            <?php if (count($upcomingEvents) > 0): ?>
                <?php foreach ($upcomingEvents as $event): ?>
                    <div class="post-box">
                        <img src="<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" class="post-img">
                        <h2 class="category"><?php echo htmlspecialchars($event['title']); ?></h2>
                        <div class="countdown" data-event-date="<?php echo $event['event_date']; ?>"></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No upcoming events found.</p>
            <?php endif; ?>
        </div>
    </section>


    <section class="participants-section container" id="participants">
    <h2 class="titleText">Participants</h2>
    <div class="post">
        <?php if (count($participants) > 0): ?>
            <?php foreach ($participants as $participant): ?>
                <div class="post-box">
                    <h2 class="category">Participant</h2>
                    <a href="#" class="post-title">
                        <?php echo htmlspecialchars($participant['name']); ?> 
                        - Joined: 
                        <?php 
                            $eventDetails = $controller->viewEvent($participant['event_id']); 
                            echo htmlspecialchars($eventDetails['title']);
                        ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No participants found.</p>
        <?php endif; ?>
    </div>
</section>
            <script>
                const toggleButton = document.getElementById('theme-toggle');
toggleButton.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
});

// Persist theme on reload
window.addEventListener('load', () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }
});
document.getElementById('searchBtn').addEventListener('click', function() {
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const events = document.querySelectorAll('.post-box'); // Assuming events are displayed in elements with class 'post-box'

    events.forEach(function(event) {
        const title = event.querySelector('.category').textContent.toLowerCase();
        const description = event.querySelector('.post-date').textContent.toLowerCase();

        if (title.includes(searchQuery) || description.includes(searchQuery)) {
            event.style.display = ''; // Show matching events
        } else {
            event.style.display = 'none'; // Hide non-matching events
        }
    });
});

// Join Event Functionality
function joinEvent(eventId) {
    const participantName = prompt("Enter your name to join the event:");
    const participantEmail = prompt("Enter your email:");
    if (participantName && participantEmail) {
        fetch('joinEvent.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                event_id: eventId,
                name: participantName,
                email: participantEmail
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert("Successfully joined the event!");
                location.reload(); // Refresh to update participant list
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => console.error("Error:", error));
    }
}

            </script>

    <footer>
        <div class="footer-container">
            <div class="sec aboutus">
                <h2>About Us</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus quisquam minus quo illo numquam vel incidunt pariatur hic commodi expedita tempora praesentium at iure fugiat ea, quam laborum aperiam veritatis.</p>
                <ul class="sci">
                    <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                    <li><a href="#"><i class="bx bxl-instagram"></i></a></li>
                    <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                    <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="sec quicklinks">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>
            <div class="sec contactBx">
                <h2>Contact Info</h2>
                <ul class="info">
                    <li>
                        <span><i class='bx bxs-map'></i></span>
                        <span>8081 Nabeul <br> ManzelBouZalfa 33445 <br> TUN</span>
                    </li>
                    <li>
                        <span><i class='bx bx-envelope'></i></span>
                        <p><a href="mailto:kingmejaouel@gmail.com">Kingmejaouel@gmail.com</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../assets/main.js"></script>
    <script src="../assets/fonction.js"></script>
    <script src="../assets/countdown.js"></script>
</body>

</html>