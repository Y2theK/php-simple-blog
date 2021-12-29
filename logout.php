<?php

require_once "core/autoload.php";
session_destroy();
Helper::redirect('login.php');
?>