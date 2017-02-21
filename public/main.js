    var ourRequest = new XMLHttpRequest();
    ourRequest.open ('GET','https://www.w3schools.com');
    ourRequest.onload = function() {
        cosole.log (ourRequest.resonseText);
    }
    ourRequest.send();