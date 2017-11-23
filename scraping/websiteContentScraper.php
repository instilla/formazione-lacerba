<?php
require_once("simple_html_dom.php");

$websites = ["https://www.instilla.it", "https://www.primisullemappe.it", "https://www.rocketshare.io/", "https://lacerba.io"];

foreach ($websites as $website) {

	echo "Website: ".$website."\n";
	$websiteSource = file_get_contents($website);

	$websiteDom = new \simple_html_dom($websiteSource);
	echo "\nH1: ".$websiteDom->find("h1", 0)->plaintext."\n";

	echo "\nRicerca tramite RegEx:\n";
	$pattern = '/(https:\/\/www.googletagmanager.com\/gtm.js|https:\/\/www.facebook.com\/tr\?id=|\/\/www.google-analytics.com\/analytics.js)/';
	preg_match_all($pattern, $websiteSource, $matches);
	foreach ($matches[0] as $match) {
		echo $match." TROVATO\n";
	}

	echo "\nRicerca di una stringa:\n";
	$searchString = "marketing";
	if(strpos($websiteSource, $searchString)){
		echo $searchString." TROVATO\n";
	} else {
		echo $searchString." NON TROVATO\n";
	}

	echo "\n---------------------------------------------------------------------\n";

	sleep(1);
}