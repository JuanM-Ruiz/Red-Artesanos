<?php 

extract($_POST);
include_once("backend/autoload.php");


include("footer.php");
echo "<script type='text/javascript'>";
echo "redirpag('index.php');";
echo "</script>";
 ?>