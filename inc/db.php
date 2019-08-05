<?php
    //$bdd = new PDO('mysql:dbname=skysylveej57;host=skysylveej57.mysql.db;charset=UTF-8','skysylveej57','Erkam2008');
$bdd = new PDO('mysql:dbname=digicom;host=127.0.0.1:3306', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$bdd-> exec("set names utf8");