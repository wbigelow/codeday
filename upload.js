"use strict";
(function() {

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


	function sendLine(line) {
		let url = "https://students.washington.edu/wbigelow/insert.php";
		let data = new FormData();
		data.append("phrase", line);
		fetch(url, {method: "POST", body: data})
			.then(checkStatus)
			.then(function(responseText) {
				console.log(JSON.parse(responseText));
			})
			.catch(function(error) {
				alert("Error occured:" + error);
			});
	}

})();