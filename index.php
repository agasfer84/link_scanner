<?php
require_once($_SERVER['DOCUMENT_ROOT']."/core/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/BaseProvider.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Projects.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Directories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Files.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Links.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Scanner.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/PageParser.php");

$BaseProvider = new \core\BaseProvider();

//$file_path = 'E:\repositories\home_dev\eurohouse63.ru\building\komfortnoe-zhilyo-iz-ocilindrovannogo-brevna\index.php';
//$file_path = 'E:\repositories\home_dev\eurohouse63.ru\building\proizvodstvo-karkasno-shhitovykh-domov\index.php';
//$parser = \models\PageParser::replaceATags($file_path);
//print_r((string)$parser);

$files_for_replace = \models\Files::getForATagReplace();
print_r($files_for_replace);


//$scanner = (new Scanner())->scanDirectories();
//$scanner = (new Scanner())->scanFiles();

$table = \models\Links::toTable(\models\Links::getAll());
echo($table);


