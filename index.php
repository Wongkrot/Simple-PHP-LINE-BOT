<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$text1 = $bot->getMessageText();
$text2 = "Test";
$bot->reply($text1 +  "[" + $text2 + "]");



