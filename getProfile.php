<?php

$code = $_GET['code'];
//$api = "https://api.line.me/oauth2/v2.1/token";

$authen_login ="grant_type=authorization_code&code=$code&redirect_uri=https://majestic-biscayne-65338.herokuapp.com/getProfile.php&client_id=1594277893&client_secret=d2a63d13dacf5041464d249127ebf50d";
//$authen_api ="grant_type=authorization_code&code=$code&redirect_uri=https://majestic-biscayne-65338.herokuapp.com/getProfile.php&client_id=1591950917&client_secret=33a71e2a76f6b89b4b31e61f02d93f97";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.line.me/oauth2/v2.1/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $authen_login);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch); 

$result_obj = json_decode($result);
$acctoken = $result_obj->{'access_token'};
//echo "Token :  $acctoken <br>";
//echo "Hello Test";

$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, "https://api.line.me/v2/profile");
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "GET");
$headers = array();
$headers[] = "Authorization: Bearer {$acctoken}";
curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch1);
if (curl_errno($ch1)) {
    echo 'Error:' . curl_error($ch1);
}
curl_close ($ch1);

$result_obj = json_decode($result);
$userid = $result_obj->{'userId'};
$displayname = $result_obj->{'displayName'};

//header("Location: http://www.d-sci.co.th/LineQ.html?userid=$userid&displayname=$displayname"); 
header("Location: http://202.129.59.25/LineMasterQueue/index.aspx?userid=$userid&displayname=$displayname"); 

//echo "<br> <br> <br> ";

//echo "$result <br> ";

//echo "$userid : $displayname <br> ";

//print_r($_GET);


    
