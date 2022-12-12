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
			$newest = file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/timeScan/' . 'newest');
			if($n>$newest){
				$n=$newest;
			}
			for($i = $newest; $i > $newest-$n; $i--){
				$content .= '"time' . ($newest-$i+1) . '":"';
				$content .= file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/timeScan/' . $i);
				$content .= '"';
				if($newest-$i+1!=$n){
					$content .= ',';
				}
			}
			$content .= '}';
			echo $content;
		}
} elseif(isset($_GET['projectKey'])){
	if(!is_dir('/var/www/html/log/' . $_GET['projectKey'])){
		echo 'Not Found!';
	}else{
		$name = file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/timeScan/' . 'newest');
		echo '{"time":"' . file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/timeScan/' . $name) . '"}';
	}
}
?>
