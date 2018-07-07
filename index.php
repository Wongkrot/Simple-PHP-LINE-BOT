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

//$desc = "";
//$i = 1;
//foreach($service_obj as $item) {
 //   $desc = $desc.$i.") ".$item['groupID']." | ".$item['serviceDesc']."\n";    
 //   $i++;
//}
//$bot->reply($desc);

$bot->reply($service_obj->{'services'}[0]->{'serviceDesc'});
//$bot->reply("tEST");



//echo $json_data;



