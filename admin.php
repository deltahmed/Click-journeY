<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
if (!isset($_SESSION["un_id"])) {
    header("Location: index.php");
    exit;
}
if ($_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
require_once "includes/config.php";

if(!verifyUnId($pdo, $_SESSION['user_id'], $_SESSION['un_id'])){
    header("Location: controllers/control_logout.php");
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

        <link rel="stylesheet" id="theme-style" type="text/css" href="styles/style.css">
        <script src="scripts/theme.js" defer></script>
        <script src="scripts/admin.js" defer></script>
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
                <?php if (isset($_SESSION['update_error'])) : ?>
                    <p class="p-error"> <?php 
                        echo $_SESSION['update_error'];
                        unset($_SESSION['update_error']);
                    ?></p>
                <?php endif; ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Informations</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr data-id="<?php echo $user['id']; ?>">
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
                                            <td id="role-<?php echo $user['id']; ?>">
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
                                            <td>Numéro de téléphone</td>
                                            <td>
                                                <?php echo $user['phone_number']; ?>
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
                                        <form action="profil.php" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button class="mod-b" type="submit">
                                                <img class="icon">
                                                Modifier
                                            </button>
                                        </form>
                                        <?php if ($user['role'] === 'user'): ?>
                                            <button class="add-b" data-id="<?php echo $user['id']; ?>">
                                                <img class="icon">
                                                Promouvoir
                                            </button>
                                        <?php elseif ($user['role'] === 'vip'): ?>
                                            <button class="ban-b" data-id="<?php echo $user['id']; ?>">
                                                <img class="icon">
                                                Rétrograder
                                            </button>
                                        <?php endif; ?>
                                        <!-- sdd 
                                        <button class="reset-b">
                                            <img class="icon">
                                            Reset Mdp 
                                        </button> -->
                                        <?php if ($user['role'] !== 'admin'): ?>
                                            <button class="del-b" data-id="<?php echo $user['id']; ?>">
                                                <img class="icon">
                                                Supprimer
                                            </button>
                                        <?php endif; ?>
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