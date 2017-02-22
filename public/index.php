
    
<?php
    
    function render($view, $values = [])
    {
        // if view exists, render it
        if (file_exists("../views/{$view}"))
        {
            // extract variables into local scope
            extract($values);

            // render view (between header and footer)
            require("../views/header.php");
            require("../views/{$view}");
            require("../views/footer.php");
            exit;
        }

        // else err
        else
        {
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }
    
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
    
    if(isset($_GET["input"])){
        
        $url = $_GET["input"];
        $data = getHTML ($url,30);
        $regex1 = '/(?:\<div   class="category\-tupple clear\-width)(.*?)(?:\<script\>)/s';
        $regex2 ='/((?:"institute-title")(?:.*?)(?:title\=")(.*?)(?:"\>)(?:.*?)(?:\<span\>,)(.*?)(?:\<\/span\>))/s';
        $regex3 =  '/(?:font-1(?:2|6)")(?:.*?)(?:"\>)(.*?)(?:\<\/a\>)(?:.*?)(?:list\-col)(?:.*?)\>(.*?)(?:\<\/div\>)(?:.*?)(?:\<li\>)(.*?)(?:\<\/li\>)/s';
        $regex4 = '/(?:ranking)(?:.*?)(?:"\>)(.*?)(?:\<sub\>)/s';
        preg_match_all ($regex1,$data,$datax);
        render("output.php",["datax" => $datax,"regex2" => $regex2,"regex3" => $regex3,"regex4" => $regex4]);
    }
    else {
        render("form.php");
    }
?>

    