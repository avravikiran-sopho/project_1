
    
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
    $regex1 = '/(?:\<div   class="category\-tupple clear\-width)(.*?)(?:\<script\>)/s';
    $regex2 ='/((?:"institute-title")(?:.*?)(?:title\=")(.*?)(?:"\>)(?:.*?)(?:\<span\>,)(.*?)(?:\<\/span\>))/s';
    $regex3 =  '/(?:font-1(?:2|6)")(?:.*?)(?:"\>)(.*?)(?:\<\/a\>)(?:.*?)(?:list\-col)(?:.*?)\>(.*?)(?:\<\/div\>)(?:.*?)(?:\<li\>)(.*?\<\/li\>)/s';
    $regex4 = '/(?:ranking)(?:.*?)(?:"\>)(.*?)(?:\<sub\>)/s';
    //stores all information of each college in $datax[1][$i] 
    preg_match_all ($regex1,$data,$datax);
    
    
    //print $datax[0][1];
    
    $le = sizeof ($datax[0]);
    for ($i=0;$i<$le;$i++) {
        $datax1 = $datax[0][$i];
        preg_match_all ($regex2,$datax1,$datax2);
        preg_match_all ($regex4,$datax1,$datax4);
        print "<span><h2>".$datax2[2][0]."</h2>,".$datax2[3][0].",<b>".$datax4[1][0]."</b></span>";
        preg_match_all ($regex3,$datax1,$datax3);
        $len = sizeof ($datax3[1]);
        print "<table><tr><th>DEGREE</th><th>FEE</th><th>ELIGIBILITY</th>";
        for ($j=0;$j<$len;$j++) {
            print "<tr><td>".$datax3[1][$j]."</td><td>".$datax3[2][$j]."</td><td>".$datax3[3][$j]."</td></tr>";
            
        }
        print "</table><hr/>";
    }
     
    
    


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