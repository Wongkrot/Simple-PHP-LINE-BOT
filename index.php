<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$name = $bot->getProfile($userid);

//$text2 = "Tester";
//$text2 = $bot->getProfile();
$bot->reply($name." --> ".$msg);

echo $name;



