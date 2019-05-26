<?php
	// Error Reporting
	ini_set('display_erroes', 'On');
	error_reporting(E_ALL);

	include 'admin/connect.php';
     // Routes

		 $sessionUser = '';
		 if (isset($_SESSION['user'])){
			 	$sessionUser = $_SESSION['user'];
		 }

     $tpl 	= 'include/templates/';   // Template Directory
     $lang  = 'include/languages/'; // Language Directory
     $func  = 'include/functions/'; // Functions Directory
     $css 	= 'layout/css/';  //Css Directory
     $js 		= 'layout/js/';  //Js Directory


     // Include The Important Files
      include $func 		. 'functions.php';
      include $lang	  . 'english.php';
      include $tpl 		. "header.php";
