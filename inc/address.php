
<h4 class="text-center">Nous joindre</h4>
<?php
    require_once 'db.php';
    $temp = $bdd->query('SELECT * FROM adress');
    while($res = $temp->fetch()) {
        echo '<div class=""><address><strong>' . $res->name . ' </strong><br>' . $res->number . ' ' . $res->street . ',<br>'
            . $res->cp . ' ' . $res->city . '<br>' . $res->morning . '</address></div>';
    }
    ?>
<button class="btn btn-secondary mx-auto mb-1" onclick="window.location='contact.php';">Plus d'informations</button>