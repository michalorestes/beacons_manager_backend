<?php

include ('ServicesDatabase.php');
$db = new ServicesDatabase();
if (isset($_GET['id'])){
    $data = $db->getTranslation($_GET['id']);
    echo $data;
}


?>