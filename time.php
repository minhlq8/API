<?php
if(isset($_GET['time']) and isset($_GET['name'])){
	$target_dir="/var/www/html/log/" . $_GET['name'];
	mkdir($target_dir,0755,true);
	$target_dir="/var/www/html/log/" . $_GET['name'] . "/timeScan";
	if(mkdir($target_dir,0755,true)){
		$myfile=fopen($target_dir . "/newest","w");
		fwrite($myfile,"0");
		fclose($myfile);
	}
	$num = file_get_contents($target_dir . "/newest")+1;
	$myfile=fopen($target_dir . "/newest","w");
	fwrite($myfile, $num);
	fclose($myfile);
	$myfile=fopen($target_dir . "/" . $num,"w");
	fwrite($myfile,$_GET['time']);
	fclose($myfile);
}
?>
