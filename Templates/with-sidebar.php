<?php
	$page = Page::getInstance();
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page->title; ?></title>
		<meta content="text/html; charset=UTF-8;charset=utf-8" http-equiv="content-type">
		<meta charset="utf-8">
		<meta content="en" name="language">
		<meta content="follow, index, all" name="robots">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link type="text/css" rel="stylesheet" charset="UTF-8" href="/Styles/style.css" />
	<script type="text/javascript" src="/Scripts/universal.js"></script>
	</head>
	<body id="body">
		<div class="sidebar sidebar-1" id="sidebar">
			<div id="tab">Menu</div>
			<?=$page->extras["sidebar-1"]; ?>
		</div>
		<div class="content with-sidebar">
			<?=$page->content; ?>
		</div>
	</body>
<script type="text/javascript">
	var body = document.getElementById("body");
	var tab = document.getElementById("tab");
	var body_class_original = body.getAttribute("class");
	if(body_class_original == null){
		body_class_original = "";
	}
	body.setAttribute("class", body.getAttribute("class") + " minimized");
	tab.onclick = function(){

		if(hasClass(body, "minimized")){
			body.setAttribute("class", body_class_original);
		} else {
			body.setAttribute("class", body.getAttribute("class") + " minimized");
		}

	};
</script>

</html>