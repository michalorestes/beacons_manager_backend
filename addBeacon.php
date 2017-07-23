<?php
include('templateFiles/header.php');
$output = '';
if (isset($_POST['addBeacon'])) {
  $db = new Database();
  $uuid = $_POST['uuid'];
  $output = $db->addBeacon($uuid);
}


?>
<div id="beaconsList" class="centerClass">
  <form method="post" action="addBeacon.php">
    <h1>Basic Info</h1>
    <ul id="basicInfo">
      <li><span class="fTitle">UUID:</span></li>

      <li><input class="simpleInput" type="text" name="uuid" /></li>
    </ul>
    <br  />
    <input type="submit" class="button3 floatRight" value="Add" name="addBeacon"/>
    <?php echo $output; ?>
  </form>
</div>
<?php
  include('templateFiles/footer.php');
 ?>
