<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);

list($usr, $displayName, $pic, $status) = split("," , $profile);
list($disp, $name) = split("," , $displayName);

$bot->reply($name." --> ".$msg);
//$name = $profile[displayName];
//$bot->reply($name." --> ".$msg);

//echo $name;



