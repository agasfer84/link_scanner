<?php
require_once($_SERVER['DOCUMENT_ROOT']."/core/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/BaseProvider.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Projects.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Directories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Files.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Links.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Scanner.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/PageParser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Exceptions.php");

$BaseProvider = new \core\BaseProvider();


//$scanner = (new \models\Scanner())->scanDirectories();
//$scanner = (new \models\Scanner())->scanFiles();
$scanner = (new \models\Scanner())->cleanLinks();

$table = \models\Links::toTable(\models\Links::getNonchecked());
echo($table);


