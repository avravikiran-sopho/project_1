<?php

    $count=1;
    $lenght = sizeof ($datax[0]);
    $number = (int)($lenght/30);
    print "<div class ='container'><h3>Displaying ".$lenght." results...</h3></div>
    <div class='container'><h4>Agenda</h4><table class='table table-striped'>
    <tr><td>A/C Classrooms</td><td><img src='../img/A_C Classrooms.png'></td><td>Auditorium</td><td><img src='../img/Auditorium.png'></td></tr>
    <tr><td>Cafeteria</td><td><img src='../img/Cafeteria.png'></td><td>Convenience Store</td><td><img src='../img/Convenience Store.png'></td></tr>
    <tr><td>Dance Room</td><td><img src='../img/Dance Room.png'></td><td>Design Studio</td><td><img src='../img/Design Studio.png'></td></tr>
    <tr><td>Gym</td><td><img src='../img/Gym.png'></td><td>Hospital _ Medical Facilities</td><td><img src='../img/Hospital _ Medical Facilities.png'></td></tr>
    <tr><td>Hostel</td><td><img src='../img/Hostel.png'></td><td>Labs</td><td><img src='../img/Labs.png'></td></tr>
    <tr><td>Library</td><td><img src='../img/Library.png'></td><td>Moot Court (Law)</td><td><img src='../img/Moot Court (Law).png'></td></tr>
    <tr><td>Music Room</td><td><img src='../img/Music Room.png'></td><td>Shuttle Service</td><td><img src='../img/Shuttle Service.png'></td></tr>
    <tr><td>Sports Complex</td><td><img src='../img/Sports Complex.png'></td><td>Wi_Fi Campus</td><td><img src='../img/Wi_Fi Campus.png'></td></tr>
    </table></div>";
    foreach ($datax[0] as $college) {
        if (($count-1)%30===0) {
            print "<div class='container' id='".(($count-1)/30)."'>";
            for ($i=0;$i<=$number;$i++) {
                if ($i===($number)){
                    print "<a href='#".($i)."'><button class='buton'><b>".(($i*30)+1)."-".$lenght."</b></button></a>";                        
                }
                else {
                    print "<a href='#".($i)."'><button class='buton'><b>".(($i*30)+1)."-".(($i+1)*30)."</b></button></a>";    
                }
                
            }
            print "</ul></div>";
        }
        preg_match_all ($regex2,$college,$ColInf);
        print "<div class='container'><h3>".$count.".".$ColInf[1][0].",</h3><h5>".$ColInf[2][0]."</h5><br><h4>Facilities: 
        </h4><div class='images'>";
        //$images = array("Library","Cafeteria","Hostel","Sports Complex","Gym","Hospital /Medical Facilities",
        //"Wi-Fi Campus","Shuttle Service","Auditorium","A/C Classrooms","Labs");
        //$img_names= array("library","cafeteria","hostel","sports","gym","hospital","wifi","shuttle","auditorium","ac","lab");
        preg_match_all ($regex3,$college,$facilities);
        foreach ($facilities[1] as $facility) {
            $img = preg_replace($regex7,'_',$facility,1);
            //$key = array_search($facility, $images);
            //print "<img src='../img/".$img_names[$key].".png'>";
            print "<abbr title='".$facility."'><img src='../img/".$img.".png'><abbr>";
        }
        preg_match_all ($regex5,$college,$reviews);
        print "</div>";
        if ($reviews[1][0]!='') {
            print "<br><h3>".$reviews[1][0]." Reviews</h3>";
        };
        
        print "</div>";
        $count++;
    };
    print "<div class='container'><a href='#top'>Top</a></div>"

?>
