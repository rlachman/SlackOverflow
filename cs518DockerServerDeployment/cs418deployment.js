function updateRepoFromCSUsername(){

  //alert(e.keyCode);
  /*****
  if(e.keyCode != 13)
  {
	return;
  }
  /*****/

  var repoStr = document.getElementById('srcRepo');

  if(document.getElementById("githubAuthButton")){document.getElementById("githubAuthButton").disabled = "disabled";}

  if(document.getElementById('csusername').value == ""){
    repoStr.innerHTML = none;
    repoStr.className = "";
  }


  // Vanilla Ajax. Nothing to see here. Move along.
  var request = new XMLHttpRequest();

  // Send an AJAX request for CS user's GH URI. Sync needed to due expected in-order response (key-binding)
  request.open('GET','?username='+document.getElementById('csusername').value, false);

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {

      var resp = request.responseText;
      console.log(request.status);
      console.log(resp);

      repoStr.innerHTML = resp;
      repoStr.className = "ok";
      if(document.getElementById('repoURI') != null){document.getElementById('repoURI').value = resp;}

      // Parse out username
      var re = new RegExp(/.*\/(.*)\/.*/);
      var githubId = re.exec(resp)[1];

      if(!document.getElementById("githubAuthButton")){return;} //we have already auth'd, no need for button manipulation

      document.getElementById("githubAuthButton").removeAttribute("disabled");

    } else {
      console.log("Error in response");
      repoStr.innerHTML = "Invalid User";
      repoStr.className = "invalid";
    }
  };

  request.onerror = function() {
    console.log("Error in request");
    repoStr.innerHTML = "Error in response";
    repoStr.className = "invalid";
  };

  //alert("sending...");

  request.send();

}

document.addEventListener("DOMContentLoaded", function(event) {
  //document.getElementById('csusername').onkeyup = updateRepoFromCSUsername;

  document.getElementById("csusername").value

  if(document.getElementById("csusername").value != ""){
    //updateRepoFromCSUsername(event);
    updateRepoFromCSUsername(event);
  }

  document.getElementById('githubAuthButton').addEventListener("click", authenticateWithGitHub);
});
