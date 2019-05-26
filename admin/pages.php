<?php

	/*
		Categories => [ Mange | Edit | Update | Add | Inssert | Delete | Stats ]
	*/
	
	$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

	// If The Page Is Main Page
	if ($do == 'Mange') {

		echo 'Welcome You Are In Mange Category Page';
		echo '<a href="page.php?do=Insert">Add New Category +</a>';


	}elseif ($do =='Add'){

		echo 'Welcome You Are In Add Category Page';

	}elseif ($do =='Insert'){

		echo 'Welcome You Are In Insert Category Page';

	} else {

		echo 'Error There\'s No Page With This Name' ;
	}