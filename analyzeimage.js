(function() {
    window.onload = function() {
        document.getElementById("button").onclick = processImage;
    };

    function checkStatus(response) {  
        if (response.status >= 200 && response.status < 300) {  
            return response.text();
        } else {
            return Promise.reject(new Error(response.status+": "+response.statusText));
        }
    }

    function processImage() {
        document.getElementById("responseTextArea").innerHTML = "loading...";

        // Replace the subscriptionKey string value with your valid subscription key.
        var subscriptionKey = "74b1a35a7ef84b74bdd9a60c1301e255";

        // Replace or verify the region.
        //
        // You must use the same region in your REST API call as you used to obtain your subscription keys.
        // For example, if you obtained your subscription keys from the westus region, replace
        // "westcentralus" in the URI below with "westus".
        //
        // NOTE: Free trial subscription keys are generated in the westcentralus region, so if you are using
        // a free trial subscription key, you should not need to change this region.
        var uriBase = "https://westcentralus.api.cognitive.microsoft.com/vision/v1.0/analyze";

        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };

        // Display the image.
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;

        // Perform the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),

            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", subscriptionKey);
            },

            type: "POST",

            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })

        .done(function(data) {
            // Show formatted JSON on webpage.
            console.log("fetching data");
            let url = "findall.php?word="
            var string = "";
            // Number of tags that should be processed
            let numtags = 1;
            for (var i = 0; i < numtags; i++) {
                fetch(url + data.description.tags[i])
                .then(checkStatus)
                .then(function(responseText) {
                    let data = JSON.parse(responseText);
                    for(let j = 0; j < data["phrases"].length; j++) {
                        string += data["phrases"][j]["phrase"] + "\n\n";
                    }
                    if(!string) {
                        document.getElementById("responseTextArea").innerHTML = "No captions were found for this image.";
                    } else {
                        document.getElementById("responseTextArea").innerHTML = string;
                    }
                })
                .catch(function(error) {
                    console.log("Error occured:" + error);
                });
            }
        })

        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " : errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" : jQuery.parseJSON(jqXHR.responseText).message;
            console.log(errorString);
        });
    };
})();