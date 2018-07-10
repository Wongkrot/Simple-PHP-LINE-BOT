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
    $desc = $desc."พิมพ์ ".$j." สำหรับ ".$service_obj->{'services'}[$i]->{'serviceDesc'}."\n";
    
    if ($msg == "$j") {         
        $chk = 1;
        $serviceid = $service_obj->{'services'}[$i]->{'serviceID'};             
        $servicedesc = $service_obj->{'services'}[$i]->{'serviceDesc'};
    }
}

$desc = $desc."\n พิมพ์ X สำหรับยกเลิกการจองคิว";

if ($chk == 1) {
   
    $queue = $bot->getQ($branch, $userid, $serviceid);
    //$queue = $bot->getQ($branch, "Test123", $serviceid);
    $queue_obj = json_decode($queue);
    $header  = $queue_obj->{'header'}->{'codeValue'};
    $qnumber = $queue_obj->{'queue'}->{'queueNumber'};
    $esttime = $queue_obj->{'queue'}->{'estimateTime'};
    $qbefore = $queue_obj->{'queue'}->{'queueBefore'};
    
    if ($header == "ขออภัย สาขายังไม่เปิดให้จองคิว") {
        $bot->reply("ขออภัย สาขายังไม่เปิดให้จองคิว");      
    } elseif ($header == "ไม่ให้จองซ้ำติดต่อกัน") {
        $bot->reply("ท่านจองบริการเดิมติดต่อกัน กรุณารอประมาณ 5 นาที");
    } elseif ($header == "EstimateTime0") {
        $bot->reply("กรุณารอเรียกคิว");
    } elseif ($header == "Queuehasalready") {
        $bot->reply("กรุณารอเรียกคิว"); 
    } elseif ($header == "ReserveQueueSuccess") {
        $bot->replyFlex($userid, $profile_obj->{'displayName'}, $qnumber, $esttime, $qbefore, $servicedesc);
    } // รอถามอ๊อด 
    //$bot->reply($userid ." , ". $profile_obj->{'displayName'} ." , ". $qnumber ." , ". $esttime ." , ". $qbefore ." , ".$serviceid ." , ". $header);      
    
} elseif ((chk == 0) && (($msg == "X") || ($msg == "x"))) {
    $bot->setCancelQ($userid);
    $bot->reply("คิวที่ท่านจองได้ถูกยกเลิกเรียบร้อย.");
/*} elseif ((chk == 0) && ($msg == "GetAmt")) {
    $servAmt = $bot->getAmtServiceQ($branch);
    $servAmt_obj = json_decode($service);
    $cnt = count($servAmt_obj->{'services'});
    
    $desc = "";
    $chk = 0;
    for ($i=0; $i<$cnt; $i++) {   
        $desc = $desc.$servAmt_obj->{'services'}[$i]->{'serviceDesc'}." มีจำนวน ".$servAmt_obj->{'services'}[$i]->{'queueNumber'}." คิว\n";
    }
    $bot->replyFlexMenu($userid, $profile_obj->{'displayName'}, $desc);
  */  
} else {
    $bot->replyFlexMenu($userid, $profile_obj->{'displayName'}, $desc);
}

//$bot->reply($service_obj->{'services'}[0]->{'serviceDesc'});
//$bot->reply("tEST");



//echo $json_data;



