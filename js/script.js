var timeoutTotal = document.getElementById("timeout").value * 1;
var timeout = timeoutTotal;

if(timeout != -1){
	window.setInterval(function(){
		if(timeout == 0){
			location.reload();
		} else {
			timeout -= 1000;
			document.getElementById("remaining-time").innerHTML = timeout / 1000;
		}
	}, 1000);
} else {
	document.getElementById("remaining-time").remove();
}