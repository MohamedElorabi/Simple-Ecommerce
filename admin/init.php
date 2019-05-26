<?php

	include 'connect.php';
     // Routes

     $tpl 	= 'include/template/';   // Template Directory
     $lang  = 'include/languages/'; // Language Directory
     $func  = 'include/functions/'; // Functions Directory
     $css 	= 'layout/css/';  //Css Directory
     $js 		= 'layout/js/';  //Js Directory


     // Include The Important Files
      include $func . 'function.php';
      include $lang .'english.php';
      include $tpl .'header.php';


      // Include Navbar On All Pages Expect The One With $noNavbar Vairable

      if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }