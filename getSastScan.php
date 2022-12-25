<?php
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['projectKey']) and isset($_GET['filename'])){
	if(!is_dir('/opt/csc-api/data/' . $_GET['projectKey'])){
		echo '/opt/csc-api/data/' . $_GET['projectKey'] . ' not found!';
	}else if(!file_exists('/opt/csc-api/data/' . $_GET['projectKey'] . '/vulnerabilities/' . $_GET['filename'])){
		echo '/opt/csc-api/data/' . $_GET['projectKey'] . '/vulnerabilities/' . $_GET['filename'] . ' not found!';
	}else{
		echo file_get_contents('/opt/csc-api/data/' . $_GET['projectKey'] . '/vulnerabilities/' . $_GET['filename']);
	}
}
?>
