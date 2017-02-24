<?php

$count=1;
$lenght = sizeof ($datax[0]);
print "<div class ='container'><h3>Displaying ".$lenght." results...</h3></container>";
foreach ($datax[0] as $college) {
    preg_match_all ($regex2,$college,$ColInf);
    print "<hr><div class='container'><span><h2>".$count.".".$ColInf[2][0]."</h2>,".$ColInf[3][0].",<b>".$rank[1][0]."</b></span>";
    preg_match_all ($regex4,$college,$rank);
    preg_match_all ($regex3,$college,$degrees);
    $count++;
?>
<table class="table table-striped"><tr><th>DEGREE</th><th>FEE</th><th>ELIGIBILITY</th>
<?php
    for ($j=0;$j<sizeof($degrees[1]);$j++) {
        print "<tr><td>".$degrees[1][$j]."</td><td>".$degrees[2][$j]."</td><td>".$degrees[3][$j]."</td></tr>";
    }
    print "<table></div><hr/>";
}

?>
