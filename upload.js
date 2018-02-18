// Allows a user to upload quotes to the database
// by uploading a txt file containing quotes
// separated by new line characters.
"use strict";
(function() {
	window.onload = function() {
		document.getElementById('file').onchange = function(){
			document.getElementById("status").innerText = "Upload Status: File uploading, do not close this window";
			var file = this.files[0];
			var reader = new FileReader();
			reader.onload = function(progressEvent){
				// Read lines of file, send individually.
				var lines = this.result.split('\n');
				for(var line = 0; line < lines.length; line++){
					sendLine(lines[line]);
				}
			};
			reader.readAsText(file);
		};
	};

	// Checks the status of a given response from an ajax call. Returns
	// the response text if the response status is valid, returns a
	// rejected promise otherwise.
	function checkStatus(response) {  
		if (response.status >= 200 && response.status < 300) {  
			return response.text();
		} else {
			return Promise.reject(new Error(response.status+": "+response.statusText));
		}
	}

	// Posts the given line to the database, storing it.
	// Logs an error on duplicate quotes.
	function sendLine(line) {
		let url = "https://students.washington.edu/wbigelow/insert.php";
		let data = new FormData();
		data.append("phrase", line);
		fetch(url, {method: "POST", body: data})
			.then(checkStatus)
			.then(function(responseText) {
				console.log("phrase uploaded");
			})
			.catch(function(error) {
				console.log("Error occured:" + error);
			});
	}
})();