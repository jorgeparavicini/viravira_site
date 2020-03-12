<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/controls/slideshow.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
$id = $_GET['id'];
$excursion = null;
try {
    $excursion = Excursion::loadFromId($id);
} catch (Exception $e) {
    echo "<p>Could not find excursion</p>";
}
?>


<h1><?php echo $excursion->getTitle() ?></h1>
<p class="description"><?php echo $excursion->getMainDescription() ?></p>
<img src="/img/excursions/<?php echo $excursion->getThumbnail() ?>" alt="Excursion Thumbnail" id="thumbnail">

<?php
// Print optional descriptions like prerequisites
foreach ($excursion->getDescriptions() as $header => $description) {
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
    foreach ($excursion->getDetails() as $key => $detail) {
        ?>
		<div class="detail">
			<img src="<?php echo $detail["icon"] ?>" alt="detail icon">
			<h3 class="detail_title"><?php echo $key ?></h3>
			<p class="detail_value"><?php echo $detail["value"] ?></p>
		</div>
        <?php
    }
    ?>
</div>
<?php
$images = $excursion->getImages();
if (count($images) > 0) {
    ?>
	<h2>Gallery</h2>
    <?php
    $images = array_map(function ($image) {
        return "/img/excursions/{$image["url"]}";
    }, $images);
    createSlideshow($images, "excursions");
}
?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/js/gallery.js"></script>