#!/usr/bin/php
<?php
require_once(__DIR__."/Scanner.php");
require_once(__DIR__."/Directories.php");
require_once(__DIR__."/Files.php");

$scanner = new Scanner();
$Scanner->scanDirectories();

