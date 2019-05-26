<?php

	session_start(); // Start The Session

	session_unset(); // Unsit The Data

	session_destroy(); // Destory The Session

	header('location: index.php');

	exit();
