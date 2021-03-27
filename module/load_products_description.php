<?php

require_once("connection.php");

$oc_products_description = $oc_database->get('oc_product_description');
$oc_products = $oc_database->get('oc_product');

$solomono_products_description = $solomono_database->get('products_description');

$oc_products_new_list = [];

foreach($oc_products as $key => $product)
{
    $oc_products_new_list[$product['product_id']] = $product;
}


try {
    
    $solomono_database->startTransaction();
    foreach ($oc_products_description as $key => $oc_product)
    {

    	if(isset($solomono_products_description[$oc_product['product_id']]))
    	{
    		continue;
    	}

    	$data = [
            	"products_id" => $oc_product['product_id'],
                    "language_id" => 3,
                    "products_name" => $oc_product['name'],
                    "products_description" => $oc_product['description'],
                    "products_url" => str_replace(" ", "-", mb_strtolower($oc_product['name'], 'UTF-8')),
                    "products_viewed" => $oc_products_new_list[$oc_product['product_id']]['viewed'],
                    "products_head_title_tag" => $oc_product['meta_title'],
                    "products_head_desc_tag" => $oc_product['meta_description'],
                    "products_head_keywords_tag" => $oc_product['meta_keyword'],
                    "products_info" => $oc_product['name']
    	];
    	

    	$solomono_database->insert('products_description', $data);
        $solomono_database->commit();
    }


    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    exit(json_encode(["ok" => true, "time" => $time]));

} catch (Exception $e) {
    $solomono_database->rollback();
}

?>