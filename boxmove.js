//find all spans under a span with class ref
//and if they are on the far right of the page, move them left 250px ish


 function boxMove() {
	var refspans = document.getElementsByClassName('ref');	

	w = window.outerWidth;
	for (var i = 0; i < refspans.length; ++i) {
		var item = refspans[i].lastChild; 
		if (w - item.getBoundingClientRect().left < 350) {
			item.style.left = "-240px";
		}else {
			item.style.left = "-1px";
		}
	}
 }
 
 boxMove();
 window.onresize = boxMove;
