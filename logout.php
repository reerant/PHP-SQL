<?php
// when user clicks logout button, this code is executed. 
session_start();
session_destroy();
header('location:index.php');
