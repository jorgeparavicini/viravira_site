<section id="wellness">
    <div>
        <h2>Wellness</h2>
        <p>
            We offer a wide variety of wonderful massage therapies in quiet and beautifully designed environments. Treat
            yourself to a moment of silence surrounded by the beauty of nature. Or relax in one of our hot tubs – an
            unforgettable experience by night when the southern cross is just above you.
        </p>
    </div>
</section>

<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/php/controls/slideshow.php";
$images = [
    "/img/spa1.jpg",
    "/img/spa2.jpg",
    "/img/spa3.jpg",
    "/img/spa4.jpg"
];

createSlideshow($images, "Spa", "spa_gallery");
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="../../js/gallery.js"></script>
