<?php

use Doctrine\Common\ClassLoader;
require_once("vendors/Doctrine/Common/ClassLoader.php");
$classLoader = new ClassLoader("Oefeningen", "src");
$classLoader->register();

?>