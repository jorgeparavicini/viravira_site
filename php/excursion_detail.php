<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Excursion | Hotel Vira Vira</title>

	<meta name="description"
	      content="Hotel Vira Vira give life to a new way of enjoying holidays, combined with adventure.
         In a unique and privileged location close to Pucon.">

	<link rel="manifest" href="../site.webmanifest">
	<link rel="apple-touch-icon" href="../img/icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#fafafa">

	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/excursion_detail.css">
	<link rel="stylesheet" href="../css/gallerySlideshow.css">
</head>
<body>
<?php
include("../html/header.html");
?>
<?php
$id = $_POST['id'];

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
    include("../html/excursion_not_found.html");
} else {
    $excursion = $result->fetch_assoc();
// Display page
    ?>
	<h1><?php echo $excursion['title'] ?></h1>
	<p class="description"><?php echo $descriptions["Description"] ?></p>
	<img src="../img/excursions/<?php echo $excursion['thumbnail_url'] ?>" alt="Excursion Thumbnail" id="thumbnail">
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
	<h2>Gallery</h2>
	<section id="culture" class="gallery">
		<div class="slider">
			<div class="slide_viewer">
				<div class="slide_group">
                    <?php
                    $count = 0;
                    foreach ($images as $image) {
                        ?>
						<img src="../img/excursions/<?php echo $image[0] ?>"
						     alt="<?php echo "{$excursion['title']} {$count}" ?>"
						     class="slide"
                        <?php
	                    $count++;
                    }
                    ?>
				</div>
			</div>
		</div>
		<div class="directional_nav">
			<div class="previous_btn" title="Previous">
				<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px" y="0px"
				     viewBox="0 0 477.175 477.175" xml:space="preserve"
				     width="512px" height="512px">
				<g>
					<g>
						<path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225   c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"
						      class="active-path" fill="#424241"/>
					</g>
				</g>
			</svg>
			</div>
			<div class="slide_buttons">
			</div>
			<div class="next_btn" title="Next">
				<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px" y="0px"
				     viewBox="0 0 477.175 477.175" xml:space="preserve"
				     width="512px" height="512px">
				<g>
					<g>
						<path d="M360.731,229.075l-225.1-225.1c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1l215.5,215.5l-215.5,215.5   c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-4l225.1-225.1C365.931,242.875,365.931,234.275,360.731,229.075z   "
						      class="active-path" fill="#424241"/>
					</g>
				</g>
			</svg>
			</div>
		</div>
	</section>
    <?php

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
        $icon = "../img/icons/placeholder";
        switch ($key) {
            case "Car distance":
                $icon = "";
        }
        $details[$key] = [$value, $icon];
    }

    return $details;
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
<script src="../js/gallery.js"></script>
</body>
</html>
