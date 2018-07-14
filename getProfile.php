<?php
require_once __DIR__ . '/lineBot.php';
$bot = new Linebot();
// Get User Info from Line
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);
$profile_obj = json_decode($profile);

header('Location: http://www.d-sci.co.th/LineQ.html?profile='.$profile_obj->{'displayName'}); 

    
