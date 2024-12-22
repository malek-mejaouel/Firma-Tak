<?php
require '../db.php';
require '../controller/EventController.php';
require '../controller/ParticipantController.php';


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
    <style>
        /* From Uiverse.io by abrahamcalsin */ 

        .card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 20px;
}

.card-client {
    background: #28a745;
    width: 13rem;
    padding-top: 25px;
    padding-bottom: 25px;
    padding-left: 20px;
    padding-right: 20px;
    border: 4px solid #28a745;
    box-shadow: 0 6px 10px rgba(207, 212, 222, 1);
    border-radius: 10px;
    text-align: center;
    color: #fff;
    font-family: "Poppins", sans-serif;
    transition: all 0.3s ease;
}

.card-client:hover {
  transform: translateY(-10px);
}

.user-picture {
  overflow: hidden;
  object-fit: cover;
  width: 5rem;
  height: 5rem;
  border: 4px solid #28a745;
  border-radius: 999px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: auto;
}

.user-picture svg {
  width: 2.5rem;
  fill: currentColor;
}

.name-client {
  margin: 0;
  margin-top: 20px;
  font-weight: 600;
  font-size: 18px;
}

.name-client span {
  display: block;
  font-weight: 200;
  font-size: 16px;
}

.social-media:before {
  content: " ";
  display: block;
  width: 100%;
  height: 2px;
  margin: 20px 0;
  background: #7cdacc;
}

.social-media a {
  position: relative;
  margin-right: 15px;
  text-decoration: none;
  color: inherit;
}

.social-media a:last-child {
  margin-right: 0;
}

.social-media a svg {
  width: 1.1rem;
  fill: currentColor;
}

/*-- Tooltip Social Media --*/
.tooltip-social {
  background: #262626;
  display: block;
  position: absolute;
  bottom: 0;
  left: 50%;
  padding: 0.5rem 0.4rem;
  border-radius: 5px;
  font-size: 0.8rem;
  font-weight: 600;
  opacity: 0;
  pointer-events: none;
  transform: translate(-50%, -90%);
  transition: all 0.2s ease;
  z-index: 1;
}

.tooltip-social:after {
  content: " ";
  position: absolute;
  bottom: 1px;
  left: 50%;
  border: solid;
  border-width: 10px 10px 0 10px;
  border-color: transparent;
  transform: translate(-50%, 100%);
}

.social-media a .tooltip-social:after {
  border-top-color: #262626;
}

.social-media a:hover .tooltip-social {
  opacity: 1;
  transform: translate(-50%, -130%);
}
    </style>
</head>

<body>
    <header>
        <div class="nav container">
            <div class="logo-container">
                <img style="width: 50px;" src="../assets/images1/logo.png" alt="logo">
                <a href="#" class="logo">FIRMA <span>-TAK</span></a>
            </div>
            <a href="#" class="login">Login</a>
            <label id ="theme-toggle"for="theme" class="theme">
	<span class="theme__toggle-wrap">
		<input id="theme" class="theme__toggle" type="checkbox" role="switch" name="theme" value="dark">
		<span class="theme__fill"></span>
		<span class="theme__icon">
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
			<span class="theme__icon-part"></span>
		</span>
	</span>
</label>
<style>/* From Uiverse.io by JkHuger */ 
/* Default */
.theme {
  display: flex;
  align-items: center;
  -webkit-tap-highlight-color: transparent;
}

.theme__fill,
.theme__icon {
  transition: 0.3s;
}

.theme__fill {
  background-color: var(--bg);
  display: block;
  mix-blend-mode: difference;
  position: fixed;
  inset: 0;
  height: 100%;
  transform: translateX(-100%);
}

.theme__icon,
.theme__toggle {
  z-index: 1;
}

.theme__icon,
.theme__icon-part {
  position: absolute;
}

.theme__icon {
  display: block;
  top: 0.5em;
  left: 0.5em;
  width: 1.5em;
  height: 1.5em;
}

.theme__icon-part {
  border-radius: 50%;
  box-shadow: 0.4em -0.4em 0 0.5em hsl(0,0%,100%) inset;
  top: calc(50% - 0.5em);
  left: calc(50% - 0.5em);
  width: 1em;
  height: 1em;
  transition: box-shadow var(--transDur) ease-in-out,
		opacity var(--transDur) ease-in-out,
		transform var(--transDur) ease-in-out;
  transform: scale(0.5);
}

.theme__icon-part ~ .theme__icon-part {
  background-color: hsl(0,0%,100%);
  border-radius: 0.05em;
  top: 50%;
  left: calc(50% - 0.05em);
  transform: rotate(0deg) translateY(0.5em);
  transform-origin: 50% 0;
  width: 0.1em;
  height: 0.2em;
}

.theme__icon-part:nth-child(3) {
  transform: rotate(45deg) translateY(0.45em);
}

.theme__icon-part:nth-child(4) {
  transform: rotate(90deg) translateY(0.45em);
}

.theme__icon-part:nth-child(5) {
  transform: rotate(135deg) translateY(0.45em);
}

.theme__icon-part:nth-child(6) {
  transform: rotate(180deg) translateY(0.45em);
}

.theme__icon-part:nth-child(7) {
  transform: rotate(225deg) translateY(0.45em);
}

