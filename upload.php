<?php
if(isset($_GET['name']) and isset($_GET['type'])){
	$target_dir="/var/www/html/log/" . $_GET['name'];
	mkdir($target_dir,0755,true);
	$target_dir="/var/www/html/log/" . $_GET['name'] . "/" . $_GET['type'];
	if(mkdir($target_dir,0755,true)){
		$myfile=fopen($target_dir . "/newest","w");
		fwrite($myfile,"0");
		fclose($myfile);
	}
	$uploadOk=1;
	$target_file=basename($_FILES["fileToUpload"]["name"]);
	$imageFileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if($imageFileType!="json"){
		echo"Sorry, only JSON file are allowed.";
		$uploadOk=0;
	}
	if($uploadOk==0){
		echo"Sorry, your file was not uploaded.";
	}else{
		$num = file_get_contents($target_dir . "/newest")+1;
		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . "/" . $num)){
			$myfile=fopen($target_dir . "/newest","w");
			fwrite($myfile, $num);
			fclose($myfile);
			echo"The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
		}else{
			echo"Sorry, there was an error uploading your file.";
		}
	}
}
?>
