<?php

$Menu = array("T-shirt","Pants","Hat","Shoose","Glove","Board","Order","Cart");
$Num = intval($action['action'] / 100) -1 ;
for($iCount=0; $iCount<count($Menu); $iCount++)
{
    $Menu_Num = ($iCount+1) * 100; //MainMenu Code create
        echo "<a href='../Ctl/MainCTL.php?action=$Menu_Num'>";
        echo "$Menu[$iCount]";
        echo "</a>";

}
?>