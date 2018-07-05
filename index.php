<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$text = $bot->getMessageText();
//$text2 = $bot->getProfile();

$bot->reply($text);



