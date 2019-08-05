<?php
$title = "Tarifs";
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
    <div class="container align-items-end">
        <!--- Prix réparations --->
    <form>
        <div class="row">
            <div class="col-sm-12"><h2>Consulter un tarif pour une réparation</h2></div>
            <div class="col-sm-4">
                 <label for="brand">Choisissez la marque</label>
                <select id="brand" name="brand" class="form-control linked-select" data-target="#model" data-source="inc/repairs.php?type=model&filter=$id">
                    <option value="0" selected="selected">Sélectionnez une marque</option>
                    <?php
                        require_once 'inc/db.php';
                        $temp = $bdd->query("SELECT * FROM brands");
                        while($res = $temp->fetch()){
                    ?>
                        <option value="<?= $res->id; ?>"><?= $res->brand; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-4">
                <label id="label-model" for="model" style="display: none;">Choisissez le modèle</label>
                <select id="model" name="model" class="form-control linked-select" style="display: none;" data-target="#repair" data-source="inc/repairs.php?type=repair&filter=$id">
                    <option value="0" selected="selected">Sélectionnez un modèle</option>
                </select>
            </div>

            <div class="col-sm-4">
                <label id="label-repair" for="repair" style="display: none;">Choisissez la réparation</label>
                <select id="repair" name="model" class="form-control linked-select" data-target="#result" data-source="inc/repairs.php?type=result&filter=$id" style="display: none;">
                    <option value="0">Sélectionnez une option</option>
                </select>
            </div>
        </div>
        <div class="row mt-4" id="result">

        </div>
    </form>

        <!-- -->
    <div class="row mt-5">
        <div class="col-sm-12 border-top">
            <h2>Nos produits</h2>
        </div>
    </div>

    </div>
<script src="js/main.js"></script>

</body>
</html>