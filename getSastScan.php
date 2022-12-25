<?php
header('Content-Type: application/json; charset=utf-8');
if(isset($_GET['projectKey']) and isset($_GET['filename'])){
	$filename = $_GET['filename'];
	if(!is_dir('/home/ec2-user/csc-api/data/' . $_GET['projectKey'])){
		echo 'Not Found!';
	}if(!is_dir('/home/ec2-user/csc-api/data/' . $_GET['projectKey'] . '/vulnerabilities/' . $_GET['filename'])){
		echo 'Not Found!';
	}else{
		echo file_get_contents('/home/ec2-user/csc-api/data/' . $_GET['projectKey'] . '/vulnerabilities/' . $_GET['filename']);
	}
}
?>