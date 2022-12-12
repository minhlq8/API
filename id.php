<?php
	$myfile = fopen("getID", "w");
	fwrite($myfile, $_GET['id']);
	fclose($myfile);
?>
