<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/builder.php";
$path = parse_url(trim($_SERVER['REQUEST_URI']), PHP_URL_PATH);
$path = pathinfo($path, PATHINFO_FILENAME);

if (!empty($path) && $path !== "/") {
	$path = strtolower($path);

	switch($path) {
		case 'home':
			build("home.php");
			break;

		case 'location':
			build("location.php");
			break;

        case 'excursions':
            build("excursions.php", true);
            break;

        case 'excursion':
            build("excursion.php", true);
            break;

        case 'spa':
            build("spa.php", true);
            break;

        case 'gallery':
            build("gallery.php", true);
            break;

        case 'contact':
            build("contact.php");
            break;

            // Overview of all excursions that can be edited
        case 'edit':
            require_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/authenticate.php";
            if (authenticate()) {
                build("excursion_editor.php");
            }
            break;

            // Modify or create a new excursion
        case 'modify':
            require_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/authenticate.php";
            if (authenticate()) {
                build("modify_excursion.php");
            }
            break;

            // Update the database
        case 'update':
            require_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/authenticate.php";
            if (authenticate()) {
                build("excursion_updater.php");
            }
            break;

        case 'delete':
            require_once "{$_SERVER['DOCUMENT_ROOT']}/php/views/authenticate.php";
            if (authenticate()) {
                build("delete_excursion.php");
            }
            break;

		default:
			build("404.php");
			break;
	}
} else {
	build("home.php");
}
