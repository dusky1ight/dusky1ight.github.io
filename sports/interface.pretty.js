function sendRequest() {
  const httpMethod = document.getElementById("http-method").value;
  const disabledInput = document.getElementById("disabledInput").value;
  const resource = document.getElementById("resource").value;
  const result = document.getElementById("response-body");
  const resultText = disabledInput + resource;
  const requestBody = document.getElementById("request-body").value;

  if (resource === "" || resultText === disabledInput) {
    result.innerText = "Invalid URL()";
  } else if(httpMethod===""){
  result.innerText = "Invalid HTTP Method";
  }
  
  else {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
      if (this.readyState === 4) {
        if (xhr.status === 0) {
          result.innerText = "Error: Please check the resources#.";
        } else if (xhr.status === 405) {
          result.innerText = "Error: Method not allowed.";
          }
          else {
          document.getElementById("status-code").textContent = xhr.status;
          const responseJson = JSON.parse(xhr.responseText);
          document.getElementById("response-body").textContent = JSON.stringify(responseJson, null, 2);
        }
      }
    };

    xhr.open(httpMethod, resultText, true);

    if (
      httpMethod === "POST" ||
      httpMethod === "PUT" ||
      httpMethod === "DELETE" ||
      httpMethod === "GET"
    ) {
      xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
      xhr.send(requestBody);
    }
  }
}



        function clearResponse() {
            document.getElementById("status-code").textContent = "";
            document.getElementById("response-body").textContent = "";
        }
        

      
      function toggleDisabled() {
        const disabledInput = document.getElementById('disabledInput');
        disabledInput.disabled = !disabledInput.disabled;
      }

        function showRequestBody() {
            const httpMethod = document.getElementById("http-method").value;
            const requestBodyFields = document.getElementById("request-body-fields");
            if (httpMethod === "POST" || httpMethod === "PUT") {
                requestBodyFields.style.display = "block";
            } else {
                requestBodyFields.style.display = "none";
            }
        }
        
        
        var collapsi = document.querySelectorAll("li.collapsible");
  

        const httpMethodDropdown = document.getElementById("http-method");
        httpMethodDropdown.addEventListener("change", showRequestBody);
        window.onload = function() {
        
  showRequestBody();
};
