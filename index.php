<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/builder.php";
$path = parse_url(trim($_SERVER['REQUEST_URI']), PHP_URL_PATH);

if (!empty($path) && $path !== "/") {
	$path = strtolower($path);

	switch($path) {
		case '/home':
			build("home.php");
			break;

		case '/location':
			build("location.php");
			break;

        case '/excursions':
            build("excursions.php", true);
            break;

        case '/excursion':
            build("excursion.php", true);
            break;

        case '/spa':
            build("spa.php", true);
            break;

        case '/gallery':
            build("gallery.php", true);
            break;

        case '/contact':
            build("contact.php");
            break;

        case '/login':
            build("login.php");
            break;

        case '/authenticate':
            include_once "php/views/authenticate.php";
            break;

        case '/edit':
            build("excursion_editor.php");
            break;

		default:
			build("404.php");
			break;
	}
} else {
	build("home.php");
}
