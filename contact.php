<?php
require_once 'inc/db.php';

if (isset($_POST['submit'])) {
    //mail
    if (isset($_POST['email'])) {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Adresse Email invalide";
            $val['email'] = " is-invalid";
            $replace['email'] = "";
        } else {
            $val['email'] = " is-valid";
            $replace['email'] = $_POST['email'];
        }
    } else {
        $errors['email'] = "Veuillez saisir une adresse email";
        $val['email'] = " is-invalid";
        $replace['email'] = "";
    }

//centre
    if (isset($_POST['center']) && $_POST['center'] != 0) {
        $temp = $bdd->prepare('SELECT email FROM adress WHERE id = ?');
        $temp->execute([$_POST['center']]);
        if ($temp->rowCount()) {
            $res = $temp->fetch();
            $to = $res->email;
            $val['center'] = " is-valid";
            $replace['center'] = $_POST['center'];
        } else {
            $errors['center'] = "Impossible de trouver le centre de réparation";
            $val['center'] = " is-invalid";
            $replace['center']= '0';
        }
    } else {
        $errors['center'] = "Centre de réparation invalide";
        $val['center'] = " is-invalid";
        $replace['center']= '0';
    }

//sujet
    if (!isset($_POST['subject']) || trim($_POST['subject']) == "") {
        $errors['subject'] = "Veuillez saisir un sujet";
        $val['subject'] = " is-invalid";
        $replace['subject'] = "";
    } else {
        $val['subject'] = " is-valid";
        $replace['subject'] = $_POST['subject'];
    }

//message
    if (!isset($_POST['message']) || trim($_POST['message']) == "") {
        $errors['message'] = "Veuillez saisir un message";
        $val['message'] = " is-invalid";
        $replace['message'] = "";
    } else {
        $val['message'] = " is-valid";
        $replace['message'] = $_POST['message'];
    }


    if (isset($errors)) $invalid = true;
    else {
        //valide
        $invalid = false;
        foreach ($val as $valeur) {
            $valeur = "";
        }
        $header = "From:" . $_POST['email'];
        //mail($to, $_POST['subject'], $_POST['message'], $header);

        $valid = true;
        $invalid = false;
        $val = null;
        $replace = null;
    }
} else {
    $invalid = false;
    $val = null;
    $valid = false;
    $replace = null;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Nous contacter";
    require_once 'inc/header.php'; ?>
</head>
<body>
<?php require 'inc/menu.php'; ?>
<div class="container align-items-end">
    <h3 class="mx-auto">Nous contacter</h3>
    <form action="#" method="post">
        <!-- Envoyé -->
        <?php
        if ($invalid) echo '<div class="text-white bg-danger rounded text-center">Veuillez compléter les champs invalides</div>';
        elseif ($valid) echo '<div class="text-white bg-success rounded text-center">Votre message a bien été envoyé !</div>';
        ?>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" name="email" value="<?= $replace['email']; ?>" placeholder="mail@mondomaine.com"
                   class="form-control<?php echo $val['email']; ?>"/>
            <?php
            if (isset($errors['email'])) echo '<div class="invalid-feedback">' . $errors['email'] . '</div>';
            elseif (!$invalid) echo '<div class="valid-feedback">Valide</div>';
            ?>
        </div>


        <!-- Centre -->
        <div class="form-group">
            <label for="center">Centre</label>
            <select name="center" class="form-control<?php echo $val['center']; ?>" required>
                <option value="0">Sélectionnez un centre</option>
                <?php
                $temp = $bdd->query('SELECT name, id FROM adress');
                while ($res = $temp->fetch()) {
                    echo '<option value="' . $res->id .'" ';
                    if($res->id == $replace['center']) echo 'selected';
                    echo '>' . $res->name . '</option>';
                }
                ?>
            </select>
            <?php
            if (isset($errors['center'])) echo '<div class="invalid-feedback">' . $errors['center'] . '</div>';
            elseif (!$invalid) echo '<div class="valid-feedback">Valide</div>';
            ?>

        </div>

        <!-- Sujet -->
        <div class="form-group">
            <label for="subject">Sujet</label>
            <input type="text" name="subject" class="form-control<?php echo $val['subject']; ?>"
                   placeholder="Saisissez votre sujet" value="<?= $replace['subject']; ?>"/>
            <?php
            if (isset($errors['subject'])) echo '<div class="invalid-feedback">' . $errors['subject'] . '</div>';
            elseif (!$invalid) echo '<div class="valid-feedback">Valide</div>';
            ?>
        </div>

        <!-- Message -->
        <div class="form-group">
            <label for="message">Votre message</label>
            <textarea name="message" class="form-control<?= $val['message']; ?>"
                      placeholder="Saisissez votre message"><?= $replace['message'] ?></textarea>
            <?php
            if (isset($errors['message'])) echo '<div class="invalid-feedback">' . $errors['message'] . '</div>';
            elseif (!$invalid) echo '<div class="valid-feedback">Valide</div>';
            ?>
        </div>
        <br>

        <input type="submit" name="submit" value="Envoyer" class="btn btn-block border"/>
    </form>
    <br>


    <div class="container">
        <div class="row my-3">
            <?php
            $temp = $bdd->query('SELECT * FROM adress');
            while ($res = $temp->fetch()) {
                echo '<div class="col-sm-4 border"><address><strong>' . $res->name . ' </strong>
                    <br>' . $res->number . ' ' . $res->street . ',<br>'
                    . $res->cp . ' ' . $res->city . '<br>'
                    . $res->morning . '<br>'
                    . $res->tel . '<br>'
                    . '<a href="mailto:' . $res->email . '">' . $res->email . '</a></address></div>';
            }
            ?>
        </div>
        <iframe class="mb-3" src="https://www.google.com/maps/d/embed?mid=1xxHfy2yc6x_2Q7Xk_IiB77xvrISa3Afk"
                width="100%" height="480"></iframe>
    </div>
</div>
</body>
</html>