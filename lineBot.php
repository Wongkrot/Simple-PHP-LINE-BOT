
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
	private $reserveQ;

	
	public function __construct(){
		$this->channelAccessToken = Setting::getChannelAccessToken();
		$this->channelSecret = Setting::getChannelSecret();
		$this->apiReply = Setting::getApiReply();
		$this->apiPush = Setting::getApiPush();
		$this->reserveQ = Setting::reserveQueue();
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
	
	public function replyFlex($userid, $name){				

																						
		$api = $this->apiPush;
		//$webhook = $this->webhookEventObject;
		//$replyToken = $webhook->{"events"}[0]->{"replyToken"}; 
		$body["to"] = $userid;
		$body["messages"][0] = array(
			"type" => "flex",
			"altText" => "this is a flex message",
			"contents" => array (
					  'type' => 'bubble',
					  'styles' => 
					  array (
					    'footer' => 
					    array (
					      'separator' => true,
					    ),
					  ),
					  'body' => 
					  array (
					    'type' => 'box',
					    'layout' => 'vertical',
					    'contents' => 
					    array (
					      0 => 
					      array (
						'type' => 'text',
						'text' => 'MasterQ',
						'weight' => 'bold',
						'color' => '#1DB446',
						'size' => 'sm',
					      ),
					      1 => 
					      array (
						'type' => 'text',
						'text' => 'บริษัทไปรษณีย์ไทย',
						'weight' => 'bold',
						'size' => 'xxl',
						'margin' => 'md',
					      ),
					      2 => 
					      array (
						'type' => 'text',
						'text' => 'สาขาสกลนคร อำเภอเมือง',
						'size' => 'xs',
						'color' => '#aaaaaa',
						'wrap' => true,
					      ),
					      3 => 
					      array (
						'type' => 'separator',
						'margin' => 'xxl',
					      ),
					      4 => 
					      array (
						'type' => 'box',
						'layout' => 'vertical',
						'margin' => 'xxl',
						'spacing' => 'sm',
						'contents' => 
						array (
						  0 => 
						  array (
						    'type' => 'text',
						    'text' => 'ยินดีต้อนรับคุณ '.$name,
						    'size' => 'sm',
						    'weight' => 'bold',
						    'color' => '#555555',
						    'align' => 'center',
						    'flex' => 0,
						  ),
						  1 => 
						  array (
						    'type' => 'text',
						    'text' => 'คิวของคุณคือ',
						    'size' => 'sm',
						    'color' => '#555555',
						    'align' => 'center',
						    'flex' => 0,
						  ),
						  2 => 
						  array (
						    'type' => 'text',
						    'text' => 'A001',
						    'size' => 'xxl',
						    'weight' => 'bold',
						    'color' => '#555555',
						    'align' => 'center',
						    'flex' => 0,
						  ),
						  3 => 
						  array (
						    'type' => 'box',
						    'layout' => 'horizontal',
						    'contents' => 
						    array (
						      0 => 
						      array (
							'type' => 'text',
							'text' => 'จำนวนคิวที่รอ',
							'size' => 'sm',
							'color' => '#555555',
							'flex' => 0,
						      ),
						      1 => 
						      array (
							'type' => 'text',
							'text' => '5',
							'size' => 'sm',
							'color' => '#111111',
							'align' => 'end',
						      ),
						    ),
						  ),
						  4 => 
						  array (
						    'type' => 'box',
						    'layout' => 'horizontal',
						    'contents' => 
						    array (
						      0 => 
						      array (
							'type' => 'text',
							'text' => 'เวลาที่รอโดยประมาณ',
							'size' => 'sm',
							'color' => '#555555',
							'flex' => 0,
						      ),
						      1 => 
						      array (
							'type' => 'text',
							'text' => '10.36 นาที',
							'size' => 'sm',
							'color' => '#111111',
							'align' => 'end',
						      ),
						    ),
						  ),
						),
					      ),
					      5 => 
					      array (
						'type' => 'separator',
						'margin' => 'xxl',
					      ),
					      6 => 
					      array (
						'type' => 'box',
						'layout' => 'horizontal',
						'margin' => 'md',
						'contents' => 
						array (
						  0 => 
						  array (
						    'type' => 'text',
						    'text' => 'ขอบคุณที่ใช้บริการ',
						    'size' => 'xs',
						    'color' => '#aaaaaa',
						    'flex' => 0,
						  ),
						  1 => 
						  array (
						    'type' => 'text',
						    'text' => 'D-Sci Corporation.',
						    'color' => '#aaaaaa',
						    'size' => 'xs',
						    'align' => 'end',
						  ),
						),
					      ),
					    ),
					  ),
					)						
		);
		
		$result = $this->httpPost($api,$body);
		return $result;
	}
	
	public function getQ(){
		
		$api = $this->reserveQ;		 
		$body["branchID"] = "B0002";
		$body["queueType"] = "L";
		$body["serviceID"] = "G0002";				
		
		$ch = curl_init($api); 
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
		'Content-Type: application/json; charser=UTF-8', 
		'Authorization:  ')); 
		$result = curl_exec($ch); 
		curl_close($ch);
		
		return $result;
	}
}
