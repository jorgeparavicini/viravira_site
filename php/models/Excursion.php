<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/SQLManager.php";
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


    /**
     * @return array The list of excursions
     */
    public static function loadAll(): array
    {
        $conn = SQLManager::createConnection(ConnectionType::Selection);
        $query = "SELECT excursion_id, title, type, thumbnail_url FROM excursion";
        $excursions = [];

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->execute();

                $stmt->bind_result($id, $title, $type, $thumbnail_url);

                while ($stmt->fetch()) {
                    array_push($excursions, new Excursion($title, $type, $thumbnail_url, $id));
                }

                $stmt->close();
            } else {
                return [];
            }
        } finally {
            $conn->close();
        }
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
     * @throws NotFoundException when the excursion with id was not found.
     */
    public static function loadFromId($id) {
        $conn = SQLManager::createConnection(ConnectionType::Selection);
    	$query = "SELECT excursion_id, title, type, thumbnail_url FROM excursion WHERE excursion_id = ?";

    	try {
    	    if($stmt = $conn->prepare($query)) {
    	        $stmt->bind_param("i", $id);
    	        $stmt->execute();
    	        $stmt->bind_result($id, $title, $type, $thumbnail_url);
    	        if(!$stmt->fetch()) {
    	            throw new NotFoundException("Did not find excursion");
                }
    	        return new Excursion($title, $type, $thumbnail_url, $id);
            }
        } finally {
            $conn->close();
        }
        return null;
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
        $conn = SQLManager::createConnection(ConnectionType::Selection);
    	$query = "SELECT header, description FROM excursion_description WHERE excursion_id = ?";
    	$descriptions = [];

    	try {
    	    if ($stmt = $conn->prepare($query)) {
    	        $stmt->bind_param("i", $this->id);
    	        $stmt->execute();
    	        $stmt->bind_result($header, $description);
    	        while ($stmt->fetch()) {
    	            if ($header === "Description") {
    	                $this->mainDescription = $description;
                    } else {
    	                $descriptions[$header] = $description;
                    }
                }
            }
        } finally {
            $conn->close();
        }

        $this->descriptions = $descriptions;
    }

    private function getIconForDetail($detailKey) {
        switch (strtolower($detailKey)) {
	        case "car distance":
	        	return "/img/icons/car_distance.svg";
	        case "difficulty":
	        	return "/img/icons/level.svg";
	        case "excursion distance":
	        	return "/img/icons/travel_distance.svg";
	        case "excursion duration":
	        	return "/img/icons/clock.svg";
	        case "price":
	        	return "/img/icons/price.svg";
	        case "season":
	        	return "/img/icons/sun.svg";
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

        $conn = SQLManager::createConnection(ConnectionType::Selection);
        $query = "SELECT detail_key, detail_value FROM excursion_detail WHERE excursion_id = ?";

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $this->id);
                $stmt->execute();
                $stmt->bind_result($key, $value);
                while ($stmt->fetch()) {
                    $icon = self::getIconForDetail($key);
                    $this->details[$key] = ["value" => $value, "icon" => $icon];
                }
            }
        } finally {
            $conn->close();
        }
    }



    /**
     * @throws Exception when the excursion has no id.
     */
    private function loadImages() {
        if ($this->id === null) {
            throw new Exception("Excursion has no id");
        }

        $conn = SQLManager::createConnection(ConnectionType::Selection);
        $query = "SELECT image_url, description FROM excursion_image WHERE excursion_id = ?";
        $images = [];

        try {
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $this->id);
                $stmt->execute();
                $stmt->bind_result($url, $description);
                while ($stmt->fetch()) {
                    array_push($images, ["url" => $url, "description" => $description]);
                }
            }
        } finally {
            $conn->close();
        }
        $this->images = $images;
    }
}