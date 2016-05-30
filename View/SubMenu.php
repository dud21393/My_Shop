<?php

$main_Num = intval($action['action']/100) -1;
$sub_Num  = intval($action['action']%100);
$Body_Num = ($action['action']/100) * 100;

if($Body_Num>=100 && $Body_Num<600) {
    $Left_Menu = array(
        array("반팔", "긴팔", "니트"),
        array("5부바지", "팬츠", "스키니"),
        array("비니", "캡"),
        array("나이키", "아디다스"),
        array("털장갑", "가죽장갑", "반장갑")
    );
    if ($main_Num >= 0) {
        echo "<ul class='sub' style='display: none'>";
        for ($iCount = 0; $iCount < count($Left_Menu[$main_Num]); $iCount++) {
            $Left_Num = (($main_Num + 1) * 100) + (($iCount + 1) * 10);
            echo "<li><a href='../Ctl/MainCTL.php?action=$Left_Num'>";
            echo $Left_Menu[$main_Num][$iCount];
            echo "</a></li>";
        }
        echo "</ul>";
    }
}
?>
