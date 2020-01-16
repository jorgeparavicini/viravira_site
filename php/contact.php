<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact | Hotel Vira Vira</title>

    <meta name="description"
          content="Hotel Vira Vira give life to a new way of enjoying holidays, combined with adventure.
         In a unique and privileged location close to Pucon.">

    <link rel="manifest" href="/site.webmanifest">
    <link rel="apple-touch-icon" href="/img/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fafafa">

    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/contact.css">
</head>

<body>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/html/header.html");
?>

<h1>Contact</h1>
<div id="contactGrid">
    <div id="leftSide">
        <h2>Vira Vira</h2>
        <h3>Hacienda Hotel</h3>
        <p class="infoRow">Parcela 22a Quetroleufu, Pucón, Chile</p>
        <p class="infoRow">+56 45 237 4000</p>
        <p class="infoRow">info@hotelviravira.com</p>
    </div>
    <form id="rightSide" action="">
        <div class="formGrid">
            <label for="firstName"></label>
            <input id="firstName" class="firstColumn" type="text" placeholder="First Name">
            <label for="lastName"></label>
            <input id="lastName" class="secondColumn" type="text" placeholder="Last Name">
        </div>
        <div class="formGrid">
            <label for="email"></label>
            <input id="email" class="firstColumn" type="email" placeholder="Email">
            <label for="phone"></label>
            <input id="phone" class="secondColumn" type="tel" placeholder="Phone Number">
        </div>
        <div class="formGrid">
            <label for="zip"></label>
            <input id="zip" class="firstColumn" type="text" placeholder="Zip-Code">
            <label for="fax"></label>
            <input id="fax" class="secondColumn" type="text" placeholder="Fax">
        </div>
        <label for="subject"></label>
        <input id="subject" type="text" placeholder="Subject">
        <label for="query"></label>
        <textarea id="query" placeholder="We're happy to answer any Questions you may have.">
        </textarea>
    </form>
</div>
<img src="/img/howToReachHotel.jpg" alt="Description of how to reach the Hotel" id="route">
</body>