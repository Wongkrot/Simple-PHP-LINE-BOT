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
echo "Token :  $acctoken <br>";

/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.line.me/v2/profile");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$headers = array();
$headers[] = "Authorization: Bearer {$acctoken}";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);*/

//header('Location: http://www.d-sci.co.th/LineQ.html?profile='.$profile_obj->{'displayName'}); 

echo "<br> <br> <br>";

echo "$code : Test <br> ";

echo "$result <br> ";

//echo "$authen_api <br> ";

print_r($_GET);


    
