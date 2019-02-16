<?php

require_once 'idiorm.php';

ORM::configure('sqlite:./invoice.db');

$table = 'customer';
$person = ORM::for_table($table)->find_one();

echo $person['name'];
?>