<?php
    
    include("../includes/config.php");
    
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
        //city name
        $regex8 ='/colleges\-(.*?)\-[0-9].*/s';
        
        //get all the pages of a city by looping until there is no next page
        $rawurl = $_GET["input"];
        $url = preg_replace($regex6,"", $rawurl);

        $pages = 1;
        //add all data of colleges in $alldata
        $alldata='';
        $change = '';
        $sorteddata=[];
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
        }
        //store all useful information of colleges in $datax
        $number=0;
        preg_match_all ($regex1,$alldata,$datax);
        foreach ($datax[0] as $college) {
            preg_match_all ($regex2,$college,$ColInf);
            $sorteddata[$number]=[$ColInf[1][0],$ColInf[2][0]];
            //print $colInf[1][0]." ".$colInf[2][0];
            preg_match_all ($regex3,$college,$facilities);
            $images=[];
            foreach ($facilities[1] as $facility) {
            $img = preg_replace($regex7,'_',$facility,1);
            array_push($images,$img);
            }
            array_push($sorteddata[$number],$images);
            preg_match_all ($regex5,$college,$reviews);
            if ($reviews[1][0]!='') {
                array_push($sorteddata[$number],$reviews[1][0]);
            };
            $number++;
        }
        preg_match_all ($regex8,$url,$city);
        
        foreach ($sorteddata as $college) {
            $query = sprintf("INSERT IGNORE INTO colleges (name,address,city,reviews) VALUES('%s','%s','%s','%s')",$college[0],$college[1],$city[1][0],$college[3]);
            mysqli_query($link, $query);
            $query =sprintf("SELECT * FROM colleges WHERE name='%s'",$college[0]);
            $rows=mysqli_query($link, $query);
            $collid = mysqli_fetch_array($rows)["id"];
            
            foreach ($college[2] as $facility){
                $query =sprintf("SELECT * FROM facids WHERE facility='%s'",$facility);
                $facilityid=mysqli_query($link, $query);
                $facid = mysqli_fetch_array($facilityid)["id"];
                $query =sprintf("INSERT IGNORE INTO facilities (college_id,fac_id) VALUES('%s','%s')",$collid,$facid);
                mysqli_query($link, $query);
                
            }
        }
        //render output.php
        render("output.php",["sorteddata"=>$sorteddata]);
    }
    else {
        render("form.php");
    }
?>