<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  if ($id > 0) {
    include('../Database.php');
    $db = new Database();
    $currentStatus = $db->getActivationStatus($id);
    $newStatus = '';
    if ($currentStatus == 0) {
      $newStatus = 1;
    } else {
      $newStatus = 0;
    }
    $updated = $db->setActivationStatus($newStatus, $id);
    echo $updated;
  }
}
 ?>
