<?php

class Excursion
{
    private $title;
    private $type;
    private $thumbnail;
    private $id;
    private $images;
    private $mainDescription;
    private $descriptions;
    private $details;

    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "1234";
    private static $db = "viravira";

    public static function createSession()
    {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$db);
        if ($conn->connect_error) {
            die("Connection failed: {$conn->connect_error}");
        }
        return $conn;
    }

    public static function loadAll(): array
    {
        $sql = "SELECT * FROM excursion";
        $conn = self::createSession();
        $result = $conn->query($sql);

        $excursions = [];
        while ($row = $result->fetch_assoc()) {
            $excursion = new Excursion($row['title'], $row['type'], $row['thumbnail_url'], $row['excursion_id']);
            array_push($excursions, $excursion);
        }

        $conn->close();
        return $excursions;
    }

    public static function loadAllOrdered() {
        $excursions = self::loadAll();
        $result = [];
        /* @var $excursion Excursion */
        foreach ($excursions as $excursion) {
            if (!array_key_exists($excursion->getType(), $result)) {
                $result[$excursion->getType()] = [$excursion];
            } else {
                array_push($result[$excursion->getType()], $excursion);
            }
        }

        return $result;
    }

    /**
     * @param $id int The id to search for.
     * @return Excursion The excursion with the id.
     * @throws Exception when the excursion with id was not found.
     */
    public static function loadFromId($id) {
    	$sql = "SELECT * FROM excursion WHERE excursion_id = {$id}";
    	$conn = self::createSession();
    	$result = $conn->query($sql);
    	if ($result->num_rows != 1) {
    		throw new Exception("Did not find excursion");
	    }
		$row = $result->fetch_assoc();
    	$conn->close();
		return new Excursion($row['title'], $row['type'], $row['thumbnail_url'], $row['excursion_id']);
    }

    public function __construct($title, $type, $thumbnail, $id)
    {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
    }



    public function echoExcursionHtml($alternateText)
    {
        ?>
		<a class="card excursion"
		   href="/excursion?id=<?php echo $this->id ?>">
			<img src="/img/excursions/<?php echo $this->thumbnail ?>"
			     alt="<?php echo $alternateText ?>"/>
			<p><?php echo $this->title ?></p>
		</a>
        <?php
    }

    public function getTitle() {
    	return $this->title;
    }

    public function getType() {
    	return $this->type;
    }

    public function getThumbnail() {
    	return $this->thumbnail;
    }

    public function getId() {
    	return $this->id;
    }

    public function getMainDescription() {
    	if ($this->mainDescription == null) {
    		try {
    			$this->loadDescription();
		    } catch(Exception $e) {
    			return "";
		    }
	    }
    	return $this->mainDescription;
    }

    public function getImages() {
    	if ($this->images == null) {
    		try {
                $this->loadImages();
            } catch (Exception $e) {
    			return [];
		    }
	    }
    	return $this->images;
    }

    public function getDetails() {
    	if ($this->details == null) {
    		try {
    			$this->loadDetails();
		    } catch (Exception $e) {
    			return [];
		    }
	    }
    	return $this->details;
    }

    public function getDescriptions() {
    	if ($this->descriptions == null) {
    		try {
    			$this->loadDescription();
		    } catch (Exception $e) {
    			return [];
		    }
	    }
    	return $this->descriptions;
    }

    /**
     * @throws Exception when the excursion has no id.
     */
    private function loadDescription() {
    	if ($this->id === null) {
            throw new Exception("Excursion has no id");
        }
    	$sql = "SELECT header, description FROM excursion_description WHERE excursion_id = {$this->id}";
    	$conn = self::createSession();
    	$descriptionResult = $conn->query($sql);
    	$descriptions = [];

    	while ($description = $descriptionResult->fetch_assoc()) {
    		$header = $description['header'];
    		$value = $description['description'];
    		if ($header == "Description")
		    {
		    	$this->mainDescription = $value;
		    } else {
    			$descriptions[$header] = $value;
		    }
	    }
    	$this->descriptions = $descriptions;
    	$conn->close();
    }

    private function getIconForDetail($detailKey) {
        switch ($detailKey) {
            default:
                return "/img/icons/missing.svg";
        }
    }

    /**
     * @throws Exception when the excursion has no id.
     */
    private function loadDetails() {
    	if ($this->id === null) {
            throw new Exception("Excursion has no id");
	    }

        $sql = "SELECT detail_key, detail_value FROM excursion_detail WHERE excursion_id = {$this->id}";
    	$conn = self::createSession();
        $detailResult = $conn->query($sql);
        $details = [];

        while ($detail = $detailResult->fetch_assoc()) {
            $key = $detail['detail_key'];
            $value = $detail['detail_value'];
            $icon = self::getIconForDetail($key);
            $details[$key] = [$value, $icon];
        }

        $this->details = $details;
        $conn->close();
    }



    /**
     * @throws Exception when the excursion has no id.
     */
    private function loadImages() {
        if ($this->id === null) {
            throw new Exception("Excursion has no id");
        }

        $sql = "SELECT image_url, description FROM excursion_image WHERE excursion_id = {$this->id}";
        $conn = self::createSession();
        $imageResult = $conn->query($sql);
        $images = [];
        while ($image = $imageResult->fetch_assoc()) {
            array_push($images, [$image['image_url'], $image['description']]);
        }

        $this->images = $images;
        $conn->close();
    }
}