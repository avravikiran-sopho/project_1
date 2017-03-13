<?php

    $count=1;
    $lenght = sizeof ($datax[0]);
    print "<div class ='container'><h3>Displaying ".$lenght." results...</h3></container>";
    foreach ($datax[0] as $college) {
    preg_match_all ($regex2,$college,$ColInf);
    print "<hr><div class='container'><h2>".$count.".".$ColInf[1][0].$ColInf[2][0]."</h2>";
    preg_match_all ($regex4,$college,$facilities);
    
    preg_match_all ($regex5,$college,$reviews);
    print "<h3>".$reviews[0][0]." Reviews</h3></div>";
    $count++;
};

?>
