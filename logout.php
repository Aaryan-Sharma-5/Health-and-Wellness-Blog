<?php
require 'db.php';
session_start();
session_destroy();

header('location: signin.php');
die();
?>