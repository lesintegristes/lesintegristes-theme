<?php
	include("geoipcity.inc.php");
	include("geoipregionvars.php");
	
	$yahoo_appid = "tUQlsHTV34EHnXcCjMEOcYe_XNA1b81BRdV2HjTtmRapC8WGbuskYvgigQbgQZ6HSw--";
	$simple_conditions = array(
		"cloudy" => array(19,20,21,22,23,24,26,27,28,29,30,44,),
		"rain" => array(0,1,2,3,4,6,9,10,11,12,17,18,35,37,38,39,40,45,47,),
		"snow" => array(5,7,8,13,14,15,16,25,41,42,43,46,),
		"sunny" => array(31,32,33,34,36,3200,),
	);
	
	/* Get city from IP */
	$geoip = geoip_open("GeoLiteCity.dat", GEOIP_STANDARD);
	//$ip_to_locate = "78.228.187.27";
	$ip_to_locate = $_SERVER['REMOTE_ADDR'];
	$geoip_record = geoip_record_by_addr($geoip, $ip_to_locate);
	
	/* Get WOEID from Yahoo! Geoplanet API */
	$geoplanet_request = $geoip_record->city . " " . $geoip_record->postal_code . " " . $geoip_record->country_name;
	$geoplanet_response = simplexml_load_file("http://where.yahooapis.com/v1/places.q($geoplanet_request)?select=short&appid=$yahoo_appid");
	$woeid = $geoplanet_response->place->woeid;
	
	/* Get Time Zone */
	$timezone_response = simplexml_load_file("http://where.yahooapis.com/v1/place/$woeid/belongtos.type(31)?select=short&appid=$yahoo_appid");
	$timezone = $timezone_response->place->name;
	
	// Set Time Zone
	date_default_timezone_set($timezone);
	
	$hour = (int)date("G");
	
	// Night
	if ( $hour >= 21 || $hour < 6) {
		echo "night";
	
	// Day
	} else {
		
		/* Get condition code from Yahoo! Weather API */
		$weather_response = simplexml_load_file("http://weather.yahooapis.com/forecastrss?w=$woeid&u=c");
		$result = $weather_response->xpath("/rss/channel/item/yweather:condition/@code");
		if ($result) {
			$condition = (string)$result[0];
			
			foreach ($simple_conditions as $simple_condition => $simple_condition_list) {
				if (in_array($condition, $simple_condition_list)) {
					echo $simple_condition;
					break;
				}
			}
		
		// Default
		} else {
			echo "sunny";
		}
	}
?>