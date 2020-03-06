<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/controls/slideshow.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Excursion.php";
?>

<h1>Excursions</h1>
<h4>
	Travelling is more than visiting a place. It is about exploring, immersing and connecting. At Vira Vira we
	invite you to discover hidden places in beautiful national parks together with one of our trained hotel guides. A
	seamless experience, just like spending time with local friends.
	You can customize your adventure with us and set out in small groups of 6 to 8 people, or choose the private
	option with personal guide.
	Get inspired, take off and capture the magic of the south of Chile where nature is wild, alive and abundant.
</h4>

<h3>Explore Nature</h3>
<p>
	What is your preferred way to explore?. Why not taking advantage of our full excursion menu?. We take you
	hiking, accompany you on bike tours or you can discover private trails on treks with authentic Chilean horses.
	Whatever
	your preferences are, choose half day trips where you come back for a savory lunch to the hotel or set out for a
	full
	day adventure with picnic prepared by Chef Damian’s gourmet team.
</p>

<?php
// Create the Nature Gallery
$images = ["/img/nature/explore1.jpg", "/img/nature/explore2.jpg", "/img/nature/explore3.jpg",
    "/img/nature/explore4.jpg", "/img/nature/explore5.jpg", "/img/nature/explore6.jpg"];
createSlideshow($images, "nature");
?>

<h3>Rivers, Lakes and Waterfalls</h3>
<p>
	Flowing down a quiet stream or rafting in white water – Pucón is famous for its waters. You can start right at
	the Hotel floating down Liucura river or we provide fishing gear for you to try catch and release. Felipe is our
	local specialist. He knows where salmon and rainbow trout have their habitat. If you are in for some fun and
	adrenalin, try stand up paddle or canoying. And if contemplation is more your way of enjoying water, we know many
	hidden
	and private waterfalls.
</p>

<?php
// Create the Rivers lakes and waterfalls Gallery
$images = ["/img/experience/experience-gallery3-2.jpg", "/img/experience/experience-gallery3-3.jpg",
    "/img/experience/experience-gallery3-4.jpg", "/img/experience/experience-gallery3-5.jpg",
    "/img/experience/experience-gallery3-6.jpg", "/img/experience/experience-gallery3-7.jpg",
    "/img/experience/experience-slider3-1.jpg", "/img/experience/stand-up-paddle.jpg"];
createSlideshow($images, "rivers");
?>

<h3>Culture and Hacienda Life</h3>
<p>
	The Mapuche people consider Villarica Volcano or Ruka Pillán as the “House of the Spirit of the Ancestors”.
	Deeply connected with “mother earth” they live a simple and yet rich life. Their knowledge of food, seasons and
	cooking accordingly is a very contemporary message. On a visit to a “Ruka”(House) and meeting with real people you
	learn about traditions first hand. In accordance with the Mapuche lifestyle the working Farm at Vira Vira produces
	fine foods including seasonal vegetables. We invite you to get to know Hacienda life and participate in
	activities like Yoga with Claudia, cooking classes, wine and cheese tastings, learning about processing milk
	in the hacienda cheese dairy or enjoying the Vira Vira parks,
	trails and the presence of Liucura river and Ruka Pillán.
</p>

<?php
// Create the Culture Gallery
$images = ["/img/yoga/experience1.jpg", "/img/yoga/experience2.jpg", "/img/yoga/experience3.jpg",
    "/img/yoga/experience4.jpg", "/img/yoga/experience5.jpg", "/img/yoga/yoga-experience.jpg"];
createSlideshow($images, "culture");
?>

<h2>Explore our Excursions</h2>

<?php
// Load the excursions
$excursions = Excursion::loadAllOrdered();
foreach ($excursions as $type => $excursionList) {
    ?>
	<h3><?php echo $type ?></h3>
	<div class="cards">
        <?php
        /* @var $excursion Excursion */
        foreach ($excursionList as $index => $excursion) {
            $excursion->echoExcursionHtml("excursion{$index}");
        }
        ?>
	</div>
    <?php
}
?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/js/gallery.js"></script>