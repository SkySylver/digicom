<?php
$title = "Accueil";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    require_once 'inc/header.php';
    ?>
</head>
<body>
    <?php
        require_once 'inc/menu.php';
    ?>
    <div class="container">
        <div class="row center-block">
            <!--- Titre --->
            <div class="col-12 text-center mb-sm-2">
                <h1>Digicom Gsm Services</h1>
            </div>

            <!--- Bloc complet --->
            <div class="col-md-8 row">
                <!--- Icones --->
                <div class="col-md-3 m-auto col-4 text-center">
                    <img class="img-fluid" src="./img/home/phone.png" alt="Image phone">
                    <span class="pr80">Réparations</span>
                </div>

                <div class="col-md-3 offset-md-1 col-4 text-center m-auto">
                    <img class="img-fluid" src="./img/home/computer.png" alt="Image computer">
                    <span class="pr80">Dépannage</span>
                </div>

                <div class="col-md-3 offset-md-1 col-4 text-center m-auto">
                    <img class="img-fluid" src="./img/home/headphones.png" alt="Image accessories">
                    <span class="pr80">Accessoires</span>
                </div>

                <!--- Bouton --->
                <div class="col-12 text-center">
                    <div>
                        <button class="btn btn-primary my-3" onclick="window.location='shop.php';">Consulter nos prix</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border">
                <?php require "inc/address.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>