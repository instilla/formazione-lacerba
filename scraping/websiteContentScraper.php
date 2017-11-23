<?php
require_once("simple_html_dom.php");

$websites = ["https://www.instilla.it", "https://www.rocketshare.io/"];

foreach ($websites as $website) {

	$websiteSource = file_get_contents($website);

	$pattern = '/(https:\/\/www.googletagmanager.com\/gtm.js|https:\/\/www.facebook.com\/tr\?id=|\/\/www.google-analytics.com\/analytics.js)/';
	preg_match_all($pattern, $websiteSource, $matches);
	foreach ($matches[0] as $match) {
		var_dump($match);
	}

	$websiteDom = new \simple_html_dom($websiteSource);

	var_dump($websiteDom->find("h1", 0)->plaintext);

}