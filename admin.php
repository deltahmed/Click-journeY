<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["user_id"]) && $_SESSION['user_role'] !== 'admin' ) {
    header("Location: index.php");
    exit;
}


require_once "includes/config.php";

if(!verifyUnId($pdo, $_SESSION['user_id'], $_SESSION['un_id'])){
    header("Location: ../controllers/control_logout.php");
    exit;
}


$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int) $_GET['page'];
}

$limit = 10;


$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$totalUsers = $stmt->fetchColumn();
$totalPages = ceil($totalUsers / $limit);


if ($page < 1) {
    $page = 1;
} elseif ($page > $totalPages) {
    $page = $totalPages;
}


$offset = ($page - 1) * $limit;


$stmt = $pdo->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        
        <title>Beyond Survival | Admin</title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/icons/gear/gear.png" type="image/icon type">

        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body class="admin-body">
        <header>
            <?php include "views/header.php" ?>
            <!-- Navigation bar -->
            <nav class="navbar">
                <a href="index.php">
                    <div class="home-button">
                        <img class="icon">
                        <h1>Accueil</h1>
                    </div>  
                </a>
            </nav>
        </header>

        <div class="admin-overlay">
            <div class="admin-content">
                <h1> Liste des utilisateurs </h1>
                <form class="pages-nav" action="admin.php" method="get">
                    <div>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <button class="green_button" type="submit" name="page" value="<?php echo $i; ?>"><?php echo $i; ?></button>
                        <?php endfor; ?>
                    </div>
                        
                </form>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Informations</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>ID</td>
                                            <td><?php echo $user['id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>E-mail</td>
                                            <td>
                                                <?php echo $user['email']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>
                                                <?php echo $user['role']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nom</td>
                                            <td>
                                                <?php echo $user['last_name']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prénom</td>
                                            <td>
                                                <?php echo $user['first_name']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sexe</td>
                                            <td>
                                                <?php echo $user['gender']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date de naissance</td>
                                            <td>
                                                <?php echo $user['birth_date']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Numéro de téléphone</td>
                                            <td>
                                                <?php echo $user['phone_number']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Adresse</td>
                                            <td>
                                                <?php echo $user['address']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Code postal</td>
                                            <td>
                                                <?php echo $user['postal_code']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ville</td>
                                            <td>
                                                <?php echo $user['city']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Commentaire</td>
                                            <td>
                                                <?php echo $user['comment']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date d'Inscription</td>
                                            <td>
                                                <?php echo $user['registration_date']; ?>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </td>
                                <td class="td-button">
                                    <div>
                                        
                                        <button class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                        <button class="add-b">
                                            <img class="icon">
                                            Réductions
                                        </button>
                                        <button class="reset-b">
                                            <img class="icon">
                                            Reset Mdp
                                        </button>
                                        <button class="ban-b">
                                            <img class="icon">
                                            Bannir
                                        </button>
                                        <button class="del-b">
                                            <img class="icon">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        
                    </tbody>
                </table>
                <form class="pages-nav" action="admin.php" method="get">
                    <div>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <button class="green_button" type="submit" name="page" value="<?php echo $i; ?>"><?php echo $i; ?></button>
                        <?php endfor; ?>
                    </div>
                        
                </form>
            </div>
        </div>
        
        
        <?php include "views/footer.php" ?>
    </body>
</html>