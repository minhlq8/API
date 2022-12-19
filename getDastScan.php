<?php
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['projectKey']) and isset($_GET['n'])){
	$n = $_GET['n'];
	if(!is_dir('/var/www/html/log/' . $_GET['projectKey'])){
		echo 'Not Found!';
	}if($n>10){
	echo 'max size = 10';
		}else{
			$content = '{';
			$newest = file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/dastScan/' . 'newest');
			if($n>$newest){
				$n=$newest;
			}
			for($i = $newest; $i > $newest-$n; $i--){
				$content .= '"file' . ($newest-$i+1) . '":';
				$content .= file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/dastScan/' . $i);
				if($newest-$i+1!=$n){
					$content .= ',';
				}
			}
			$content .= '}';
			$myfile = fopen("/var/www/html/log/output", "w");
			fwrite($myfile,$content);
			fclose($myfile);
			$output = shell_exec("python3 /var/www/html/api/format.py " . $_GET['projectKey']);
			echo file_get_contents("/var/www/html/log/output");
			//echo $output;
		}
} elseif(isset($_GET['projectKey'])){
	if(!is_dir('/var/www/html/log/' . $_GET['projectKey'])){
		echo 'Not Found!';
	}else{
		$name = file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/dastScan/' . 'newest');
		echo file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/dastScan/' . $name);
	}
}
?>