.theme__icon-part:nth-child(8) {
  transform: rotate(270deg) translateY(0.5em);
}

.theme__icon-part:nth-child(9) {
  transform: rotate(315deg) translateY(0.5em);
}

.theme__label,
.theme__toggle,
.theme__toggle-wrap {
  position: relative;
}

.theme__toggle,
.theme__toggle:before {
  display: block;
}

.theme__toggle {
  background-color: hsl(48,90%,85%);
  border-radius: 25% / 50%;
  box-shadow: 0 0 0 0.125em var(--primaryT);
  padding: 0.25em;
  width: 6em;
  height: 3em;
  -webkit-appearance: none;
  appearance: none;
  transition: background-color var(--transDur) ease-in-out,
		box-shadow 0.15s ease-in-out,
		transform var(--transDur) ease-in-out;
}

.theme__toggle:before {
  background-color: hsl(48,90%,55%);
  border-radius: 50%;
  content: "";
  width: 2.5em;
  height: 2.5em;
  transition: 0.3s;
}

.theme__toggle:focus {
  box-shadow: 0 0 0 0.125em var(--primary);
  outline: transparent;
}

/* Checked */
.theme__toggle:checked {
  background-color: hsl(198,90%,15%);
}

.theme__toggle:checked:before,
.theme__toggle:checked ~ .theme__icon {
  transform: translateX(3em);
}

.theme__toggle:checked:before {
  background-color: hsl(198,90%,55%);
}

.theme__toggle:checked ~ .theme__fill {
  transform: translateX(0);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(1) {
  box-shadow: 0.2em -0.2em 0 0.2em hsl(0,0%,100%) inset;
  transform: scale(1);
  top: 0.2em;
  left: -0.2em;
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part ~ .theme__icon-part {
  opacity: 0;
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(2) {
  transform: rotate(45deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(3) {
  transform: rotate(90deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(4) {
  transform: rotate(135deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(5) {
  transform: rotate(180deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(6) {
  transform: rotate(225deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(7) {
  transform: rotate(270deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(8) {
  transform: rotate(315deg) translateY(0.8em);
}

.theme__toggle:checked ~ .theme__icon .theme__icon-part:nth-child(9) {
  transform: rotate(360deg) translateY(0.8em);
}

.theme__toggle-wrap {
  margin: 0 0.75em;
}

@supports selector(:focus-visible) {
  .theme__toggle:focus {
    box-shadow: 0 0 0 0.125em var(--primaryT);
  }

  .theme__toggle:focus-visible {
    box-shadow: 0 0 0 0.125em var(--primary);
  }
}</style>
            
        </div>
        
    </header>

    <section class="home" id="home">
        <div class="home-text container">
            <h2 class="home-title">Events</h2>
            <span class="home-subtitle">Enjoy</span>
        </div>

    </section>
    <section class="events-section container" id="events">
        <section class="search-section container">
        <input type="text" id="searchInput" placeholder="Search events..." class="search-bar">
<button id="searchBtn" class="btn">Search</button>


<section>
    <div class="post">
        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <?php
                $registeredCount = count($participantController->listParticipantsByEvent($event['id']));
                $remainingSpots = $event['max_participants'] - $registeredCount;
                ?>
                <div class="post-box">
                    <img src="<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" class="post-img">
                    <h2 class="category"><?php echo htmlspecialchars($event['title']); ?></h2>
                    <span class="post-date"><?php echo htmlspecialchars($event['event_date']); ?></span>
                    <p>Remaining Spots: <?php echo $remainingSpots; ?> / <?php echo $event['max_participants']; ?></p>
                    <div class="profile">
                    <button class="at" <?php echo $remainingSpots <= 0 ? 'disabled' : ''; ?> 
                    onclick="joinEvent(<?php echo $event['id']; ?>)">
                    <?php echo $remainingSpots > 0 ? 'Join Event' : 'Fully Booked'; ?>
                    <button class="at" onclick="openParticipantSearch(<?php echo $event['id']; ?>)">
    View Details
</button>
                        <span class="participant-count">
                            <?php echo $registeredCount; ?> Participants Joined
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
    <div id="participant-search-modal" style="display: none;">
    <form method="GET" action="eventdetails.php">
        <input type="hidden" name="event_id" id="event-id">
        <label for="participant-name">Enter Your Name:</label>
        <input type="text" id="participant-name" name="participant_name" required>
        <button type="submit">Submit</button>
        <button type="button" onclick="closeParticipantSearch()">Cancel</button>
    </form>
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
        <div class="card-container">
            <?php if (count($participants) > 0): ?>
                <?php foreach ($participants as $participant): ?>
                    <div class="card-client">
                        <div class="user-picture">
                            <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path>
                            </svg>
                        </div>
                        <p class="name-client"> 
                            <?php echo htmlspecialchars($participant['name']); ?> 
                            <span>Joined: 
                                <?php 
                                    $eventDetails = $controller->viewEvent($participant['event_id']); 
                                    echo htmlspecialchars($eventDetails['title']);
                                ?>
                            </span>
                        </p>
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
function openParticipantSearch(eventId) {
    document.getElementById('participant-search-modal').style.display = 'block';
    document.getElementById('event-id').value = eventId;
}

function closeParticipantSearch() {
    document.getElementById('participant-search-modal').style.display = 'none';
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