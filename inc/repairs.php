<?php
    require_once 'db.php';
    $type = empty($_GET['type']) ? 'model' : $_GET['type'];

    if($type === 'model'){
        $table = 'phones';
        $search = 'brand_id';
    }
    elseif ($type === 'repair' || $type === 'result'){
        $table = 'repairs';
        $search = 'tel_id';
    }
    else{
        echo 'Erreur : Marque ou modèle non reconnu(e)';
    }

    if ($type === 'result') {
        $temp1 = $bdd->prepare("SELECT a.*, b.name FROM $table as a, phones as b WHERE $search = ? AND b.id = ?");
        $temp1->execute([$_GET['filter'], $_GET['filter']]);

        $items = $temp1->fetchAll();

        header('Content-Type: application/json; charset = utf-8');
        echo json_encode(array_map(function ($items){
            return [
                'label' => $items->name,
                'value' => $items->id,
                'price' => $items->price,
                'description' => $items->description,
                'possible' => $items->possible,
                'time' => $items->needed_time,
                'on_command' => $items->on_command,
                'url' => $items->img_url
            ];
        }, $items));
    }
    else {
        $temp1 = $bdd->prepare("SELECT id, name FROM $table WHERE $search = ?");
        $temp1->execute([$_GET['filter']]);
        $items = $temp1->fetchAll();

        header('Content-Type: application/json; charset = utf-8');
        echo json_encode(array_map(function ($items){
            return [
                'label' => $items->name,
                'value' => $items->id
            ];
        }, $items));
    }
