<?php
include('Database.php');

$db = new Database();
echo !$db->getActivationStatus(12);
?>
