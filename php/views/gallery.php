<h1 id="title">Highlights</h1>
<?php
	// Create a slideshow
	include_once "{$_SERVER['DOCUMENT_ROOT']}/php/controls/slideshow.php";
	$images = ["/img/spa1.jpg", "/img/spa2.jpg", "/img/spa3.jpg", "/img/spa4.jpg"];
	createSlideshow($images, "spa");
?>
<h2>Gallery</h2>
<section id="gallery">
	<a href="/img/Gallery/gallery1.jpg"><img src="/img/Gallery/gallery1.jpg" alt="Gallery Image 1"></a>
	<a href="/img/Gallery/gallery2.jpg"><img src="/img/Gallery/gallery2.jpg" alt="Gallery Image 2"></a>
	<a href="/img/Gallery/gallery3.jpg"><img src="/img/Gallery/gallery3.jpg" alt="Gallery Image 3"></a>
	<a href="/img/Gallery/gallery4.jpg"><img src="/img/Gallery/gallery4.jpg" alt="Gallery Image 4"></a>
	<a href="/img/Gallery/gallery5.jpg"><img src="/img/Gallery/gallery5.jpg" alt="Gallery Image 5"></a>
	<a href="/img/Gallery/gallery6.jpg"><img src="/img/Gallery/gallery6.jpg" alt="Gallery Image 6"></a>
	<a href="/img/Gallery/gallery7.jpg"><img src="/img/Gallery/gallery7.jpg" alt="Gallery Image 7"></a>
	<a href="/img/Gallery/gallery8.jpg"><img src="/img/Gallery/gallery8.jpg" alt="Gallery Image 8"></a>
	<a href="/img/Gallery/gallery9.jpg"><img src="/img/Gallery/gallery9.jpg" alt="Gallery Image 9"></a>
	<a href="/img/Gallery/gallery10.jpg"><img src="/img/Gallery/gallery10.jpg" alt="Gallery Image 10"></a>
	<a href="/img/Gallery/gallery11.jpg"><img src="/img/Gallery/gallery11.jpg" alt="Gallery Image 11"></a>
	<a href="/img/Gallery/gallery12.jpg"><img src="/img/Gallery/gallery12.jpg" alt="Gallery Image 12"></a>
</section>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/js/highlightGenerator.js"></script>
<script src="/js/gallery.js"></script>