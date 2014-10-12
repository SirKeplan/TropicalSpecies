
function findRow3(node) {
    var i = 0;
    while (node = node.previousSibling) {
        if (node.nodeType === 1) { ++i }
    }
    return i;
}
function AutoCompleteBox(param_box,param_results) {
	/** Makes search box show prompt text when not focused */
	var scrolling = false;
	var len = 0;
	var lastLen = 0;
	var selected = -1;// -1 = no item in list/just typed text, 0 or greater is the index in the list
	var original = "";
	
	var ele = document.getElementById(param_results);
	var box = document.getElementById(param_box);
	
	var that = this;

	this.togglePrompt2 = function (focus) {

		ele.style.display = "none";

		if (box.value != box.defaultValue && box.value != "") {
			return;
		}
		box.value = (focus?"":box.defaultValue);
		if (focus) {
			box.style.cssText = "font-style: normal;color: black;";
		}else {
			box.style.cssText = "font-style: italic;color: grey;";
		}
	}
	this.doClick = function (e) {
		if (e.target !== e.currentTarget) {
			box.style.cssText = "font-style: normal;color: black;";

			box.value = e.target.innerHTML;	
			
			ele.style.display = "none"; 
			box.focus();
			box.setSelectionRange(box.value.length,box.value.length);

			return false;

		}
		e.stopPropagation();
	}
	
	this.onHover = function(e) {
		if (e.target !== e.currentTarget) {
			e.target.className += " autoListItemHover";
			that.scroll(e, findRow3(e.target), false);
		}
	}
	this.onUnHover = function (e) {
		if (e.target !== e.currentTarget) {
			e.target.className = "autoListItem";//TODO: remove
		}
	}
	
	this.scroll = function (e, index, keyNav) {
		scrolling = true;
		if (selected >= 0) {
			var item = ele.children[selected];
			item.className = "autoListItem";
			ele.children[selected] = item;
		}
		selected = index;
		//scrolling up from typed text into autocomplete
		if (selected < -1 ) {
			selected = ele.children.length-1;
		}
		if (selected < 0 || selected >= (ele.children.length)) {
			selected = -1;
			box.value = original;
			box.setSelectionRange(len,box.value.length);
			return false;
		}
		
		var item = ele.children[selected];//
		item.className += " autoListItemHover";
		if (keyNav) {
			ele.scrollTop = (item.offsetTop-ele.offsetHeight)+item.offsetHeight;
		}
		ele.children[selected] = item;

		e.stopPropagation();
		box.value = item.innerHTML;
		box.setSelectionRange(len,box.value.length);
	}
	//keydown
	this.selectItem = function (e) {
		var key = e.which || e.keyCode;
		if (key == 38) {//up
			that.scroll(e, selected -1, true);
			return false;
		} else if (key == 40) {  //down
			that.scroll(e, selected +1, true);
			return false;
		}	
	}
	//keyup
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var abortRequest = false;

	this.getResults = function (e, typed) {	
		
		if (e.ctrlKey==1 || e.keyCode == 17) {//ctrl was down?
			return;
		}
		lastLen = len;
		if (typed.length == lastLen) {
			return;
		}
		
		ele.style.display = "block";
		if (scrolling) {
			scrolling = false;
			return false;
		}
		selected =-1;
		original = typed;
		
		len = typed.length;

		if (typed.length==0) { 
			while (ele.firstChild) {
				ele.removeChild(ele.firstChild);
			}
			ele.style.display = "none"; 

			return;
		}
		
		if (abortRequest) {
			xmlhttp.abort();
		}
		abortRequest = true;
		xmlhttp.onreadystatechange=function()  {
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				abortRequest = false;
				var strings = xmlhttp.responseText.split(";");
				var out = "";
				if (strings.length <= 1) {
					return;
				}
				while (ele.firstChild) {
					ele.removeChild(ele.firstChild);
				}
				for (var index = 0; index < (strings.length-1); index++) {
					var div=document.createElement("div");
					div.className = "autoListItem";
					div.textContent = strings[index];
					ele.appendChild(div);
				}

				var key = e.which || e.keyCode;

				if (key == 8) {//backspace
					//box.setSelectionRange(len,box.value.length);

					//box.value = typed.substring(0,typed.length-1);
					return;
				}
				/*temp 
				box.value = typed + strings[0].substring(typed.length,strings[0].length);
				box.setSelectionRange(typed.length,strings[0].length);
				*/
				//len = typed.length;

			}
		}
		xmlhttp.open("GET","tsresults.php?typed="+typed,true);
		xmlhttp.send();
	}
	
	box.onfocus = function () {that.togglePrompt2(true)};
	box.onblur = function () {that.togglePrompt2(false)};
	
	box.onkeydown = function (e) {return that.selectItem(e)};
	box.onkeyup = function (e) {return that.getResults(e, box.value)};//shouls use onkeypress instead?
	
	ele.onmousedown = function (e) {return that.doClick(e);};
	ele.onmouseover = function (e) {return that.onHover(e);};
	ele.onmouseout = function (e) {return that.onUnHover(e);};
			
}
