window.onload = function() {
	var Time = 5;
	setInterval(function() {
		document.getElementById("time").innerHTML = Time;
		Time = Time - 1;
		if (Time < 0) {
			Time = 0;
		}
	}, 1000)
}