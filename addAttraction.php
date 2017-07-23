<?php
include('templateFiles/header.php');
$db = new Database();
$output = '';

if (isset($_POST['btnNext']) ) {
  if (isset($_POST['beacon']) && $_POST['beacon'] != '0') {
    //add attraction to databse
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $videoID = $_POST['video'];
    $output = $db->addAttraction($name, $description, $location, $videoID);
    //check if attraction has been added successfully,
      //to assign beacon
    if ($output === TRUE) {
      $attractionID = $db->getMostRecentAttraction();
      //get UUID of selected beacon
      $beacon = $_POST['beacon'];
      //assign attraction to chosen beacon
      $db->assignBeacon($beacon, $attractionID);
      //redirect to next (adding translation to this attraction)
      header('Location: addAttractionTranslation.php?id='. $attractionID);
    }
  } else {
    $output = '<span style="font-size: 9pt; color: red;">Attraction must have beacon assigned to it</span>  ';
  }

}
//populate drop down list with beacon UUIDs
$beacons = $db->getBeacons();
$html = '';
foreach ($beacons as $value) {
  //check if beacon is assigned to other Attraction
  //AttractionID = 0, no assignmen
  if ($value['AttractionID'] == '0') {
    $html .= '<option value="'.$value['UUID'].'">'.$value['UUID'].'</option>';
  }

}

?>

<div id="beaconsList" class="centerClass">
  <form method="post" action="addAttraction.php">
    <h1>Basic Info</h1>

    <ul id="basicInfo">
      <?php echo $output; ?>

          <li>
            <select name="beacon">
                <option value="0">Assign beacon...</option>
              <<?php echo $html; ?>
            </select>
          </li>
        <li><input onclick="clearInput(this)" class="simpleInput" type="text" name="name" value="Title..." /></li>
        <li><input onclick="clearInput(this)" class="simpleInput" type="text" name="location" value="Location..."/></li>
        <li><input onclick="clearInput(this)" class="simpleInput" type="text" name="video" value="Video ID..."/></li>
        <li><textarea onclick="clearInput(this)" class="textArea" name="description" onkeyup="charCount(this)">Description...</textarea></li>
        <li><span id="smallText">Characters left: 1000</span> </li>
    </ul>
    <input type="submit" class="button3 floatRight" value="Next" name="btnNext" />
  </form>
</div>

<script>
    function clearInput(element) {
        if (element.innerHTML === "Description..."){
            element.innerHTML = "";
        }

        switch (element.value){
            case "Title...":
                element.value = "";
                break;
            case "Location...":
                element.value = "";
                break;
        }
    }

    function charCount(element) {
        var countString = element.value.length;
        document.getElementById('smallText').innerHTML = "Characters left: " + (1000 - countString);
        if (element.value.length >= 1000){
            $("smallText").style("color", "red");
        }
    }
</script>
<?php
  include('templateFiles/footer.php');
 ?>
