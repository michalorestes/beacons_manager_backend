<?php
include('templateFiles/header.php');
$db = new Database();
$attractions = $db->getAttractions();
asort($attractions);

$html = '';
foreach ($attractions as $value){
    $id = $value['AttractionID'];
    $title = $value['Title'] . ' ';
    $html .= '<option value="'.$id.'">'.$title.$id.'</option>';
}
?>

<div id="beaconsList" class="centerClass">
    <div class="padding">
        <div id="output" class="floatRight">
            <pre id="json"></pre>
        </div>

        <div class="floatLeft" id="options">
            <h1>Web Services</h1>
            Chose attraction:
            <select id="list" name="list">
                <?php
                echo $html;
                ?>
            </select>
            <br /> <br />
            <button onclick="processResults('Services/getPreview.php', getPreview)" name="getPreview">Get preview</button>
            <button onclick="processResults('Services/getAttraction.php', getPreview)" name="getAtraction">Get attraction</button>
            <button onclick="processResults('Services/getGallery.php', getPreview)" name="getAtraction">Get gallery</button>
            <button onclick="processResults('Services/getLikes.php', getPreview)" name="getAtraction">Get likes</button>
            <button onclick="processResults('Services/addLike.php', execute)" name="getAtraction">Add like</button> <br /> <br />
            <button onclick="processResults('Services/getTranslations.php', getPreview)" name="getTranslations">Get translations</button>
        </div>
    <br />
    </div>

</div>

<script>
    var output = document.getElementById('json');
    var list = document.getElementById('list');

    function processResults(url, myFunction) {
        var param = '?id='+list.options[list.selectedIndex].value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {


                myFunction(this);
            }
        };
        xhttp.open("GET", url+param, true);
        xhttp.send();
    }

    function getPreview(xhttp) {
        //var data = JSON.parse(xhttp.responseText);

        output.innerHTML = xhttp.responseText;
    }
    
    function execute() {
        return null;
    }

</script>

<?php
include('templateFiles/footer.php');
?>
