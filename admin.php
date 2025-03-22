<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["user_id"]) && $_SESSION['user_role'] !== 'admin' ) {
    header("Location: index.php");
    exit;
}
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
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Informations</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>ID</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td>
                                        <td>contact.ahmed.delta@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>Admin</td>
                                    </tr>
                                    <tr>
                                        <td>Nom</td>
                                        <td>Ahmed</td>
                                    </tr>
                                    <tr>
                                        <td>Prénom</td>
                                        <td>Ahmed</td>
                                    </tr>
                                    <tr>
                                        <td>Sexe</td>
                                        <td>M</td>
                                    </tr>
                                    <tr>
                                        <td>Date de naissance</td>
                                        <td>01/01/2000</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de téléphone</td>
                                        <td>0707070707</td>
                                    </tr>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>9 av parc</td>
                                    </tr>
                                    <tr>
                                        <td>Code postal</td>
                                        <td>95800</td>
                                    </tr>
                                    <tr>
                                        <td>Ville</td>
                                        <td>Cergy</td>
                                    </tr>
                                    <tr>
                                        <td>Commentaire</td>
                                        <td></td>
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

                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>ID</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td>
                                        <td>email@email.com</td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>User</td>
                                    </tr>
                                    <tr>
                                        <td>Nom</td>
                                        <td>Abdelwaheb</td>
                                    </tr>
                                    <tr>
                                        <td>Prénom</td>
                                        <td>Abdelwaheb</td>
                                    </tr>
                                    <tr>
                                        <td>Sexe</td>
                                        <td>M</td>
                                    </tr>
                                    <tr>
                                        <td>Date de naissance</td>
                                        <td>01/01/2000</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de téléphone</td>
                                        <td>0707070707</td>
                                    </tr>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>9 av parc</td>
                                    </tr>
                                    <tr>
                                        <td>Code postal</td>
                                        <td>95800</td>
                                    </tr>
                                    <tr>
                                        <td>Ville</td>
                                        <td>Cergy</td>
                                    </tr>
                                    <tr>
                                        <td>Commentaire</td>
                                        <td></td>
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

                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>ID</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td>
                                        <td>email@email.com</td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>Banni</td>
                                    </tr>
                                    <tr>
                                        <td>Nom</td>
                                        <td>Rémi</td>
                                    </tr>
                                    <tr>
                                        <td>Prénom</td>
                                        <td>Rémi</td>
                                    </tr>
                                    <tr>
                                        <td>Sexe</td>
                                        <td>M</td>
                                    </tr>
                                    <tr>
                                        <td>Date de naissance</td>
                                        <td>01/01/2000</td>
                                    </tr>
                                    <tr>
                                        <td>Numéro de téléphone</td>
                                        <td>0707070707</td>
                                    </tr>
                                    <tr>
                                        <td>Adresse</td>
                                        <td>9 av parc</td>
                                    </tr>
                                    <tr>
                                        <td>Code postal</td>
                                        <td>95800</td>
                                    </tr>
                                    <tr>
                                        <td>Ville</td>
                                        <td>Cergy</td>
                                    </tr>
                                    <tr>
                                        <td>Commentaire</td>
                                        <td></td>
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
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        
        <?php include "views/footer.php" ?>
    </body>
</html>