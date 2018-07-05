<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$name = $bot->getProfile($userid);

//$bot->reply($name." --> ".$msg);
$bot->reply($name->displayName." --> ".$msg);

//echo $name;



