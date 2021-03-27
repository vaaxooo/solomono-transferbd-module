<?php

require_once("connection.php");

$oc_categories_description = $oc_database->get('oc_category_description');
$solomono_categories_description = $solomono_database->get('categories_description');


try {
	$solomono_database->startTransaction();
	foreach ($oc_categories_description as $key => $oc_category)
	{

		if(isset($solomono_categories_description[$oc_category['product_id']]))
		{
			continue;
		}

		$data = [
			"categories_id" => $oc_category['category_id'],
	        "language_id" => 3,
	        "categories_name" => $oc_category['name'],
	        "categories_heading_title" => $oc_category['h1_title'],
	        "categories_description" => $oc_category['description'],
	        "categories_meta_title" => $oc_category['meta_title'],
	        "categories_meta_description" => $oc_category['meta_description'],
	        "categories_meta_keywords" => $oc_category['meta_keyword'],
	        "categories_seo_url" => str_replace(" ", "-", mb_strtolower($oc_product['h1_title'], 'UTF-8')),
		];
		
		$solomono_database->insert('categories_description', $data);
		$solomono_database->commit();
	}

	$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
  	exit(json_encode(["ok" => true, "time" => $time]));

} catch (Exception $e) {
	$solomono_database->rollback();
}


?>