<?php
$output = '';
//below code has been adapted from
//https://www.w3schools.com/php/php_file_upload.asp
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

  $tempName = (isset($_FILES["fileToUpload"]["tmp_name"])) ? $_FILES["fileToUpload"]["tmp_name"] : null;
  $size = (isset($_FILES["fileToUpload"]["size"])) ? $_FILES["fileToUpload"]["size"] : null;
  $name = (isset($_FILES["fileToUpload"]["name"])) ? $_FILES["fileToUpload"]["name"] : null;

  /*if ($tempName != null && $size != null && $name != null) {
    $check = getimagesize($tempName);
    if($check !== false) {
        $output =  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $output =  "File is not an image.";
        $uploadOk = 0;
    }
}*/
// Check if file already exists
if (file_exists($target_file)) {
    $output =  "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size

/*if ($size > 1000000) {
    $output =  "Sorry, your file is too large.";
    $uploadOk = 0;
}*/
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $output =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $output =  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($tempName, $target_file)) {
        $output =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $imageurl = 'http://172.18.30.254:8080/BeaconsManager/uploads/' . basename($name);
        $db = new Database();
        $db->addImage($_GET['id'], $imageurl);
    } else {
        $output =  "Sorry, there was an error uploading your file.";
    }
  }
}



?>
