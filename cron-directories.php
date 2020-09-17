#!/usr/bin/php
<?php
require_once(__DIR__."/console.php");

$BaseProvider = new \core\BaseProvider();
(new \models\Scanner())->scanDirectories();
