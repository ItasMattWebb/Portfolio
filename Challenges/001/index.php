<?php

$page = Page::getInstance();
$page -> title = "Mystic Square";

$max = 15;
?>
<h1>Mystic Square</h1>
<div class="puzzle" id="puzzle">
	<?php
	$random_array = array();
	for ($i = 1; $i <= $max; $i++) {
		$random_array[] = $i;
	}
	shuffle($random_array);
	
	foreach ($random_array as $key => $value) {
		echo '<div class="piece"><p>' . $value . '</p></div>';
	}
	 echo '<div class="piece empty"></div>';
	?>
</div>

<script type="text/javascript">
	var window_height = "innerHeight" in window ? window.innerHeight : document.documentElement.offsetHeight;
	var window_width = "innerWidth" in window ? window.innerWidth : document.documentElement.offsetWidth;
	window_height *=.9;
	window_width *=.9;
	var puzzle = document.getElementById("puzzle");
	var rows= 4;
	var block_size;
	
	if(window_height > window_width){
		block_size = window_width / rows;
		puzzle.style.width = window_width + "px";
		puzzle.style.height = window_width + "px";
	} else {
		block_size = window_height / rows;
		puzzle.style.height = window_height + "px";
		puzzle.style.width = window_height + "px";
	}
	
	for(var i = 1; i <= puzzle.children.length; ++i) {
		puzzle.children[i - 1].style.top = block_size * (Math.ceil(i/rows)-1) + "px";
		puzzle.children[i - 1].style.left = ((i-1)%rows) * block_size + "px";
	}
	
	var positions = new Array();
	for (var i  = 0; i < rows; i++){
		positions[i] = new Array(0);
		for (var j  = 0; j < rows; j++){
			positions[i][j] = 0;
    	}
	}
	
	for(var i = 0; i < puzzle.children.length; ++i) {
		positions[Math.ceil((i+1)/4)-1][i%4] = puzzle.children[i];
	}
	
	var empty = {vertical: 3, horizontal: 3};
	
	document.addEventListener("keydown", keyDownTextField, false);
	function keyDownTextField(e) {
		var keycode = e.keyCode ? e.keyCode : e.which;
		
		switch (keycode){
			case 37:
			//left
			if(empty.horizontal > 0){
				//hold objects to reassign keys
				var original = positions[empty.vertical][empty.horizontal - 1];
				var blank = positions[empty.vertical][empty.horizontal];
				//physically move them
				positions[empty.vertical][empty.horizontal - 1].style.left = block_size * (empty.horizontal) + "px";
				positions[empty.vertical][empty.horizontal].style.left = block_size * (empty.horizontal - 1) + "px";
				//assign keys
				positions[empty.vertical][empty.horizontal - 1] = blank
				positions[empty.vertical][empty.horizontal] = original;
				//keep track of empty square location
				empty.horizontal--;
			}
			break;
			case 38:
			//up
			if(empty.vertical > 0){
				//hold objects to reassign keys
				var original = positions[empty.vertical - 1][empty.horizontal];
				var blank = positions[empty.vertical][empty.horizontal];
				//physically move them
				positions[empty.vertical - 1][empty.horizontal].style.top = block_size * (empty.vertical) + "px";
				positions[empty.vertical][empty.horizontal].style.top = block_size * (empty.vertical - 1) + "px";
				//assign keys
				positions[empty.vertical - 1][empty.horizontal] = blank
				positions[empty.vertical][empty.horizontal] = original;
				//keep track of empty square location
				empty.vertical--;
			}
			break;
			case 39:
			//right
			if(empty.horizontal < 3){
				//hold objects to reassign keys
				var original = positions[empty.vertical][empty.horizontal + 1];
				var blank = positions[empty.vertical][empty.horizontal];
				//physically move them
				positions[empty.vertical][empty.horizontal + 1].style.left = block_size * (empty.horizontal) + "px";
				
				positions[empty.vertical][empty.horizontal].style.left = block_size * (empty.horizontal + 1) + "px";
				//assign keys
				positions[empty.vertical][empty.horizontal + 1] = blank
				positions[empty.vertical][empty.horizontal] = original;
				//keep track of empty square location
				empty.horizontal++;
			}
			break;
			case 40:
			//down
			if(empty.vertical < 3){
				//hold objects to reassign keys
				var original = positions[empty.vertical + 1][empty.horizontal];
				var blank = positions[empty.vertical][empty.horizontal];
				//physically move them
				positions[empty.vertical + 1][empty.horizontal].style.top = block_size * (empty.vertical) + "px";
				positions[empty.vertical][empty.horizontal].style.top = block_size * (empty.vertical + 1) + "px";
				//assign keys
				positions[empty.vertical + 1][empty.horizontal] = blank
				positions[empty.vertical][empty.horizontal] = original;
				//keep track of empty square location
				empty.vertical++;
			}
			break;
			default:
			break;
		}
	}
	
</script>