<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/builder.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/php/models/Authenticator.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Update Session Timeouts
Authenticator::updateSession();

$path = parse_url(trim($_SERVER['REQUEST_URI']), PHP_URL_PATH);
$path = pathinfo($path, PATHINFO_FILENAME);

if (!empty($path) && $path !== "/") {
	$path = strtolower($path);

	switch($path) {
		case 'home':
			Builder::buildFromName("home.php");
			break;

		case 'location':
            Builder::buildFromName("location.php");
			break;

        case 'excursions':
            Builder::buildFromName("excursions.php");
            break;

        case 'excursion':
            Builder::buildFromName("excursion.php");
            break;

        case 'spa':
            Builder::buildFromName("spa.php");
            break;

        case 'gallery':
            Builder::buildFromName("gallery.php");
            break;

        case 'contact':
            Builder::buildFromName("contact.php");
            break;

        case 'contact_form':
            Builder::buildFromName("contact_form.php");
            break;

        case 'impressum':
            Builder::buildFromName("impressum.php");
            break;

        case 'datenschutz':
            Builder::buildFromName("datenschutz.php");
            break;

            // Overview of all excursions that can be edited
        case 'edit':
            Builder::buildAfterAuthentication("excursion_editor.php");
            break;

            // Update the database
        case 'update':
            Builder::buildAfterAuthentication("excursion_updater.php");
            break;

        case 'delete':
            Builder::buildAfterAuthentication("delete_excursion.php");
            break;

		default:
            Builder::buildFromName("404.php");
			break;
	}
} else {
    Builder::buildFromName("home.php");
}
