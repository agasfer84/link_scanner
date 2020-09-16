#!/usr/bin/php
<?php
require_once($_SERVER['DOCUMENT_ROOT']."/core/Database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/BaseProvider.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Projects.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Directories.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Files.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Links.php");
require_once($_SERVER['DOCUMENT_ROOT']."/models/Scanner.php");

$BaseProvider = new \core\BaseProvider();
(new \models\Scanner())->scanFiles();