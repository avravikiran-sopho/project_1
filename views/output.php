<?php

    $count=0;
    $lenght = sizeof ($sorteddata);
    $number = (int)($lenght/30);
    // print images agenda
    print "<div class ='display'><h3>Displaying ".$lenght." results...</h3></div>
    <div class='container'><h4>Agenda</h4><table class='table table-striped'>
    <tr><td>A/C Classrooms</td><td><img src='../img/A_C Classrooms.png'></td><td>Auditorium</td><td><img src='../img/Auditorium.png'></td></tr>
    <tr><td>Cafeteria</td><td><img src='../img/Cafeteria.png'></td><td>Convenience Store</td><td><img src='../img/Convenience Store.png'></td></tr>
    <tr><td>Dance Room</td><td><img src='../img/Dance Room.png'></td><td>Design Studio</td><td><img src='../img/Design Studio.png'></td></tr>
    <tr><td>Gym</td><td><img src='../img/Gym.png'></td><td>Hospital _ Medical Facilities</td><td><img src='../img/Hospital _ Medical Facilities.png'></td></tr>
    <tr><td>Hostel</td><td><img src='../img/Hostel.png'></td><td>Labs</td><td><img src='../img/Labs.png'></td></tr>
    <tr><td>Library</td><td><img src='../img/Library.png'></td><td>Moot Court (Law)</td><td><img src='../img/Moot Court (Law).png'></td></tr>
    <tr><td>Music Room</td><td><img src='../img/Music Room.png'></td><td>Shuttle Service</td><td><img src='../img/Shuttle Service.png'></td></tr>
    <tr><td>Sports Complex</td><td><img src='../img/Sports Complex.png'></td><td>Wi_Fi Campus</td><td><img src='../img/Wi_Fi Campus.png'></td></tr>
    </table></div><div class='container'>";
    
    //print each college in a div
    foreach ($sorteddata as $college) {
        //print nav bar after every 30 colleges
        if (($count)%30===0) {
            print "<div class='container' id='".(($count)/30)."'>";
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
        print "<div class='college'></span><p class='clg-heading'>".($count+1).". ".$college[0].",</p><p class='clg-address'>".$college[1]."</p><p class='facilities'>Facilities: 
        </p><div class='images'>";
        //print images for each facility
        foreach ($college[2] as $img) {
            print "<abbr title='".$facility."'><img src='../img/".$img.".png'><abbr>";
        }
        
        //print reviews
        print "</div>";
        if ($college[3]!='') {
            print "<p class='reviews'>".$college[3]." Reviews</p>";
        };
        
        print "</div>";
        $count++;
    };
    print "</div><div class='navtop' ><a href='#top'><button class='buton'>Top</button></a></div>"
?>
