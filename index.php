<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);

$str = file_get_contents('postmasterq.json');
$json = json_decode($str, true);

$bot->reply($json);
//$bot->reply($profile." --> ".$msg);

//echo $name;



