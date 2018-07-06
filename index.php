<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$obj1 = json_decode($profile);

//$bot->reply($obj1->{'displayName'}." --> ".$msg);

$queue = $bot->getQ();
$obj2 = json_decode($queue);
$bot->reply($obj2->{'queue'}->{'queueNumber'}." --> ".$msg);

//$bot->replyFlex($userid, $obj1->{'displayName'});




//echo $json_data;



