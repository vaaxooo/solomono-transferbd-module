<?php

require_once("connection.php");

$oc_categories = $oc_database->get('oc_category');
$solomono_categories = $solomono_database->get('categories');

try {

	$solomono_database->startTransaction();
	foreach ($oc_categories as $key => $oc_category)
	{

		if(isset($solomono_categories[$oc_category['category_id']]))
		{
			continue;
		}

		$data = [
			"categories_id" => $oc_category['category_id'],
	                "categories_image" => $oc_category['image'],
	                "categories_icon" => NULL,
	                "parent_id" => $oc_category['parent_id'],
	                "sort_order" => $oc_category['sort_order'],
	                "date_added" => $oc_category['date_added'],
	                "last_modified" => $oc_category['date_modified'],
	                "categories_status" => $oc_category['status'],
	                "categories_to_xml" => 0,
	                "display_products" => "all",
		];
		
		$solomono_database->insert('categories', $data);
		$solomono_database->commit();
	}

    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
  	exit(json_encode(["ok" => true, "time" => $time]));

} catch (Exception $e) {
	$solomono_database->rollback();
}


?>