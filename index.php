<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$obj = json_decode($profile);

//$bot->reply($obj->{'displayName'}." --> ".$msg);
//$bot->replyFlex($userid, $obj->{'displayName'});

$queue = $bot->getQ();
$bot->reply($queue." --> ".$msg);




//echo $json_data;



