<?php
require_once("simple_html_dom.php");

$items = ["iphone 7", "samsung s8", "playstation 4 pro", "asus zenbook"];

foreach ($items as $item) {

	echo "Oggetto: ".$item."\n";

	$response = file_get_contents("https://www.trovaprezzi.it/categoria.aspx?id=-1&libera=".str_replace(" ", "+", $item));
	$domResponse = new \simple_html_dom($response);

	if($domResponse->find(".catsMI a", 0)){
		$itemPageLink = $domResponse->find(".catsMI a", 0)->href;
		$response = file_get_contents("https://www.trovaprezzi.it".$itemPageLink);
		$domResponse = new \simple_html_dom($response);
		echo $item."\t";
		echo trim($domResponse->find(".listing_item .item_basic_price", 0)->plaintext)."\n";
	}

	if($domResponse->find(".product_best_prices")){
		foreach ($domResponse->find(".product_best_prices") as $product) {
			echo $product->find("h2", 0)->plaintext."\t";
			echo $product->find(".list_item_price", 0)->plaintext."\n";
		}
	}

	echo "\n---------------------------------------------------------------------\n";

	sleep(1);

}