<?php
    // GET COOKIE
    $cookie_file = 'cookie.txt';
    file_put_contents($cookie_file, ".facebook.com	TRUE	/	TRUE	1587882931	locale	en_GB\n.facebook.com	TRUE	/	TRUE	1587882931	lh	en_GB");
    ////////////////////////// Lấy Các Input Trước Khi Đăng Ký
    $before_reg = curl_init();
	curl_setopt($before_reg, CURLOPT_URL, "https://mbasic.facebook.com/reg/");
	curl_setopt($before_reg, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($before_reg, CURLOPT_FOLLOWLOCATION, 1);
	$headers   = array();
	$headers[] = "Origin: https://mbasic.facebook.com";
	$headers[] = "User-Agent: Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.15410QUAIN/22.478; U; en) Presto/2.5.25 Version/10.54";
	$headers[] = "Authority: m.facebook.com";
	$headers[] = "Referer: https://mbasic.facebook.com/";
	curl_setopt($before_reg, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($before_reg, CURLOPT_COOKIEJAR, $cookie_file);
	curl_setopt($before_reg, CURLOPT_COOKIEFILE, $cookie_file);
	$before_reg_result = curl_exec($before_reg);
	curl_close($before_reg);
	
	preg_match('#<input type="hidden" name="lsd" value="(.+?)" autocomplete="off" />#', $before_reg_result, $lsd);
    $lsd = $lsd[1];
    preg_match('#<input type="hidden" name="jazoest" value="(.+?)" autocomplete="off" />#', $before_reg_result, $jazoest);
    $jazoest = $jazoest[1];
    preg_match('#<input type="hidden" name="ccp" value="(.+?)" />#', $before_reg_result, $ccp);
    $ccp = $ccp[1];
    preg_match('#<input type="hidden" name="reg_instance" value="(.+?)" />#', $before_reg_result, $reg_instance);
    $reg_instance = $reg_instance[1];
    preg_match('#><input type="hidden" name="reg_impression_id" value="(.+?)" />#', $before_reg_result, $reg_impression_id);
    $reg_impression_id = $reg_impression_id[1];
    /////////////////////////////////////////
    
    $ho = explode("\n" , trim(file_get_contents('./info/firstname.txt')));
	$ten = explode("\n" , trim(file_get_contents('./info/lastname.txt')));
	$firstname = $ho[array_rand($ho)];
	$lastname = $ten[array_rand($ten)];
	$prefix_email = array("trinhhaohiep.me");
	$email = convert_vi_to_en(trim($firstname).trim($lastname)).mt_rand(100,99999999).'@'.$prefix_email[array_rand($prefix_email)];
	$fb_password = '2t'.rand_string(mt_rand(6,10));
	//$birthday = mt_rand(1985,1999).'-'.mt_rand(1,12).'-'.mt_rand(1,27);
	$random_birthday_day = mt_rand(1,27);
	$random_birthday_month = mt_rand(1,12);
	$random_birthday_year = mt_rand(1985,1999);
	$random_gender = '1';
    $post_data = 'lsd='.$lsd
    .'&ccp='.$ccp
    .'&reg_instance='.$reg_instance
    .'&submission_request=true&i=&helper=&reg_impression_id='.$reg_impression_id
    .'&ns=0&field_names[]=firstname&field_names[]=reg_email__&field_names[]=sex&field_names[]=birthday_wrapper&field_names[]=reg_passwd__'
    .'&lastname='.urlencode($lastname)
    .'&firstname='.urlencode($firstname)
    .'&reg_email__='.urlencode($_GET['email'])
    .'&sex='.$random_gender
    .'&birthday_day='.$random_birthday_day
    .'&birthday_month='.$random_birthday_month
    .'&birthday_year='.$random_birthday_year
    .'&reg_passwd__='.$fb_password
    .'&submit=Sign';
	//////////////////////////////// Đăng Ký
	
	echo $post_data.'<br>';
	$reg = curl_init();
	curl_setopt($reg, CURLOPT_URL, "https://mbasic.facebook.com/reg/?cid=103");
	curl_setopt($reg, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($reg, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($reg, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($reg, CURLOPT_POST, 1);
	$headers   = array();
	$headers[] = "Origin: https://mbasic.facebook.com";
	$headers[] = "Accept-Language: en-US,en;q=0.9,en;q=0.8";
	$headers[] = "Upgrade-Insecure-Requests: 1";
	$headers[] = "User-Agent: Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.15410QUAIN/22.478; U; en) Presto/2.5.25 Version/10.54";
	$headers[] = "Content-Type: application/x-www-form-urlencoded";
	$headers[] = "Content-Length: " . strlen($post_data);
	$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$headers[] = "Cache-Control: max-age=0";
	$headers[] = "Authority: m.facebook.com";
	$headers[] = "Referer: https://mbasic.facebook.com/reg/?cid=103";
	curl_setopt($reg, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($reg, CURLOPT_COOKIEJAR, $cookie_file);
	curl_setopt($reg, CURLOPT_COOKIEFILE, $cookie_file);
	$reg_result = curl_exec($reg);
	curl_close($reg);
	echo $reg_result;
	$reg_status = file_get_contents($cookie_file);
	
	
	
	
	
    function convert_vi_to_en($str) {
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'A', $str);
		$str = preg_replace('/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'E', $str);
		$str = preg_replace('/(Ì|Í|Ị|Ỉ|Ĩ)/', 'I', $str);
		$str = preg_replace('/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'O', $str);
		$str = preg_replace('/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'U', $str);
		$str = preg_replace('/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'Y', $str);
		$str = preg_replace('/(Đ)/', 'D', $str);
		$str = str_replace(' ', '', $str);
		return strtolower($str);
	}
	function rand_string($length) {
		$str = '';
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		return $str;
	}
?>
