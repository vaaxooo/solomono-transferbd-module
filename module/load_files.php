<?php


if(!file_exists("../product_images.zip"))
{
    exit(json_encode(["ok" => false, "message" => "File <b>product_images.zip</b> not found!"]));
}

if(!file_exists("images/products"))
{
	$ZipArchive = new ZipArchive();
	$ZipArchive->open("product_images.zip");
	$ZipArchive->extractTo("images/products/");
	$ZipArchive->close();
}


function getDirContents($dir, &$results = array()){
    $dirs = scandir($dir);

    foreach($dirs as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}


$files = getDirContents("images/products/");

foreach($files as $key => $file)
{

	if(!pathinfo($file, PATHINFO_EXTENSION))
	{
		unset($files[$key]);
		continue;
	}

	$fileInfo = explode("\\", $file);
	$fileName = $fileInfo[count($fileInfo) - 1];

	$fileType = explode(".", $fileName);
	$fileType = $fileType[count($fileType) - 1];

	$fileUrl = str_replace("images/products/", "", str_replace("\\", "/", str_replace($fileName, "", $file)));

	if(!file_exists("images/products".$fileUrl))
	{
		mkdir("images/products".$fileUrl, 0777, true);
	}

	if(!rename(str_replace("/", "\\", "images/products".$fileUrl.$fileName), "images/products/".$fileUrl.md5(md5($fileName)).".".$fileType))
	{
		echo "File not changed: <b>{$file}</b>\n";
	}
}

	unlink("../product_images.zip");

	$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    exit(json_encode(["ok" => true, "time" => $time]));
?>