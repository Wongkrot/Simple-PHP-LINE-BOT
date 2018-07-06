<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);


$bot->replyflex($profile);
//$bot->reply($profile." --> ".$msg);

//echo $json_data;



