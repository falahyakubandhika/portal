<?php

//*********************************************************
// DRAW CALENDAR
//*********************************************************
/*
    Draws out a calendar (in html) of the month/year
    passed to it date passed in format mm-dd-yyyy 
*/
function mk_drawCalendar($m,$y)
{
    if ((!$m) || (!$y))
    { 
        $m = date("m",mktime());
        $y = date("Y",mktime());
    }

    /*== get what weekday the first is on ==*/
    $tmpd = getdate(mktime(0,0,0,$m,1,$y));
    $month = $tmpd["month"]; 
    $firstwday= $tmpd["wday"];

    $lastday = mk_getLastDayofMonth($m,$y);

?>
<table cellpadding="2" cellspacing="0" >
<tr><td colspan="7">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr><th width="20" style="display:none;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?m=<?=(($m-1)<1) ? 12 : $m-1 ?>&y=<?=(($m-1)<1) ? $y-1 : $y ?>">&lt;&lt;</a></th>
    <th style="display:none;"><font size=2><?="$month $y"?></font></th>
    <th width="20" style="display:none;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?m=<?=(($m+1)>12) ? 1 : $m+1 ?>&y=<?=(($m+1)>12) ? $y+1 : $y ?>">&gt;&gt;</a></th>
    </tr></table>
</td></tr>

<tr><th width=22 class="tcell">M</th>
	<th width=22 class="tcell">S</th>
    <th width=22 class="tcell">Sel </th>
	<th width=22 class="tcell">R</th>
    <th width=22 class="tcell">K</th>
	<th width=22 class="tcell">J</th>
    <th width=22 class="tcell">Sab</th></tr>

<?php $d = 1;
    $wday = $firstwday;
    $firstweek = true;

    /*== loop through all the days of the month ==*/
    while ( $d <= $lastday) 
    {

        /*== set up blank days for first week ==*/
        if ($firstweek) {
            echo "<tr>";
            for ($i=1; $i<=$firstwday; $i++) 
            { echo "<td><font size=2>&nbsp;</font></td>"; }
            $firstweek = false;
        }

        /*== Sunday start week with <tr> ==*/
        if ($wday==0) { echo "<tr>"; }

        /*== check for event ==*/  
        echo "<td class='tcell'>";
		// kalo mau pake event pake yng ini :  echo "<a href=\"#\" onClick=\"document.f.eventdate.value='$m-$d-$y';\">$d</a>";
        echo "$d";
        echo "</td>\n";

        /*== Saturday end week with </tr> ==*/
        if ($wday==6) { echo "</tr>\n"; }

        $wday++;
        $wday = $wday % 7;
        $d++;
    }
?>

</tr></table>

<?php
/*== end drawCalendar function ==*/
} 




/*== get the last day of the month ==*/
function mk_getLastDayofMonth($mon,$year)
{
    for ($tday=28; $tday <= 31; $tday++) 
    {
        $tdate = getdate(mktime(0,0,0,$mon,$tday,$year));
        if ($tdate["mon"] != $mon) 
        { break; }

    }
    $tday--;

    return $tday;
}

?>
