
    
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
        $regex1 = '/instituteContainer(.*?)Download Brochure/s';
        $regex2 ='/tuple-clg-heading"\>(?:.*?)"\>(.*?)\<\/a\>(?:.*?)\>\|(.*?)\<\/p\>/s';
        $regex3 = '/\<h3\>(.*?)\<\/h3\>/s';
        $regex4 ='/next linkpagination/s';
        $regex5 ='/tuple-revw-sec(?:.*?)\<b\>(.*?)\<\/b\>/s';
        $regex6 ='/\-\d/s';
        $regex7 ='/\/|\-/';
        $regex8 = '';
        
        $url = $_GET["input"];
        $data = getHTML ($url,30);
        
        $number=1;
        $alldata='';
        while(true) {
            
            preg_match_all ($regex4,$data,$pagination);
            if ($number ===200) {
            
                break;
            }
            print sizeof($pagination[0]);
            $number++;
            $change = '';
            $url2 = preg_replace ($regex6, $change, $url, $number);
            $url3 = $url."-".$count;
            $content = getHTML ($url3,30);
            $alldata = $alldata.$content;
        }
       
        preg_match_all ($regex1,$alldata,$datax);
        
        render("output.php",["datax" => $datax,"regex2" => $regex2,"regex3" => $regex3,"regex5" => $regex5,"regex4" => $regex4,"regex7" => $regex7]);
    }
    else {
        render("form.php");
    }
?>

    