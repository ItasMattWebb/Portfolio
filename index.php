<?php

	require_once 'GlobalFunctions.php';
	$page = Page::getInstance();

	//simple routing
	$uri = split("/", $_SERVER['REQUEST_URI']);
	array_shift($uri);

	if(isset($uri[4]) && $uri[4] == "ajax.php"){
		if(file_exists(trim($_SERVER['REQUEST_URI'], "/"))){
			include trim($_SERVER['REQUEST_URI'], "/");
		} else{
			file_not_found();
		}
		exit();
	}

	if(!empty($uri[0])){
		//Challenges
		if($uri[0] == "Challenges" && is_numeric($uri[1])){
			$page->content = file_render($uri[0] . "/" . $uri[1] . "/index.php");
			$page->extras["sidebar-1"] =file_render("Sidebars/" . $uri[0] . ".php");
			include "Templates/with-sidebar.php";
		} else {
			if(file_exists(trim($_SERVER['REQUEST_URI'], "/"))){
				include trim($_SERVER['REQUEST_URI'], "/");
			} else{
				file_not_found();
			}
		}
	//landing page
	} else {

		$page->generate("Home", "landing");
		$page->render("Templates/landing");
	}


?>