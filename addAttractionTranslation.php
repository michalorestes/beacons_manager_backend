<?php
include('templateFiles/header.php');
$self = basename($_SERVER['PHP_SELF']) . '?id='. $_GET['id'];

if (isset($_POST['btnNext']) && isset($_POST['translationText'])) {
  $db = new Database();
  $attractionID = $_GET['id'];
  $languages = $_POST['language'];
  $translations = $_POST['translationText'];
  for($i = 0; $i < sizeof($languages); $i++){
    $db->addTranslation($attractionID, $languages[$i], $translations[$i]);
  }


  header('Location: addAttractionImages.php?id=' . $_GET['id']);
}
?>

<div id="beaconsList" class="centerClass">
  <form method="post" action="<?php echo $self; ?>">
    <h1>Translations</h1>
    <div id="translation">
      <ul id="basicInfo">
          <li id="translationsDropdown">
            <select name="language[]">
              <option value="Spanish">Spanish</option>
              <option value="Polish">Polish</option>
              <option value="French">French</option>
            </select>
          </li>
          <li><textarea name="translationText[]"> </textarea></li>
      </ul>
    </div>

      <div class="floatRight">
          <button  onclick="return addTranslationBox()">Add Translation</button>
          <button  onclick="return removeTranslation()">Remove Translation</button>
      </div>
    <br /> <br /> <br />
    <input type="submit" class="button3 floatRight" value="Next" name="btnNext" />
  </form>
</div>

<script>
  function addTranslationBox(){
    var html = '<ul id="basicInfo"><li id="translationsDropdown"><select name="language[]">'
                +'<option value="Spanish">Spanish</option><option value="Polish">Polish</option>'
                +'<option value="French">French</option></select></li>'
                +'<li><textarea name="translationText[]"> </textarea></li></ul>';

    $('#translation').append(html);

    return false;
  }

  function removeTranslation(){
    var container = document.getElementById('translation');
    $('#translation').children().last().remove();
    return false;
  }
</script>

<?php
  include('templateFiles/footer.php');
 ?>
