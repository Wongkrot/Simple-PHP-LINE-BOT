<?php
require_once __DIR__ . '/lineBot.php';

$bot = new Linebot();
$msg = $bot->getMessageText();
$userid = $bot->getUserId();
$profile = $bot->getProfile($userid);

$data = file_get_contents ("postmasterq.json");
        $json = json_decode($data, true);
        foreach ($json as $key => $value) {
            if (!is_array($value)) {
                echo $key . '=>' . $value . '<br/>';
            } else {
                foreach ($value as $key => $val) {
                    echo $key . '=>' . $val . '<br/>';
                }
            }
        }

$bot->reply($data);
//$bot->reply($profile." --> ".$msg);

//echo $name;



