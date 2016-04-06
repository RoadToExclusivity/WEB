<?php

include("QiqManager.class.php");

const LOGIN         =   "___dima___";
const PASSWORD      =   "hardpassword";

$text   =   "sorry guys mb last message";

error_reporting( E_ERROR );

$manager = new QiqManager(LOGIN, PASSWORD);
$firstNewsPage = $manager->getFirstNewsPage();
$manager->sendMessage($firstNewsPage, $text);