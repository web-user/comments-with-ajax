<?php

/* Конфигурация базы данных */

$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= '';
$db_database		= 'ci_loc'; 




$link = @mysql_connect($db_host,$db_user,$db_pass) or die('Erorr');

mysql_query("SET NAMES 'utf8'");
mysql_select_db($db_database,$link);

?>