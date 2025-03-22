<!-- The main banner with the logo -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_role'])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}
?>
<div class="ban">
    <a href="index.php">
        <div class="title">
            <img src="media/logo.png" alt="Logo de Beyond Survival">
            <div class="title-text">
                <h1>Beyond Survival</h1>
                <h3>Survive if you can !</h3>
            </div>
        </div> 
    </a>
    <div class="profil-links">
        <?php if (!$isLoggedIn): ?>
            <div class="login">
                <img class="icon">
                <a href="login.php">Connexion</a>
            </div>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <div class="profil">
                <img class="icon">
                <a href="profil.php">Profil</a>
            </div>
        <?php endif; ?>
        <?php if ($isLoggedIn && $_SESSION['user_role'] === 'admin'): ?>
            <div class="admin">
                <img class="icon">
                <a href="admin.php">Admin</a>
            </div>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <div class="logout">
                <img class="icon">
                <a href="controllers/control_logout.php">Déconnexion</a>
            </div>
        <?php endif; ?>
        
    </div>
</div>