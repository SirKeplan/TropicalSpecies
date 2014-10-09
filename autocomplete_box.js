	/** Makes search box show prompt text when not focused */
	var scrolling = false;
	var len = 0;
	//var pass = true;
	
function togglePrompt (box, focus) {
	var ele = document.getElementById("searchResults");
	//if (pass) {
		ele.style.display = "none";
		//(focus?"block":"none");
		//pass = true;
	//}
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

function doSomething(e, box) {
    if (e.target !== e.currentTarget) {
		box.style.cssText = "font-style: normal;color: black;";

		//pass = false;
		//alert(e.target.innerHTML);
        box.value = e.target.innerHTML;	
        
        box.focus();
        var ele = document.getElementById("searchResults");
		ele.style.display = "none";
    }
    e.stopPropagation();
	//alert("wtf! this is a click?");
}
function selectItem(e, box) {
	var key = e.which || e.keyCode;

	if (key == 38) {
		var ele = document.getElementById("searchResults");
		ele.selectedIndex -=1;
		e.stopPropagation();
		box.value = ele.options[ele.value].text;
		scrolling = true;
		box.setSelectionRange(len,box.value.length);
		return;
	}
	else if (key == 40) {  
		var ele = document.getElementById("searchResults");
		ele.selectedIndex +=1;
		e.stopPropagation();
		box.value = ele.options[ele.value].text;
		scrolling = true;
		box.setSelectionRange(len,box.value.length);

	}
}

function getResults(e, box, typed) {	
	if (typed.length == len) {
		return;
	}	
	var ele = document.getElementById("searchResults");
	
	ele.style.display = "block";
	if (scrolling) {
		scrolling = false;

		return;
	}

	
	len = typed.length;
	//~ if (e.keyCode === 37 || e.keyCode === 39 ||e.keyCode === 8 || e.keyCode === 16 || e.ctrlKey) { // ARROW LEFT or ARROW RIGHT or SHIFT key
        //~ return;
    //~ }
	var xmlhttp;
	if (typed.length==0)
	  { 
	  document.getElementById("searchResults").innerHTML="";
	 // document.getElementById("searchResults").size=0;
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()  {
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var strings = xmlhttp.responseText.split(";");
			var out = "";
			if (strings.length <= 1) {
				return;
			}
			for (var index = 0; index < (strings.length-1); index++) {
				out += "   <option class=\"searchRes\" value="+index+">"+strings[index]+"</option>\n";
			}
			document.getElementById("searchResults").innerHTML=out;//xmlhttp.responseText.split("\n");
			document.getElementById("searchResults").size=6;
			//	var e = evt || event;
			var key = e.which || e.keyCode;

			if (key == 8) {
				//box.setSelectionRange(len,box.value.length);

				//box.value = typed.substring(0,typed.length-1);
				return;
			}
			 
			box.value += strings[0].substring(typed.length,strings[0].length);
			box.setSelectionRange(typed.length,strings[0].length);
			//len = typed.length;

		}
	  }
	xmlhttp.open("GET","tsresults.php?typed="+typed,true);
	xmlhttp.send();
}
