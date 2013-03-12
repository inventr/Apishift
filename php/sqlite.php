<?php
​function urlUP($url){
    //Validate the URL first!
    if(filter_var($url,FILTER_VALIDATE_URL)){
$handle = curl_init(urldecode($url));
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($handle);
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode >= 200 && $httpCode < 400){
return true;
}else{
return false;
}
curl_close($handle);
}
    
    }
	
	
if urlUP("http://google.com"){
           echo "The website is currently UP!";
}else{
           echo "The website is Down!";
}
?>