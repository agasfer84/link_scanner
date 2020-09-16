#!/usr/bin/php
<?php
require_once(__DIR__."/core/Database.php");
require_once(__DIR__."/core/BaseProvider.php");
require_once(__DIR__."/models/Projects.php");
require_once(__DIR__."/models/Directories.php");
require_once(__DIR__."/models/Files.php");
require_once(__DIR__."/models/Links.php");
require_once(__DIR__."/models/Scanner.php");

$BaseProvider = new \core\BaseProvider();
(new \models\Scanner())->scanDirectories();
