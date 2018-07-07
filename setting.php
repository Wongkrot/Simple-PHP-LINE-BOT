<?php

class Setting {
	public function getChannelAccessToken(){
		$channelAccessToken = "5ZXZrSS8ZkEDGBilHGY2vKyWARc0Yx6O9zOZ/iN24MH39flQZLWt7gvvOY10/LMD3rppnVJBza1RyQIMXJ2vsoPh8i+L2nyIG8y0tlqR/asJiq0gfm1W5wh93re+XESxhwpUoa5q3iZuokzvYqNIcgdB04t89/1O/w1cDnyilFU=";
		return $channelAccessToken;
	}
	public function getChannelSecret(){
		$channelSecret = "33a71e2a76f6b89b4b31e61f02d93f97";
		return $channelSecret;
	}
	public function getApiReply(){
		$api = "https://api.line.me/v2/bot/message/reply";
		return $api;
	}
	public function getApiPush(){
		$api = "https://api.line.me/v2/bot/message/push";
		return $api;
	}
	public function reserveQueue(){
		$api = "http://www.d-sci.co.th/QueueService.svc/Branch/ReserveQueue/";
		return $api;
	}
	
	public function branchID(){
		$api = "B0002";	
		return $api;
	}

}
