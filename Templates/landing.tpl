<body id="body">
	<div class="header" id="header">
		{header}
	</div>
	<div class="content landing">
		{content}
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