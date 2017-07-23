<?php
class Database
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

	//get login data
	public function getLogin($username){
		$query = 'SELECT * FROM lookout.users WHERE Username = "' . $username .'"';
		$result = $this->sql->query($query);
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data = array('username' =>  $row['Username'],'password' => $row['Password']);
		}

		return $data;

	}

	function addBeacon($uuid){
		if ($uuid === null || $uuid === '' || strlen($uuid) < 36) {
			return '<span style="font-size: 9pt; color: red;">Value must be not empty and consist of 16 characters</span>';
		}

		$query = 'INSERT INTO lookout.beacons (UUID, AttractionID, Activated) VALUES ("'.$uuid.'", 0, 0)';

		if ($this->sql->query($query) === TRUE) {
			return '<span style="font-size: 9pt; color: red;">Beacon added successfully</span>';
		} else {
			return '<span style="font-size: 9pt; color: red;">Could not add to database</span>';
		}

		return NULL;
	}

	function getBeacons(){
		$query = 'SELECT * FROM lookout.beacons';
		$result = $this->sql->query($query);
		$data = array();
		while ($row = $result->fetch_assoc()) {
			array_push($data, array('UUID' => $row['UUID'] , 'AttractionID' => $row['AttractionID'], 'Activated' => $row['Activated']));
		}
		return $data;
	}

	function assignBeacon($beacon, $attractionID){
		$query = 'UPDATE lookout.beacons SET AttractionID='.$attractionID.'  WHERE UUID = "'.$beacon.'"';
		$this->sql->query($query);
	}

	//add attractions
	function addAttraction($title, $description, $location, $videoID){
		if ($title === null || $title === '' || $description === null || $description === '' || $location === null || $location === '') {
			return '<span style="font-size: 9pt; color: red;">Value must be not empty</span>';
		}

		$query = 'INSERT INTO lookout.attractions (Title, Description, Location, Views, Likes, Video)'.
		'VALUES ("'.$title.'", "'.$description.'", "'.$location.'", '. 0 .', '. 0 .',"'.$videoID.'");';

		if ($this->sql->query($query) === TRUE) {
			return TRUE;
		} else {
			return '<span style="font-size: 9pt; color: red;">Could not add to database</span>' . $query;
		}
		return NULL;
	}

	function getMostRecentAttraction(){
		$query = 'SELECT * FROM attractions ORDER BY AttractionID desc limit 1;';
		$result = $this->sql->query($query);
		while ($row = $result->fetch_assoc()) {
			return $row['AttractionID'];
		}
		return null;
	}

	//add translation
	function addTranslation($attractionID, $language, $translation){
		if (strlen($translation) <= 1) {
			return null;
		}
		$query = 'INSERT INTO lookout.translations (AttractionID, Language, Translation)'
		.'VALUES ('.$attractionID.', "'.$language.'", "'.$translation.'");';

		if ($this->sql->query($query) === TRUE) {
			return TRUE;
		} else {
			return '<span style="font-size: 9pt; color: red;">Could not add to database</span>' . $query;
		}
		return null;
	}

	function addImage($attractionID, $imageURL){
		$query = 'INSERT INTO lookout.images (AttractionID, ImageURL)'
		.'VALUES ('.$attractionID.', "'.$imageURL.'")';

		if ($this->sql->query($query) === TRUE) {
			return TRUE;
		} else {
			return '<span style="font-size: 9pt; color: red;">Could not add to database</span>' . $query;
		}

		return null;
	}

	//get list of attractions
	function getAttractions(){
		$query = 'SELECT lookout.attractions.AttractionID, lookout.attractions.Video, lookout.attractions.Title,'
		.' lookout.attractions.Location, lookout.attractions.Views, lookout.attractions.Likes,'
		.' lookout.beacons.Activated, lookout.beacons.UUID FROM lookout.beacons'
		.' INNER JOIN lookout.attractions'
		.' WHERE lookout.attractions.AttractionID = lookout.beacons.AttractionID';

		$result = $this->sql->query($query);
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[$row['AttractionID']] = array('AttractionID' => $row['AttractionID'],
			 'Title' => $row['Title'] , 'Location' => $row['Location'],
			 'Views' => $row['Views'], 'Likes' => $row['Likes'], 'Activated' => $row['Activated'],
		 		'UUID' => $row['UUID'], 'Video' => $row['Video']);
		}
		return $data;
	}

	function getActivationStatus($attractionId){
		$query = 'SELECT lookout.beacons.Activated FROM lookout.beacons WHERE lookout.beacons.AttractionID = ' . $attractionId;

		$result = $this->sql->query($query);
		$data = '';
		while ($row = $result->fetch_assoc()) {
			$data = $row['Activated'];
		}
		return $data;
	}

	//set beacon activation status based on assiged attraction
	function setActivationStatus($status, $id){
		$query = 'UPDATE lookout.beacons SET Activated='.$status.'  WHERE AttractionID = '.$id;
		if ($this->sql->query($query) == TRUE) {
			//if updated sucessfully, return new status
			return $status;
		} else {
			//if update failed return unchanged status
			return ($status == 1) ? 0 : 1;
		}
		return null;
	}

	//get beacon assigned to specific attraction
	function removeBeaconAssociation($attractionID){
		$query = 'UPDATE lookout.beacons SET AttractionID = 0  WHERE AttractionID = '. $attractionID;
		if ($this->sql->query($query) == TRUE) {
			return TRUE;
		}
		return null;
	}

	function removeTranslationAssociation($attractionID){
		$query = 'DELETE FROM lookout.translations WHERE AttractionID= '. $attractionID;
		if ($this->sql->query($query) == TRUE) {
			return TRUE;
		}
		return null;
	}

	function removeImagesAssociation($attractionID){
		$query = 'DELETE FROM lookout.images WHERE AttractionID= '. $attractionID;
		if ($this->sql->query($query) == TRUE) {
			return TRUE;
		}
		return null;
	}
	//remove attractions
	function removeAttraction($id){
			$this->setActivationStatus(0, $id);
			$this->removeBeaconAssociation($id);
			$this->removeTranslationAssociation($id);
			$this->removeImagesAssociation($id);
			$query = 'DELETE FROM lookout.attractions WHERE AttractionID= '. $id;
			if ($this->sql->query($query)) {
				return TRUE;
			}
			return null;
	}

    public function testMethod()
		{
        $query = "INSERT INTO lookout.beacons (`UUID`,`AttractionID`,`Activated`)
									VALUES ('Samsssssss	ple', 1,1);";
        if ($this->conn->query($query) === TRUE)
				{
          return "New record created successfully";
        }
			return "ERROR";
    }

	}
?>
