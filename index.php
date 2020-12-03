<?php

include "tabella.php";
$token = '';
$bot = new Bot($token,file_get_contents("php://input"));
include("config.php");
include("database.php");
include "comandi.php";