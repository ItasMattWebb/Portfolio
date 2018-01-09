<?php

	$page = Page::getInstance();
	$page->title = "Unit Converter";
	
class Unit{
	
	public $name;
	public $type;
	public $ratio;
	public $abbreviation;
	
	public function __construct($name, $abbreviation, $type, $ratio){
		$this->name = $name;
		$this->type = $type;
		$this->ratio = $ratio;
		$this->abbreviation = $abbreviation;
	}
	
}

$units = array(
	new Unit("long tons", "t", "weight", 2240),
	new Unit("stones", "st", "weight", 14),
	new Unit("pounds", "lb", "weight", 1),
	new Unit("ounces", "oz", "weight", 1/16),
	new Unit("kilograms", "kg", "weight", 1/2.2046226218),
	new Unit("grams", "g", "weight", 1/2204.6226218),
	new Unit("newtons", "N", "weight", 1/(2.2046226218 * 9.8)),
	new Unit("yards", "yd", "length", 36),
	new Unit("feet", "ft", "length", 12),
	new Unit("inches", "in", "length", 1),
	new Unit("kilometers", "km", "length", 39370.08),
	new Unit("meters", "m", "length", 39.37008),
	new Unit("centimeters", "cm", "length", 0.3937008),
);

?>

<form onsubmit="convert()" class="floater">
	<div class="title">
		<div class="half">
			<h1 class="t1">Convert</h1>
		</div>
		<div class="half end">
			<h1 class="t3">Units</h1>
		</div>
	</div>
	<div class="module">
		<div class="half">
			<input name="input" type="number" step="any" onKeyUp="convert()" min="0" />
			<select name="input_unit">
				<option value="">Select One</option>
				<?php
				foreach($units as $key => $unit){
				?>
					<option value="<?=$unit->ratio; ?>" data-type="<?=$unit->type; ?>"><?=ucwords(strtolower($unit->name)); ?> (<?=$unit->abbreviation; ?>)</option>
				<?php
				}
				?>
			</select>
		</div>
		<div class="half">
			<input name="output"  type="number" step="any" />
			<select name="output_unit">
				<option value="">Select One</option>
				<?php
				foreach($units as $key => $unit){
				?>
					<option value="<?=$unit->ratio; ?>" data-type="<?=$unit->type; ?>"><?=ucwords(strtolower($unit->name)); ?> (<?=$unit->abbreviation; ?>)</option>
				<?php
				}
				?>
			</select>
		</div>
	</div>
</form>
	<script type="text/javascript">
		document.onload = function(){
			document.getElementsByName("output_unit")[0].selectedIndex = 0;
			document.getElementsByName("input_unit")[0].selectedIndex = 0;
		}
		document.getElementsByName("input_unit")[0].onchange = function(){
			var type;
			if(this.selectedIndex == -1){
				return null;	
			} else {
				type = this.options[this.selectedIndex].getAttribute("data-type");
			}
			var item;
			for(var i = 1; i < document.getElementsByName("output_unit")[0].children.length; ++i) {
				item = document.getElementsByName("output_unit")[0].children[i];
				if(item.getAttribute("data-type") == type){
					item.setAttribute("class", "")
				} else{
					if(item.selected == true){
						document.getElementsByName("output_unit")[0].selectedIndex = 0;
					}
					item.setAttribute("class", "hidden");
				}
			};
			convert();
		}
		
		document.getElementsByName("input")[0].onchange = function(){convert();};
		document.getElementsByName("output_unit")[0].onchange = function(){convert();};
		function convert(){
			var value = document.getElementsByName("input")[0].value;
			var multiplier = document.getElementsByName("input_unit")[0].value;
			var divider = document.getElementsByName("output_unit")[0].value;
			var output = Math.round((value * multiplier / divider) * 1000)/1000;
			if(isFinite(output)){
				document.getElementsByName("output")[0].value = output;
			} else {
				document.getElementsByName("output")[0].value = 0;
			}
		}
		
	</script>