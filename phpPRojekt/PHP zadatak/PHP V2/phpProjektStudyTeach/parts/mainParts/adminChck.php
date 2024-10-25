<?php

include_once("../parts/mainParts/database.php");
include_once("../parts/classes/accounts/account.php");
$acc=new Account($conn);

if(!$acc->isAdmin($_SESSION["user_id"])){
  header("Location:index.php");
}
