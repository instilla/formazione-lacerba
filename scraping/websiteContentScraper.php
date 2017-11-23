<?php
// includo la libreria necessaria allo scraping della DOM
require_once("simple_html_dom.php");

// elenco di siti web su cui effetuare lo scraping
$websites = ["https://www.instilla.it", "https://www.primisullemappe.it", "https://www.rocketshare.io/", "https://lacerba.io"];

foreach ($websites as $website) {

	echo "Website: ".$website."\n";

	// Download del pagesource della pagina
	$websiteSource = file_get_contents($website);

	// Analizzo il pagesource come DOM
	$websiteDom = new \simple_html_dom($websiteSource);
	// Estraggo il primo H1 presente nel sito web
	echo "\nH1: ".$websiteDom->find("h1", 0)->plaintext."\n";

	echo "\nRicerca tramite RegEx:\n";
	// RegEx PHP per trovare stringhe particolari nel pagesource della pagina
	$pattern = '/(https:\/\/www.googletagmanager.com\/gtm.js|https:\/\/www.facebook.com\/tr\?id=|\/\/www.google-analytics.com\/analytics.js)/';
	preg_match_all($pattern, $websiteSource, $matches);
	foreach ($matches[0] as $match) {
		echo $match." TROVATO\n";
	}

	echo "\nRicerca di una stringa:\n";
	// Parola che voglio ricercare all'interno del pagesource della pagina
	$searchString = "marketing";
	if(strpos($websiteSource, $searchString)){
		echo $searchString." TROVATO\n";
	} else {
		echo $searchString." NON TROVATO\n";
	}

	echo "\n---------------------------------------------------------------------\n";

	// Attendo 1 secondo prima di effettuare nuove chiamate
	sleep(1);
}