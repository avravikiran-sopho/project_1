
    
<?php
   
    
    function getHTML($url,$timeout)
    {
        $ch = curl_init($url); // initialize curl with given url
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
        return @curl_exec($ch);
        
    }    
    
    $a = $_GET["input"];
    $data = getHTML ($a,30);
    $regex = '/(?:"institute-title")(?:.*?)title\="(.*?)"\>(?:.*?)\<span\>,(.*?)\<\/span\>/s';
    preg_match_all ($regex,$data,$datax);
    print "<table><tr><th>College Name</th><th>Address</th></tr>";
    for ($i=0;$i<31;$i++) {
    print "<tr><td>".$datax[1][$i]."</td><td>".$datax[2][$i]."</tr>";
    }
    print "</table>"
    

?>

<!DOCTYPE html>
    <html>
    <head>
        <title> abcd </title>
    </head>
    <body>
        <h1>enter url</h1>
        <form method="GET" action="index.php">
            <input type="textbox" name="input">
        </form>
    </body>
    </html>