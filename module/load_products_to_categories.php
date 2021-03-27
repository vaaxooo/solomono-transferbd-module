<?php

require_once("connection.php");

$oc_products_to_category = $oc_database->get('oc_product_to_category');
$solomono_products_to_categories = $solomono_database->get('products_to_categories');

try {
    
    $solomono_database->startTransaction();
	foreach ($oc_products_to_category as $key => $oc_product)
	{

		if(isset($solomono_products_to_categories[$oc_product['product_id']]))
		{
			continue;
		}

		$data = [
			"products_id" => $oc_product['product_id'],
	                "categories_id" => $oc_product['category_id'],
		];
		
		$solomono_database->insert('products_to_categories', $data);
		$solomono_database->commit();
	}

    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    exit(json_encode(["ok" => true, "time" => $time]));
    
} catch (Exception $e) {
    $solomono_database->rollback();
}

?>