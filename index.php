<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$name = $profile[displayName];
$bot->reply($name." --> ".$msg);

//echo $name;



