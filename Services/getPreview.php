<?php

include ('ServicesDatabase.php');
$db = new ServicesDatabase();
if (isset($_GET['id'])){
    $data = $db->getAttractionPreview($_GET['id']);

    echo $data;
}


?>