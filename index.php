<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);

$json = require('./postmasterq.json'); 

$bot->reply($json);
//$bot->reply($profile." --> ".$msg);

//echo $name;



