
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

	private $gbUser;

	
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
		'Authorization: Bearer '.$this->$channelAccessToken)); 
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
			"text"=>$text
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
		$gbUser = $gbUser;
		return $userId;
	}
	
	public function getProfile(){
		/* $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
		$bt = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
		$response = $bt->getProfile($gbUser);
		if ($response->isSucceeded()) {
		    $profile = $response->getJSONDecodedBody();
		    $displayName = $profile['displayName'];
		    //echo $profile['pictureUrl'];
		    //echo $profile['statusMessage'];
		} else {
		    $displayName = "Tester";
		}*/
		
		/*$curl = curl_init();

		curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.line.me/v2/bot/profile/".$gbUser,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    'Authorization: Bearer '.$this->$channelAccessToken
			  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
		*/
		//$ch = curl_init("https://api.line.me/v2/bot/profile/".$gbUser); 
		//curl_setopt($ch, CURLOPT_GET, true); 
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
		//'Content-Type: application/json; charser=UTF-8', 
		//'Authorization: Bearer '.$this->$channelAccessToken)); 
		//curl_setopt($ch, CURLOPT_HTTPHEADER, 'Authorization: Bearer '.$this->$channelAccessToken); 
		//$result = curl_exec($ch); 
		//curl_close($ch); 
		
		
		//$displayName = $response['displayName'];	
		$displayName = $gbUser;
		return $displayName;
	}
	
}
