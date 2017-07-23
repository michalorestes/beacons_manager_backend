<?php

include ('ServicesDatabase.php');
$db = new ServicesDatabase();
if (isset($_GET['id'])){
    $db->likeAttraction($_GET['id']);

}


?>