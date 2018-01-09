<?php

//set page data
$page = Page::getInstance();
$page -> title = "Under Construction: Battleship";
?>

<div class="battleship" id="game">
	<div class="radar">
		<table class="label-h">
			<tbody>
				<?php
				echo '<tr class="label">';
				for ($i = 1; $i <= 10; $i++) {
					echo '<td>' . $i . '</td>';
				}
				echo '</tr>';
				?>
			</tbody>
		</table>
		<table class="label-v">
			<tbody>
				<?php
				for ($i = 'a'; $i <= 'j'; $i++) {
					echo '<tr><td>';
					echo $i;
					echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
		<table class="grid">
			<tbody>
				<?php
				for ($i = 0; $i < 10; $i++) {
					echo '<tr>';
					for ($j = 0; $j < 10; $j++) {
						echo '<td onclick="fire(event, ' . $j . ',' . $i . ')"><div></div></td>';
					}
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
		<div class="guide">
			<div class="half">
				<div class="shipholder destroyer">
						<img id="target_destroyer" class="ship" src="/Resources/Battleship/destroyer.png"/>
						<img class="bg" src="/Resources/Battleship/destroyer_bg.png"/>
				</div>
				<div class="shipholder carrier">
						<img id="target_carrier" class="ship" src="/Resources/Battleship/carrier.png"/>
						<img class="bg" src="/Resources/Battleship/carrier_bg.png"/>
				</div>
			</div>
			<div class="half end">
				<div class="shipholder battleship">
						<img id="target_battleship" class="ship" src="/Resources/Battleship/battleship.png"/>
						<img class="bg" src="/Resources/Battleship/battleship_bg.png"/>
				</div>
				<div class="shipholder patrol">
						<img id="target_patrol" class="ship" src="/Resources/Battleship/patrol.png"/>
						<img class="bg" src="/Resources/Battleship/patrol_bg.png"/>
				</div>
				<div class="shipholder submarine">
						<img id="target_submarine" class="ship" src="/Resources/Battleship/submarine.png"/>
						<img class="bg" src="/Resources/Battleship/submarine_bg.png"/>
				</div>
			</div>
		</div>
	</div>
	<div class="ship_area">
		<table class="label-h">
			<tbody>
				<?php
				echo '<tr class="label">';
				for ($i = 1; $i <= 10; $i++) {
					echo '<td>' . $i . '</td>';
				}
				echo '</tr>';
				?>
			</tbody>
		</table>
		<table class="label-v">
			<tbody>
				<?php
				for ($i = 'a'; $i <= 'j'; $i++) {
					echo '<tr><td>';
					echo $i;
					echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
		<table class="grid">
			<tbody id="droppable">
				<?php
				for ($i = 0; $i < 10; $i++) {
					echo '<tr>';
					for ($j = 0; $j < 10; $j++) {
						echo '<td><div data-coords="' . $j . '-' . $i . '" ondragover="allowDrop(event)" ondrop="drop(event, this)"></div></td>';
					}
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
		<div class="port">
			<div class="half">
				<div class="shipholder destroyer" ondragover="allowDrop(event)" ondrop="dropFilter(event, this)">
						<img id="destroyer" class="ship" src="/Resources/Battleship/destroyer.png" onclick="rotate(event)" draggable="true" ondragstart="drag(event)"/>
						<img class="bg" src="/Resources/Battleship/destroyer_bg.png"/>
				</div>
				<div class="shipholder carrier" ondragover="allowDrop(event)" ondrop="dropFilter(event, this)">
						<img id="carrier" class="ship" src="/Resources/Battleship/carrier.png" onclick="rotate(event)" draggable="true" ondragstart="drag(event)"/>
						<img class="bg" src="/Resources/Battleship/carrier_bg.png"/>
				</div>
			</div>
			<div class="half end">
				<div class="shipholder battleship" ondragover="allowDrop(event)" ondrop="dropFilter(event, this)">
						<img id="battleship" class="ship" src="/Resources/Battleship/battleship.png" onclick="rotate(event)" draggable="true" ondragstart="drag(event)"/>
						<img class="bg" src="/Resources/Battleship/battleship_bg.png"/>
				</div>
				<div class="shipholder patrol" ondragover="allowDrop(event)" ondrop="dropFilter(event, this)">
						<img id="patrol" class="ship" src="/Resources/Battleship/patrol.png" onclick="rotate(event)" draggable="true" ondragstart="drag(event)"/>
						<img class="bg" src="/Resources/Battleship/patrol_bg.png"/>
				</div>
				<div class="shipholder submarine" ondragover="allowDrop(event)" ondrop="dropFilter(event, this)">
						<img id="submarine" class="ship" src="/Resources/Battleship/submarine.png" onclick="rotate(event)" draggable="true" ondragstart="drag(event)"/>
						<img class="bg" src="/Resources/Battleship/submarine_bg.png"/>
				</div>
			</div>
		</div>
		<div class="interface">
			<button onclick="start()">Start!</button>
		</div>
	</div>
</div>

<script>
	size();
	window.onresize = function(event) {
		size();
	}

	var game_started = false;
	var firing = false;

	function start(){
		game_started = !game_started;
		toggleClass(document.getElementById("game"), "active");
		var revealed = document.getElementsByClassName("revealed");
		for(var i = revealed.length - 1; i >= 0; i--){
			removeClass(revealed[i], "revealed");
		}
		if(game_started){
			//todo go through the ship list once and reset the x/y to 10;
			for(var ship in enemy_ships){
				ship.x = 100;
				ship.y = 100;
			}
			for(var ship in enemy_ship_list){
				place_enemy_ship(enemy_ship_list[ship]);
			}
		}

	}

	function size() {
		var window_height = "innerHeight" in window ? window.innerHeight : document.documentElement.offsetHeight;
		var window_width = document.getElementsByClassName("battleship")[0].offsetWidth;
		var size;

		if (window_height < window_width) {
			size = window_width / 2;
		} else {
			size = window_height / 2;
		}
		size *= .95;
		document.getElementsByClassName("ship_area")[0].style.width = size + "px";
		document.getElementsByClassName("radar")[0].style.width = size + "px";
		size *= .79;
		document.getElementsByClassName("ship_area")[0].style.height = size + "px";
		document.getElementsByClassName("radar")[0].style.height = size + "px";
	}

	function rotate(event) {
		if(game_started){
			return false;
		}
		toggleClass(event.target, "rotate");
		var id = event.target.getAttribute("id")
		player_ships[id].rotation = !player_ships[id].rotation;
		checkValidity(id);
	}

	function allowDrop(event) {
		event.preventDefault();
	}

	function drag(event) {
		if(game_started){
			return false;
		}
		addClass(event.target, "drag");
		event.dataTransfer.setData("text", event.target.id);
	}

	function drop(event, el) {
		event.preventDefault();
		if(game_started){
			return false;
		}
		var id = event.dataTransfer.getData("text");
		if(null !== document.getElementById(id)){
			el.appendChild(document.getElementById(id));
			removeClass(document.getElementById(id), "drag");
			var coords = el.getAttribute("data-coords").split("-");
			player_ships[id].start.x = parseInt(coords[0]);
			player_ships[id].start.y = parseInt(coords[1]);
			checkValidity(id);
		}
	}

	function dropFilter(event, el){
		event.preventDefault();
		if(game_started){
			return false;
		}
		var data = event.dataTransfer.getData("text");
		if(hasClass(event.currentTarget, data)){
			el.insertBefore(document.getElementById(data), event.currentTarget.firstChild);
		}
	}

	function checkValidity(id){
		var ship = player_ships[id];
		removeClass(document.getElementById(id), "error");
		//horizontal
		if(ship.rotation){
			if(ship.start.x - ship.size < -1){
				addClass(document.getElementById(id), "error");
			}
		//vertical
		} else {
			if(ship.start.y + ship.size > 10){
				addClass(document.getElementById(id), "error");
			}
		}
	}

	var destroyer = {start:{x:100, y:100}, size:3, rotation:false, hits:[3]};
	var battleship = {start:{x:100, y:100}, size:4, rotation:false, hits:[4]};
	var carrier = {start:{x:100, y:100}, size:5, rotation:false, hits:[5]};
	var submarine = {start:{x:100, y:100}, size:3, rotation:false, hits:[3]};
	var patrol = {start:{x:100, y:100}, size:2, rotation:false, hits:[2]};
	var player_ships = {"destroyer":destroyer, "battleship":battleship, "carrier":carrier, "submarine":submarine, "patrol":patrol};
	var enemy_ships = fullAssign(player_ships);
	var enemy_ship_list = ["destroyer", "battleship", "carrier", "submarine", "patrol"];

	function place_enemy_ship(shipname){
		var ship = enemy_ships[shipname];
		var ship_element = document.getElementById("target_" + shipname);

		var new_rotation = (0 == Math.floor(Math.random()));
		if(ship.rotation != new_rotation){
			toggleClass(ship_element, "rotate");
		}

		ship.rotation = new_rotation;

		var min_x = 0;
		var max_y = 9;
		(ship.rotation) ? max_y = 9 - ship.size : min_x = ship.size;
		var x = Math.floor((Math.random() * (10 - min_x)) + min_x);
		var y = Math.floor(Math.random() * max_y);
		var ship_spaces = [];
		for(var i = 0; i < ship.length; i++){
			ship_spaces[i] = (ship.y * 10) + ship.x;
		}
		for(var shiptwo in enemy_ships){
			for(var i = 0; i < shiptwo.length; i++){
				if(ship_spaces.indexOf((shiptwo.y * 10) + shiptwo.x) > -1){
					//retry
					place_enemy_ship(ship);
					return;
				}
			}
		}

		//success
		ship.x = x;
		ship.y = y;

		getChildByClass(getChildByClass(document.getElementById("game"), "radar"), "grid").children[0].children[y].children[x].children[0].appendChild(ship_element);

		return;
	}

	function fire(event, x, y){
		addClass(event.currentTarget, "revealed");
		var hit = false;
		for (var i in enemy_ships) {
			ship = enemy_ships[i];
			if(typeof ship === "object"){
				console.log("checks out okay");
				if(ship.rotation){
					if(y == ship.start.y && x < ship.start.x && x > ship.start.x - ship.size){
						hit = true;
						console.log("That's a whoppah");
					}
				} else {
					if(x == ship.start.x && y < ship.start.y && y > ship.start.y - ship.size){
						hit = true;
						console.log("That's a whoppah");
					}
				}
			}
		}
		if(hit == true){
			var img = document.createElement("img");
			event.target.appendChild(img);
			img.setAttribute("src", "/Resources/Battleship/hit.png");
		}
	}

</script>
