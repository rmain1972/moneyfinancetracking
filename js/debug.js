function getMedia() {
		var x = window.innerWidth;
		var y = window.innerHeight;
		var elem = document.getElementById("data");
		
		elem.innerHTML = "<p>Width (X) = " + x + "<BR> Height (y) = " + y + "</p>";
	}