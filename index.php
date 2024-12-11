<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ALPHA Web Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }

        .side-menu {
            width: 20%;
            background-color: #2c3e50;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .side-menu ul {
            list-style: none;
            padding: 0;
        }

        .side-menu ul li {
            margin: 20px 0;
        }

        .side-menu ul li img {
            width: 20px;
            margin-right: 10px;
        }

        .container {
            width: 80%;
            padding: 20px;
            background-color: #ecf0f1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #2c3e50;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .header ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .header ul li a {
            text-decoration: none;
            color: #2c3e50;
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }

        h2 a {
            text-decoration: none;
            color: #2980b9;
        }

        h2 a:hover {
            color: #3498db;
        }

        p {
            text-align: center;
            color: red;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="side-menu">
        <div class="brand-name">
            <img src="images/logos.png" alt="Logo" />
            <h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="#"><li><img src="images/dashboard (2).png" alt="Dashboard"> <span>Dashboard</span></li></a>
            <a href="index.php"><li><img src="images/reading-book (1).png" alt="Publications"> <span>Publications</span></li></a>
            <a href="statistiquepublication.php?sort=titre" class="btn btn-primary">Statistique des commentaires par publication</a>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Navbar -->
       
        <!-- Publications Table -->
        <?php
        include "../../controller/PublicationC.php";

        $c = new PublicationC();
        $tab = $c->listPublications();

        if (is_array($tab) && count($tab) > 0) {
        ?>
            <h1>List of Publications</h1>
            <h2>
                <a href="addPublication.php">Add Publication</a>
            </h2>
            <table>
                <tr>
                    <th>Id Publication</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Content</th>
                    <th>Update</th>
                    <th>Delete</th>
                    <th>commentaire</th>
                </tr>

                <?php
                foreach ($tab as $publication) {
                ?>
                    <tr>
                        <td><?= $publication['ID']; ?></td>
                        <td><?= $publication['Titre']; ?></td>
                        <td><?= $publication['Lien']; ?></td>
                        <td><?= $publication['Date']; ?></td>
                        <td><?= $publication['Contenu']; ?></td>
                        <td align="center">
                            <form method="POST" action="updatePublication.php">
                                <input type="submit" name="update" value="Update">
                                <input type="hidden" value="<?= $publication['ID']; ?>" name="idPublication">
                            </form>
                        </td>
                        <td>
                            <a href="deletePublication.php?id=<?= $publication['ID']; ?>">Delete</a>
                            
                        </td>
                        <td class="text-center">
    <a href="affichebackcommentaire.php?id=<?= $publication['ID']; ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-comments"></i> View Comments
    </a>
</td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        } else {
            echo "<p>No publications found.</p>";
        }
        ?>
    </div>
</body>

</html>
