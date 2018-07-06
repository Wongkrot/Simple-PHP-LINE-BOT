
<?php
	
//	CREATE BY NONTACHAI KORNINAI
//	01 OCTOBER 2016
//
//	UPDATE BY NONTACHAI KORNINAI
//	25 MARCH 2018
	
require_once __DIR__ . '/setting.php';
class Linebot {
	private $channelAccessToken;
	private $channelSecret;
	private $webhookResponse;
	private $webhookEventObject;
	private $apiReply;
	private $apiPush;

	
	public function __construct(){
		$this->channelAccessToken = Setting::getChannelAccessToken();
		$this->channelSecret = Setting::getChannelSecret();
		$this->apiReply = Setting::getApiReply();
		$this->apiPush = Setting::getApiPush();
		$this->webhookResponse = file_get_contents('php://input');
		$this->webhookEventObject = json_decode($this->webhookResponse);
	}
	
	private function httpPost($api,$body){
		$ch = curl_init($api); 
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
		'Content-Type: application/json; charser=UTF-8', 
		'Authorization: Bearer '.$this->channelAccessToken)); 
		$result = curl_exec($ch); 
		curl_close($ch); 
		return $result;
	}
	
	public function reply($text){
		$api = $this->apiReply;
		$webhook = $this->webhookEventObject;
		$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["replyToken"] = $replyToken;
		$body["messages"][0] = array(
			"type" => "text",
			"text" => $text
		);
		
		$result = $this->httpPost($api,$body);
		return $result;
	}
	
	public function push($body){
		$api = $this->apiPush;
		$result = $this->httpPost($api, $body);
		return $result;
    	}

    	public function pushText($to, $text){
		$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'text',
			    'text' => $text
			)
		    ]
		);
		$this->push($body);
	 }

   	 public function pushImage($to, $imageUrl, $previewImageUrl = false){
        	$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'image',
			    'originalContentUrl' => $imageUrl,
			    'previewImageUrl' => $previewImageUrl ? $previewImageUrl : $imageUrl
			)
		    ]
		);
		$this->push($body);
    	}

    	public function pushVideo($to, $videoUrl, $previewImageUrl){
        	$body = array(
          	  'to' => $to,
          	  'messages' => [
          	      array(
			    'type' => 'video',
			    'originalContentUrl' => $videoUrl,
			    'previewImageUrl' => $previewImageUrl
			)
		    ]
		);
        	$this->push($body);
    	}

    	public function pushAudio($to, $audioUrl, $duration){
		$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'audio',
			    'originalContentUrl' => $audioUrl,
			    'duration' => $duration
			)
		    ]
		);
		$this->push($body);
	}

    	public function pushLocation($to, $title, $address, $latitude, $longitude){
		$body = array(
		    'to' => $to,
		    'messages' => [
			array(
			    'type' => 'location',
			    'title' => $title,
			    'address' => $address,
			    'latitude' => $latitude,
			    'longitude' => $longitude
			)
		    ]
		);
		$this->push($body);
	}
	
	public function getMessageText(){
		$webhook = $this->webhookEventObject;
		$messageText = $webhook->{"events"}[0]->{"message"}->{"text"}; 
		return $messageText;
	}
	
	public function postbackEvent(){
		$webhook = $this->webhookEventObject;
		$postback = $webhook->{"events"}[0]->{"postback"}->{"data"}; 
		return $postback;
	}
	
	public function getUserId(){
		$webhook = $this->webhookEventObject;
		$userId = $webhook->{"events"}[0]->{"source"}->{"userId"}; 
		return $userId;
	}
	
	public function getProfile($usr){				
		$url = 'https://api.line.me/v2/bot/profile/'.$usr;

		$headers = array('Authorization: Bearer ' . $this->channelAccessToken);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
		//return $result['displayName'];		
	}
	
	public function replyFlex($userId){
		$url = 'https://api.line.me/v2/bot/message/push';
		
		$headers = array('Authorization: Bearer ' . $this->channelAccessToken);
		
		$ch = curl_init($url);			
		curl_setopt($ch, CURLOPT_URL, "https://api.line.me/v2/bot/message/push");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"to\": \"$userId\",\n  \"messages\": [\n    {\n  \"type\": \"bubble\",\n  \"styles\": {\n    \"footer\": {\n      \"separator\": true\n    }\n  },\n  \"body\": {\n    \"type\": \"box\",\n    \"layout\": \"vertical\",\n    \"contents\": [\n      {\n        \"type\": \"text\",\n        \"text\": \"MasterQ\",\n        \"weight\": \"bold\",\n        \"color\": \"#1DB446\",\n        \"size\": \"sm\"\n      },\n      {\n        \"type\": \"text\",\n        \"text\": \"บริษัทไปรษณีย์ไทย\",\n        \"weight\": \"bold\",\n        \"size\": \"xxl\",\n        \"margin\": \"md\"\n      },\n      {\n        \"type\": \"text\",\n        \"text\": \"สาขาสกลนคร อำเภอเมือง\",\n        \"size\": \"xs\",\n        \"color\": \"#aaaaaa\",\n        \"wrap\": true\n      },\n      {\n        \"type\": \"separator\",\n        \"margin\": \"xxl\"\n      },\n      {\n        \"type\": \"box\",\n        \"layout\": \"vertical\",\n        \"margin\": \"xxl\",\n        \"spacing\": \"sm\",\n        \"contents\": [\n          {\n            \"type\": \"text\",\n            \"text\": \"ยินดีต้อนรับคุณ Alexpook\",\n            \"size\": \"sm\",\n            \"weight\": \"bold\",\n            \"color\": \"#555555\",\n            \"align\": \"center\",\n            \"flex\": 0\n          },\n          {\n            \"type\": \"text\",\n            \"text\": \"คิวของคุณคือ\",\n            \"size\": \"sm\",\n            \"color\": \"#555555\",\n            \"align\": \"center\",\n            \"flex\": 0\n          },\n          {\n            \"type\": \"text\",\n            \"text\": \"A001\",\n            \"size\": \"xxl\",\n            \"weight\": \"bold\",\n            \"color\": \"#555555\",\n            \"align\": \"center\",\n            \"flex\": 0\n          },\n          {\n            \"type\": \"box\",\n            \"layout\": \"horizontal\",\n            \"contents\": [\n              {\n                \"type\": \"text\",\n                \"text\": \"จำนวนคิวที่รอ\",\n                \"size\": \"sm\",\n                \"color\": \"#555555\",\n                \"flex\": 0\n              },\n              {\n                \"type\": \"text\",\n                \"text\": \"5\",\n                \"size\": \"sm\",\n                \"color\": \"#111111\",\n                \"align\": \"end\"\n              }\n            ]\n          },\n          {\n            \"type\": \"box\",\n            \"layout\": \"horizontal\",\n            \"contents\": [\n              {\n                \"type\": \"text\",\n                \"text\": \"เวลาที่รอโดยประมาณ\",\n                \"size\": \"sm\",\n                \"color\": \"#555555\",\n                \"flex\": 0\n              },\n              {\n                \"type\": \"text\",\n                \"text\": \"10.36 นาที\",\n                \"size\": \"sm\",\n                \"color\": \"#111111\",\n                \"align\": \"end\"\n              }\n            ]\n          }\n        ]\n      },\n      {\n        \"type\": \"separator\",\n        \"margin\": \"xxl\"\n      },\n      {\n        \"type\": \"box\",\n        \"layout\": \"horizontal\",\n        \"margin\": \"md\",\n        \"contents\": [\n          {\n            \"type\": \"text\",\n            \"text\": \"ขอบคุณที่ใช้บริการ\",\n            \"size\": \"xs\",\n            \"color\": \"#aaaaaa\",\n            \"flex\": 0\n          },\n          {\n            \"type\": \"text\",\n            \"text\": \"D-Sci Corporation.\",\n            \"color\": \"#aaaaaa\",\n            \"size\": \"xs\",\n            \"align\": \"end\"\n          }\n        ]\n      }\n    ]\n  }\n}\n\n  ]\n}");
		curl_setopt($ch, CURLOPT_POST, 1);	
		$result = curl_exec($ch);		
		curl_close ($ch);
	}
}
