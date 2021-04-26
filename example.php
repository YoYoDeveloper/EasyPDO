<?php
include 'EasyPDO.php';

//database info
$host = '';
$name = '';
$user = '';
$pass = '';

//create a connection to the database
$DB = new EasyPDO($host,$name,$user,$pass);

//executes SQL statements
$query = $DB->query("SELECT count(id) FROM table WHERE param=:param", [":param"=>"PARAM VALUE"]);

//Depending on your sql statement and your needs you can use:
$var = $DB->query('')->fetch();
$var = $DB->query('')->fetchAll();
$var = $DB->query('')->fetchColumn();
//...

//to show the number of queries used into a page just use $DB->queries() at the end of your php file:
echo $DB->queries();

//if you dont understand my example... i'm sorry, i dont know to explain too much.
