<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$profile_obj = json_decode($profile);

//$bot->reply($profile_obj->{'displayName'}." --> ".$msg);

//$queue = $bot->getQ("B0002", "S0012");
//$queue_obj = json_decode($queue);
//$qnumber = $queue_obj->{'queue'}->{'queueNumber'};
//$esttime = $queue_obj->{'queue'}->{'estimateTime'};
//$qbefore = $queue_obj->{'queue'}->{'queueBefore'};
//$bot->replyFlex($userid, $profile_obj->{'displayName'}, $qnumber, $esttime, $qbefore);

$service = $bot->getServiceQ("B0002");
$service_obj = json_decode($service);
$bot->reply($service);
//$bot->reply("tEST");



//echo $json_data;



