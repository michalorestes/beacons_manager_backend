<?php
include('templateFiles/header.php');
$self = basename($_SERVER['PHP_SELF']) . '?id='. $_GET['id'];
$output = '';
if (isset($_POST['submit'])) {

  include('scripts/imageUpload.php');
}
?>

<div id="beaconsList" class="centerClass">
  <form action="<?php echo $self; ?>" method="post" enctype="multipart/form-data">
    <h1>Upload Images</h1>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    <br />
    <?php echo '<span style="font-size: 9pt; color: red;">'.$output .' </span>'; ?>
    <br  />
    <button name="btnDone" class="button3 floatRight" onclick="return done()">Done</button>
</form>
</div>

<script>
  //redirect user back to main page when finished adding attraction
  function done(){
    window.location.href = 'beacons.php';
    return false;
  }

</script>


<?php
  include('templateFiles/footer.php');
 ?>
