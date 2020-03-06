<?php
include_once("${$_SERVER['DOCUMENT_ROOT']}/php/controls/slideshow.php");

$id = $_GET['id'];

$servername = "localhost";
$username = "root";
$password = "1234";
$db = "viravira";
$conn = new mysqli($servername, $username, $password, $db);
// Check Connection
if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}

$sql = "SELECT excursion_id, title, type, thumbnail_url FROM excursion WHERE excursion_id = {$id}";
$result = $conn->query($sql);

$descriptions = getDescriptions($id, $conn);
$details = getDetails($id, $conn);
$images = getImages($id, $conn);

if ($result->num_rows != 1 || !array_key_exists("Description", $descriptions)) {
    echo "<h1>Excursion not found</h1>";
} else {
    $excursion = $result->fetch_assoc();
// Display page
    ?>
	<h1><?php echo $excursion['title'] ?></h1>
	<p class="description"><?php echo $descriptions["Description"] ?></p>
	<img src="../img/excursions/<?php echo $excursion['thumbnail_url'] ?>" alt="Excursion Thumbnail" id="thumbnail">

    <?php
    // Print optional descriptions like prerequisites
    foreach ($descriptions as $header => $description) {
        if (strtolower($header) == "description") continue;
        ?>
		<h2><?php echo $header ?></h2>
		<p><?php echo $description ?></p>
        <?php
    }
    ?>

	<h2>Details</h2>
	<div class="details">
        <?php
        foreach ($details as $key => $value) {
            ?>
			<div class="detail">
				<img src="<?php echo $value[1] ?>" alt="detail icon">
				<h3 class="detail_title"><?php echo $key ?></h3>
				<p class="detail_value"><?php echo $value[0] ?></p>
			</div>
            <?php
        }
        ?>
	</div>
	<?php
	if (count($images) > 0) {
		?>
        <h2>Gallery</h2>
        <?php
        $images = array_map(function ($image) {
            return "/img/excursions/{$image[0]}";
        }, $images);
        createSlideshow($images, "excursions");
	}

    $conn->close();
}


function getDescriptions($id, mysqli $conn)
{
    $sql = "SELECT header, description FROM excursion_description WHERE excursion_id = {$id}";
    $descriptionResult = $conn->query($sql);
    $descriptions = [];

    while ($description = $descriptionResult->fetch_assoc()) {
        $descriptions[$description['header']] = $description['description'];
    }

    return $descriptions;
}

function getDetails($id, mysqli $conn)
{
    $sql = "SELECT detail_key, detail_value FROM excursion_detail WHERE excursion_id = {$id}";
    $detailResult = $conn->query($sql);
    $details = [];

    while ($detail = $detailResult->fetch_assoc()) {
        $key = $detail['detail_key'];
        $value = $detail['detail_value'];
        $icon_name = getIconForDetail($key);
        $icon = "../img/icons/{$icon_name}";
        $details[$key] = [$value, $icon];
    }

    return $details;
}

// returns the icon name in the img/icons folder for a given detail name
function getIconForDetail($detail)
{
    switch (trim(strtolower($detail))) {
        default:
            return "missing.svg";
    }
}

function getImages($id, mysqli $conn)
{
    $sql = "SELECT image_url, description FROM excursion_image WHERE excursion_id = {$id}";
    $imageResult = $conn->query($sql);
    $images = [];
    while ($image = $imageResult->fetch_assoc()) {
        array_push($images, [$image['image_url'], $image['description']]);
    }
    return $images;
}


?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/js/gallery.js"></script>