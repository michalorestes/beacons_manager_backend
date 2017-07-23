<?php

include ('ServicesDatabase.php');
$db = new ServicesDatabase();
if (isset($_GET['id'])){
    $data = $db->getNoLikes($_GET['id']);

    echo $data;
}


?>