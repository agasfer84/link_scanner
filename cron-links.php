<?php
require_once(__DIR__."/bootstrap.php");

$BaseProvider = new \core\BaseProvider();
(new \models\Scanner())->cleanLinks();