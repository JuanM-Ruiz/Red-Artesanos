<?php 
	
function __autoload($classname) {
    $filename = "backend/". $classname .".php";
    include($filename);
}

 ?>