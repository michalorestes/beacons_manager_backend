<?php

/**
 * Created by IntelliJ IDEA.
 * User: Michal
 * Date: 30/03/2017
 * Time: 15:52
 */
class ServicesDatabase
{
    private $servername = "localhost";
    private $username = "Michal";
    private $password = "Gr33nwich";
    private $dbname = "lookout";
    public $sql = NULL;

    public function __construct()
    {
        $this->sql = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    function getAttractionPreview($id){
        $query = "SELECT attractions.*, images.* FROM attractions 
INNER JOIN images on images.AttractionID = (SELECT images.AttractionID FROM images WHERE images.AttractionID = {$id} ORDER BY images.AttractionID desc limit 1)
 WHERE attractions.AttractionID = {$id} LIMIT 1";

        $result = $this->sql->query($query);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data = array('AttractionID' => $row['AttractionID'] , 'Title' => $row['Title'],
                'Description' => $row['Description'], 'Location' => $row['Location'], 'Views' => $row['Views'],
                'Likes' => $row['Likes'], 'ImageURL' => $row['ImageURL']);
        }
        return $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 10);;
    }
    function getAttraction($uuid){
        $query = 'SELECT * FROM lookout.beacons INNER JOIN lookout.attractions on beacons.AttractionID = attractions.AttractionID WHERE beacons.UUID = "' . $uuid . '"';

        $result = $this->sql->query($query);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data = array('AttractionID' => $row['AttractionID'] , 'Title' => $row['Title'],
                'Description' => $row['Description'], 'Location' => $row['Location'], 'Views' => $row['Views'],
                'Likes' => $row['Likes'], 'Video' => $row['Video'], 'UUID' => $row['UUID'], 'Activated' => $row['Activated']);
        }
        return $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 10);
    }

    function getAttractionGallery($id){
        $query = 'SELECT * FROM lookout.images WHERE AttractionID = ' . $id;
        $result = $this->sql->query($query);
        $data = array();
       /* while ($row = $result->fetch_assoc()) {
            $data = array('ImageID' => $row['ImageID'], 'AttractionID' => $row['AttractionID'] ,
                'ImageURL' => $row['ImageURL']);
        }*/
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row['ImageURL']);
        }
        return $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 10);
    }

    function likeAttraction($id){
        $likes = $this->getNoLikesInt($id);



        $query = 'UPDATE lookout.attractions SET Likes ='.($likes + 1).'  WHERE AttractionID = '.$id;
        return $this->sql->query($query);
    }

    function getNoLikes($id) {
        $query = 'SELECT attractions.Likes FROM lookout.attractions WHERE AttractionID = ' . $id;
        $result = $this->sql->query($query);
        $likes = '';
        while ($row = $result->fetch_assoc()) {
            $likes = $row['Likes'];
        }
        return $json = json_encode($likes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 10);
    }

    function getNoLikesInt($id) {
        $query = 'SELECT attractions.Likes FROM lookout.attractions WHERE AttractionID = ' . $id;
        $result = $this->sql->query($query);
        $likes = '';
        while ($row = $result->fetch_assoc()) {
            $likes = $row['Likes'];
        }
        return (int)$likes;
    }

    function comment($attractionID, $comment){

    }

    function getTranslation($id){
        $query = 'SELECT * FROM lookout.translations WHERE AttractionID = ' . $id;
        $result = $this->sql->query($query);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $lang = $row['Language'];
            $data[$lang] = $row['Translation'];
        }


        return $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 10);
    }





}