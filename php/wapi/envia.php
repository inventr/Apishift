<?php
require "whatsprot.class.php";

$fromMobNumber = "17743779460"; //ENTER YOUR GOOGLEVOICENUMBER HERE
$toMobNumber = $_GET["country"] . $_GET["numero"]; //ENTER YOUR OWN NUMBER HERE
$id = "y5GaBjH46PopFq4SBGKyA4ZhTU4="; //ENTER THE PASSWORD YOU COPIED EARLIER HERE
$nick = "Gerswin SMS";
$msg = "[" . $_GET["nombre"] . " dice:]" . "\n" . $_GET["mensaje"] . "\n" . "---" . "\n" . "http://gerswin.com";
$w = new WhatsProt($fromMobNumber, $id, $nick);
$w->Connect();
$w->Login();
$w->sendNickname($nick);
$w->Message($toMobNumber, $msg);
sleep(2);
echo "Tu mensaje fue enviado a <b>" . $_GET['numero'] . "</b>";
echo "<br/>";