<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);

// Read JSON file
$json = file_get_contents('/postmasterq.json');

//Decode JSON
$json_data = json_decode($json,true);

$bot->replyflex($json_data);
//$bot->reply($profile." --> ".$msg);

//echo $name;



