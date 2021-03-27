<?php

require_once("connection.php");

$oc_products = $oc_database->get('oc_product');
$solomono_products = $solomono_database->get('products');

try {
    
    $solomono_database->startTransaction();
    foreach ($oc_products as $key => $oc_product)
    {

    	if(isset($solomono_products[$oc_product['product_id']]))
    	{
    		continue;
    	}

            $fileInfo = explode("/", $oc_product['image']);
            $fileName = $fileInfo[count($fileInfo) - 1];

            $fileType = explode(".", $fileName);
            $fileType = $fileType[count($fileType) - 1];

            $fileUrl = str_replace($fileName, "", $oc_product['image']);

            $oc_product['image'] = $fileUrl.md5(md5($fileName)).".".$fileType;

    	$data = [
    		"products_id" => $oc_product['product_id'],
            "products_quantity" => $oc_product['quantity'],
            "products_model" => $oc_product['model'],
            "products_image" => $oc_product['image'],
            "products_price" => $oc_product['price'],
            "products_date_added" => $oc_product['date_added'],
            "products_last_modified" => $oc_product['date_modified'],
            "products_date_available" => $oc_product['date_available'],
            "products_weight" => $oc_product['weight'],
            "products_status" => $oc_product['status'],
            "products_to_xml" => 0,
            "products_tax_class_id" => $oc_product['tax_class_id'],
            "manufacturers_id" => $oc_product['manufacturer_id'],
            "products_ordered" => $oc_product['product_id'],
            "products_quantity_order_min" => $oc_product['minimum'],
            "products_quantity_order_units" => $oc_product['stock_status_id'],
            "products_sort_order" => $oc_product['sort_order'],
            "lable_1" => 0,
            "lable_2" => 0,
            "lable_3" => 0,
            "products_free_ship" => $oc_product['shipping'],
            "edited_for_seo" => 0
    	];
    	
    	$solomono_database->insert('products', $data);
        $solomono_database->commit();
    }

    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    exit(json_encode(["ok" => true, "time" => $time]));

} catch (Exception $e) {
    $solomono_database->rollback();
}


?>