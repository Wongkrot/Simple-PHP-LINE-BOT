<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();

// Get User Info from Line
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$profile_obj = json_decode($profile);
//$bot->reply($profile_obj->{'displayName'}." --> ".$msg);

// Get Service from BranchID
$branch = "B0002";
$service = $bot->getServiceQ($branch);
$service_obj = json_decode($service);

$cnt = count($service_obj->{'services'});
$desc = "";
$chk = 0;
for ($i=0; $i<$cnt; $i++) {
    $j = $i+1;
    //$desc = $desc."พิมพ์ ".$j." เพื่อจองคิว ".$service_obj->{'services'}[$i]->{'groupID'}." | ".$service_obj->{'services'}[$i]->{'serviceDesc'}."\n";
    $desc = $desc."พิมพ์ ".$j." [".$service_obj->{'services'}[$i]->{'serviceDesc'}."]\n";
    
    if ($msg == "$j") {         
        $chk = 1;
        $groupid = $service_obj->{'services'}[$i]->{'groupID'};             
    }
}

if ($chk == 1) {
    $queue = $bot->getQ($branch, $groupid);
    $queue_obj = json_decode($queue);
    $qnumber = $queue_obj->{'queue'}->{'queueNumber'};
    $esttime = $queue_obj->{'queue'}->{'estimateTime'};
    $qbefore = $queue_obj->{'queue'}->{'queueBefore'};
    $bot->replyFlex($userid, $profile_obj->{'displayName'}, $qnumber, $esttime, $qbefore);   
} else {
    $bot->replyFlexMenu($userid, $profile_obj->{'displayName'}, $desc);
}

//$bot->reply($service_obj->{'services'}[0]->{'serviceDesc'});
//$bot->reply("tEST");



//echo $json_data;



