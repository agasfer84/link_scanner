#!/usr/bin/php
<?php
require_once(__DIR__."/Scanner.php");
require_once(__DIR__."/Directories.php");
require_once(__DIR__."/Files.php");

$Scanner = new Scanner();
$Files = new Files();

$files = $Files->getFiles();
$Scanner->scanFiles($files);