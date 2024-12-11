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
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Navbar -->
       
        <!-- Publications Table -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <!-- Navigation Topbar code here... -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Liste des commentaires</h1>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des commentaires</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Contenu</th>
                                            <th>Date</th>
                                            <th>ID Post</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '/XAMPP/htdocs/projetagriculture/controller/commentaireC.php';
                                        include_once '/XAMPP/htdocs/projetagriculture/controller/publicationC.php';

                                        $d = new commentaireC();
                                        $r = new publicationC();
                                        
                                      
                                        if(isset($_GET['id'])) {
                                            $id_post = $_GET['id'];
                                            $tab=  $d ->afficher($id_post);
                                        } else {
                                            // Redirection, afficher un message plus convivial, etc.
                                            echo "<p>Veuillez sélectionner un post pour voir les commentaires.</p>";
                                            exit; // Ou redirection avec header('Location: url_de_redirection');
                                        }

                                        foreach ($tab as $rep) { ?>
                                            <tr>
                                                <td><?= $rep['contenu'] ?></td>
                                                <td><?= $rep['date'] ?></td>
                                                <td><?= $rep['id_post'] ?></td>
                                                <td>
                                                    <a href="supprimercommentaireback.php?id_c=<?= $rep['id_c']; ?>">Supprimer</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Page Content -->
            </div>
        </div>
    </div>
</body>

</html>
