
function hasClass(element, className) {
	return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
}

function addClass(element, className) {
	if(!hasClass(element, className)){
		element.className += " " + className;
	}
}

function removeClass(element, className) {
	var offset = (' ' + element.className + ' ').indexOf(' ' + className + ' ');
	var length = className.length;
	if(offset > -1){
		if(offset > 0){
			offset--;
			length++;
		}
		element.className = element.className.substring(0, offset) + element.className.substring(offset + length) ;
	}
}

function toggleClass(element, className) {
	if(!hasClass(element, className)){
		addClass(element, className);
	} else {
		removeClass(element, className);
	}

}

function getChildByClass(elem, name){
	for (var i = 0; i < elem.childNodes.length; i++) {
		if (hasClass(elem.childNodes[i], name)) {
			return elem.childNodes[i];
		}
	}
	return false;
}

function dump(obj) {
	var out = '';
	for (var i in obj) {
		out += i + ": " + obj[i] + "\n";
		if(typeof obj[i] === "object"){
			out += minidump(obj[i]);
		}
	}
	console.log(out);
}

function minidump(obj) {
	var out = '';
	for (var i in obj) {
		out += i + ": " + obj[i] + "\n";
		if(typeof obj[i] === "object"){
			minidump(obj[i]);
		}
	}
	return out;
}

function fullAssign(obj){
	var target = {};
	if(typeof obj === "object"){
		for (var i in obj) {
			if(typeof obj[i] === "object"){
				target[i]= fullAssign(obj[i]);
			} else {
				target[i] = obj[i]
			}
		}
	}
	return target;
}