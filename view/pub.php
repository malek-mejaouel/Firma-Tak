<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Publications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f9f5;
            color: #333;
        }

        /* Header Styling */
        header {
            background-color: #6b7908;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 2.2rem;
        }

        header p {
            font-size: 1rem;
            margin-top: 10px;
            color: #e0f2e0;
        }

        /* Main Content Container */
        .container {
            margin: 40px auto;
            max-width: 90%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1, h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 a {
            text-decoration: none;
            color: #6b7908;     font-weight: bold;
        }

        h2 a:hover {
            color: #388E3C;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 1rem;
        }

        table th {
            background-color: #6b7908;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #eef7ee;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 8px 15px;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #6b7908; }

        .btn-primary:hover {
            background-color: #388E3C;
        }

        .btn-danger {
            background-color: #E74C3C;
        }

        .btn-danger:hover {
            background-color: #C0392B;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #6b7908;
            font-size: 0.9rem;
        }

        footer a {
            color: #e0f2e0;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <h1>Publications FIRMA-TAK</h1>
        <p>Your platform for managing insights and updates</p>
    </header>

    <div class="container">
        <!-- Publications Table -->
        <?php
        include "../controller/PublicationC.php";

        $c = new PublicationC();
        $tab = $c->listPublications();

        if (is_array($tab) && count($tab) > 0) {
        ?>
            <h1>List of Publications</h1>
            <h2>
                <a href="addPublication.php">Add New Publication</a>
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Date</th>
                        <th>Content</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tab as $publication) {
                    ?>
                        <tr>
                            <td><?= $publication['ID']; ?></td>
                            <td><?= htmlspecialchars($publication['Titre']); ?></td>
                            <td><a href="<?= htmlspecialchars($publication['Lien']); ?>" target="_blank">View</a></td>
                            <td><?= $publication['Date']; ?></td>
                            <td><?= htmlspecialchars($publication['Contenu']); ?></td>
                            <td>
                                <form method="POST" action="updatePublication.php">
                                    <input type="hidden" value="<?= $publication['ID']; ?>" name="idPublication">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="deletePublication.php?id=<?= $publication['ID']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                            <td>
                                <a href="affichebackcommentaire.php?id=<?= $publication['ID']; ?>" class="btn btn-primary">
                                    <i class="fas fa-comments"></i> Comments
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<p>No publications found.</p>";
        }
        ?>
        
        <a href="dashboard.php" class="return-button">Return to Dashboard</a>

    </div>

    <footer>
        © <?= date("Y"); ?> Agriculture Publications | <a href="#">Privacy Policy</a> | <a href="#">Terms</a>
    </footer>
</body>

</html>
