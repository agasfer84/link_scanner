<?php
require_once($_SERVER['DOCUMENT_ROOT']."/core/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/BaseProvider.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Projects.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Directories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Files.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Links.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Scanner.php");



//$scanner = (new Scanner())->scanDirectories();
//$scanner = (new Scanner())->scanFiles();
$BaseProvider = new \core\BaseProvider();
$table = \models\Links::toTable(\models\Links::getAll());
echo($table);