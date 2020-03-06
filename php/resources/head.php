<?php

function buildHead($file, $hasGallery)
{
    $filename = pathinfo($file, PATHINFO_FILENAME);
    ?>
	<head>
		<meta charset="UTF-8">
		<title><?php echo ucfirst($filename) ?> | Hotel Vira Vira</title>

		<meta name="description"
		      content="Hotel Vira Vira give life to a new way of enjoying holidays, combined with adventure.
         In a unique and privileged location close to Pucon.">

		<link rel="manifest" href="/site.webmanifest">
		<link rel="apple-touch-icon" href="/img/icon.png">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#fafafa">

		<link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/header.css">
		<link rel="stylesheet" type="text/css" href="/css/<?php echo $filename?>.css">
		<?php
		if ($hasGallery) {
			?>
			<link rel="stylesheet" type="text/css" href="/css/gallerySlideshow.css">
			<?php
		}
		?>
	</head>
    <?php
}