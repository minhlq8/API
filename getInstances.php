<?php
header('Content-Type: application/json; charset=utf-8');
echo file_get_contents('/var/www/html/log/' . $_GET['projectKey'] . '/instances/' . $_GET['file'] . '/' . $_GET['id']);
?>
