<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$obj1 = json_decode($profile);

//$bot->reply($obj1->{'displayName'}." --> ".$msg);

//$queue = $bot->getQ("B0002", "S0012");
//$obj2 = json_decode($queue);
//$qnumber = $obj2->{'queue'}->{'queueNumber'};
//$esttime = $obj2->{'queue'}->{'estimateTime'};
//$qbefore = $obj2->{'queue'}->{'queueBefore'};
//$bot->replyFlex($userid, $obj1->{'displayName'}, $qnumber, $esttime, $qbefore);

$service = $bot->getServiceQ("B0002");
$bot->reply($service);



//echo $json_data;



