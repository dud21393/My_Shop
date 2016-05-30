<?php

$Num=intval($action['action'] / 100);
$Body_Num = $Num * 100;


if($Body_Num == 0)
{
    include "./body10/body".$Body_Num.".php";
}
if($Body_Num >= 100 && $Body_Num <600)
{
    $Body_Num=200;
    include "./body200/body".$Body_Num.".php";
}elseif($Body_Num == 600 )
{
    include "./body600/body".$Body_Num.".php";
}
elseif($Body_Num == 700 )
{
    include "./body700/body".$Body_Num.".php";
}elseif($Body_Num == 800)
{
    include "./body800/body".$Body_Num.".php";
}
elseif($Body_Num == 1000)
{
    include "./body".$Body_Num."/body".$Body_Num.".php";
}
?>