<?php
include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/head.php";

function build($file, $hasSlideshow = false)
{
    ?>
	<!DOCTYPE html>
	<html lang="en">
    <?php buildHead($file, $hasSlideshow); ?>
	<body>

    <?php
    echo "<!-- HEADER -->";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/header.php";
    ?>

	<div id="content">
        <?php
        echo "<!-- BODY -->";
        include_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/{$file}";
        ?>
	</div>

    <?php
    echo "<!-- FOOTER -->";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/php/resources/footer.php";
    ?>

	</body>
	</html>

    <?php
}