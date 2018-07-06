<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);


$obj = json_decode($profile);

$bot->replyFlex($userid);
//$bot->reply($obj->{'displayName'}." --> ".$msg);

//echo $json_data;



