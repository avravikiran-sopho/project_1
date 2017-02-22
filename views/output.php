<?php
$NofC = sizeof ($datax[0]);
foreach ($datax[0] as $college) {
    preg_match_all ($regex2,$college,$ColInf);
    print "<span><h2>".$ColInf[2][0]."</h2>,".$ColInf[3][0].",<b>".$rank[1][0]."</b></span>";
    preg_match_all ($regex4,$college,$rank);
    preg_match_all ($regex3,$college,$degrees);
    print "<table><tr><th>DEGREE</th><th>FEE</th><th>ELIGIBILITY</th>";
    for ($j=0;$j<sizeof($degrees[1]);$j++) {
        print "<tr><td>".$degrees[1][$j]."</td><td>".$degrees[2][$j]."</td><td>".$degrees[3][$j]."</td></tr>";
    }
    print "<table><hr/>";
}
?>
