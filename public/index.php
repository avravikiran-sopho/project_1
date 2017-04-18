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
    
    //getHTML function which uses curl to fetch raw HTML
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
    
    //if form is submitted
    if(isset($_GET["input"])){
        //declare all regex required
        
        //for all data of single college
        $regex1 = '/instituteContainer(.*?)Download Brochure/s';
        //heading and address
        $regex2 ='/tuple-clg-heading"\>(?:.*?)"\>(.*?)\<\/a\>(?:.*?)\>\|(.*?)\<\/p\>/s';
        //facilities
        $regex3 = '/\<h3\>(.*?)\<\/h3\>/s';
        //checking for next page
        $regex4 ='/next linkpagination/s';
        //reviews
        $regex5 ='/tuple-revw-sec(?:.*?)\<b\>(.*?)\<\/b\>/s';
        //page no in url
        $regex6 ='/\-[0-9].*/s';
        //images names
        $regex7 ='/\/|\-/';
        
        
        //get all the pages of a city by looping until there is no next page
        $url = $_GET["input"];
        $pages = 1;
        //add all data of colleges in $alldata
        $alldata='';
        $change = '';
        while(true) {
            sleep(1);
            $data = getHTML ($url,100);
            $alldata = $alldata.$data;
            preg_match_all($regex4, $data, $pagination, PREG_SET_ORDER, 0);
            if (sizeof($pagination[0])===0) {
                break;
            }
            $pages++;
            $url2 = preg_replace ($regex6, $change, $url);
            $url = $url2."-".$pages;
            print $url."<br>";
        }
        //store all useful information of colleges in $datax
        preg_match_all ($regex1,$alldata,$datax);
        //render output.php
        render("output.php",["datax" => $datax,"regex2" => $regex2,"regex3" => $regex3,"regex5" => $regex5,"regex4" => $regex4,"regex7" => $regex7]);
    }
    else {
        render("form.php");
    }
?>