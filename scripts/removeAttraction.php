<?php
if (isset($_GET['id'])) {
  include('../Database.php');
  $db = new Database();
  $db->removeAttraction($_GET['id']);
}


 ?>
