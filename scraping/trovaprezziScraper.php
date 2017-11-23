<?php
// Includo la libreria necessaria allo scraping della DOM
require_once("simple_html_dom.php");

// Elenco di prodotti di cui voglio ricercare il prezzo migliore
$items = ["iphone 7", "samsung s8", "playstation 4 pro", "asus zenbook"];

foreach ($items as $item) {

	echo "Oggetto: ".$item."\n";

	/***
	*	La URL utilizzata di seguito è stata trovata analizzando la network activity da Chrome
	***/
	$searchUrl = "https://www.trovaprezzi.it/categoria.aspx?id=-1&libera=";

	// Costruisco l'URL per ricercare l'oggetto analizzato
	$response = file_get_contents($searchUrl.str_replace(" ", "+", $item));
	// https://www.trovaprezzi.it/categoria.aspx?id=-1&libera=iphone+7
	$domResponse = new \simple_html_dom($response);

	/***
	*	Posso ottenere due tipi di risposta:
	*		1- Se il nome del prodotto è il nome esatto allora ottengo la pagina del prodotto in questione
	*		2- Se il nome del prodotto è parziale allora ottengo l'elenco dei prodotti disponibili
	***/

	// Caso 1: prendo il prezzo migliore del prodotto
	if($domResponse->find(".catsMI a", 0)){
		$itemPageLink = $domResponse->find(".catsMI a", 0)->href;
		$response = file_get_contents("https://www.trovaprezzi.it".$itemPageLink);
		$domResponse = new \simple_html_dom($response);
		echo $item."\t";
		echo trim($domResponse->find(".listing_item .item_basic_price", 0)->plaintext)."\n";
	}

	// Caso 2: prendo tutti i prodotti possibili e il loro prezzo migliore
	if($domResponse->find(".product_best_prices")){
		foreach ($domResponse->find(".product_best_prices") as $product) {
			echo $product->find("h2", 0)->plaintext."\t";
			echo $product->find(".list_item_price", 0)->plaintext."\n";
		}
	}

	echo "\n---------------------------------------------------------------------\n";

	// Attendo 1 secondo prima di effettuare nuove chiamate
	sleep(1);

}