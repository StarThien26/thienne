<?php
    error_reporting(0);
    $confirm_link = $_GET['confirm_link'];
    $cookie_file = 'cookie.txt';
    $confirm_email = curl_init();
	curl_setopt($confirm_email, CURLOPT_URL, $confirm_link);
	curl_setopt($confirm_email, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($confirm_email, CURLOPT_FOLLOWLOCATION, 1);
	$headers   = array();
	$headers[] = "Upgrade-Insecure-Requests: 1";
	$headers[] = "Accept-Language: en-US,en;q=0.9,en;q=0.8";
	$headers[] = "User-Agent: Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.15410QUAIN/22.478; U; en) Presto/2.5.25 Version/10.54";
	$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$headers[] = "Referer: https://mail.google.com/";
	$headers[] = "Authority: www.facebook.com";
	curl_setopt($confirm_email, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($confirm_email, CURLOPT_COOKIEJAR, $cookie_file);
	curl_setopt($confirm_email, CURLOPT_COOKIEFILE, $cookie_file);
	$confirm_email_result = curl_exec($confirm_email);
	curl_close($confirm_email);
	echo $confirm_email_result;
?>