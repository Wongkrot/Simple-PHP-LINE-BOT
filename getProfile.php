<?php
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.line.me/v2/profile");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


$headers = array();
$headers[] = "Authorization: Bearer 5ZXZrSS8ZkEDGBilHGY2vKyWARc0Yx6O9zOZ/iN24MH39flQZLWt7gvvOY10/LMD3rppnVJBza1RyQIMXJ2vsoPh8i+L2nyIG8y0tlqR/asJiq0gfm1W5wh93re+XESxhwpUoa5q3iZuokzvYqNIcgdB04t89/1O/w1cDnyilFU=";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

//header('Location: http://www.d-sci.co.th/LineQ.html?profile='.$profile_obj->{'displayName'}); 

echo "<br> <br> <br>";

echo $result;

echo "Test";


    
