<?php

require_once "./API/API.class.php";
require_once "./API/Login.class.php";
$start = new ClashAPILogin();

$dev_email = ""; // email of your developer account
$dev_password = ""; // password of your developer account make sure you enter correct credentials
$login = $start->login($dev_email, $dev_password);

$clan = new CoC_Clan("#2PP");
echo "Clan Name:".$clan->getName()."\n";
echo "Clan Tag:".$clan->getTag() ."\n";
echo "Clan Level:".$clan->getLevel() ."\n";



?>