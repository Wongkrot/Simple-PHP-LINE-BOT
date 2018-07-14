<?php
require_once __DIR__ . '/lineBot.php';
$bot = new Linebot();
// Get User Info from Line
$profile = $bot->getProfileLine();
$profile_obj = json_decode($profile);

//header('Location: http://www.d-sci.co.th/LineQ.html?profile='.$profile_obj->{'displayName'}); 

echo $profile_obj->{'userId'}." : ".$profile_obj->{'displayName'}; 

    
