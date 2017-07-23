<?php
include('templateFiles/header.php');
$db = new Database();
$attractions = $db->getAttractions();
asort($attractions);
?>

<div id="beaconsList" class="centerClass">
  <table class="gridView">

    <tr>
        <th id="tID">ID</th>
        <th id="tUUID">UUID</th>
        <th id="tLocation">Location</th>
        <th id="tName">Name</th>
        <th id="tViews">Views</th>
        <th id="tLikes">Likes</th>
        <th id="tOptions">Options</th>
        <th id="tAction">Action</th>
    </tr>

    <?php foreach ($attractions as $value) {
        $id = $value['AttractionID'];
        $activation = ($value['Activated'] == 0) ? 'Activate' : 'Deactivate';
    ?>
    <tr>
        <td id="tID"><?php echo $value['AttractionID'] ?></td>
        <td id="tUUID"><?php echo $value['UUID'] ?></td>
        <td id="tLocation"><?php echo $value['Location'] ?></td>
        <td id="tName"><?php echo $value['Title'] ?></td>
        <td id="tViews"><?php echo $value['Views'] ?></td>
        <td id="tLikes"><?php echo $value['Likes'] ?></td>
        <td id="tOptions"><button onclick="interaction('scripts/beaconActivation.php?id=' + this.value, this,activation)" class="tableBtn" value="<?php echo $id;?>"><?php echo $activation; ?></button></td>
        <td id="tAction"><button onclick="interaction('scripts/removeAttraction.php?id=' + this.value, this,removeRow)" class="tableBtn" value="<?php echo $id;?>">Delete</button></td>
    </tr>
      <?php } ?>
  </table>
</div>

<script>

    function interaction(url, element, myFunction) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          myFunction(element, xhttp);
        }
      };
      xhttp.open("GET", url, true);
      xhttp.send();
    }

    function removeRow(element, xhttp){
      $(".gridView tr").each(function() {
          var row = $(this);
          var match = row.find("#tID");
    
          // note the `==` operator
          if(match.text() == element.value) {
            //  thisRow.hide();
              row.remove();
          }
      });
    }

    function activation(element, xhttp){
      var result = xhttp.responseText;
      //if beacon has been deactivated
      if (result === '0') {
        element.innerText = 'Activate';
      }
      //if beacon has been Activated
      else if (result === '1') {
        element.innerText = 'Deactivate';
      }
    }


</script>

<?php
  include('templateFiles/footer.php');
 ?>
