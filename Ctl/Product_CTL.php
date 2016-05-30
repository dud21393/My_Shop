<?php
function product($action)
{
    include_once "../Mod/Model.php";

    $product_Category=array(
        array("C1","C2","C3"),
        array("B1","B2","B3"),
        array("H1","H2"),
        array("S1","S2"),
        array("G1","G2","G3")
    );
    $product_pageANDblock=array(
        array(8,5),
        array(8,5),
        array(8,5),
        array(8,5),
        array(8,5)
    );
    $action_MenuNum=floor($action/100) -1 ; //액션에 따른 메뉴 인덱스 계산
    $action_SubMenuNum=floor($action/10) % 10 -1; // 액션코드에 따른 서브메뉴 인덱스 계산

    $pageParaName="ppageNum".strval($action); //ppageNum110
    $pageinfoName="productPageinfo".strval($action); // productPageInfo110

    $pageinfo = isset($_SESSION[$pageinfoName]) ? $_SESSION[$pageinfoName] : null;

    if($action %100 !=0)
    {
        $pcategory = $product_Category[$action_MenuNum][$action_SubMenuNum];
    }else{
        $pcategory = "%".substr($product_Category[$action_MenuNum][0],0,1)."%";
    }

    if(! $pageinfo ) {
        $ppage_num = isset($_REQUEST[$pageParaName]) ? $_REQUEST[$pageParaName] : 1;
    }
    else {
        $ppage_num = isset($_REQUEST[$pageParaName]) ? $_REQUEST[$pageParaName] : $pageinfo['current_page'];
    }

    $count=pcategory_count($pcategory);
    $pageinfo=pagenation($ppage_num,$count,$product_pageANDblock[$action_MenuNum][0],$product_pageANDblock[$action_MenuNum][1]);
    $result=product_select($pageinfo,$pcategory,$product_pageANDblock[$action_MenuNum][0]);

    $_SESSION['product_List']=$result;
    $_SESSION[$pageinfoName]=$pageinfo;

   header("location:../View/MainView.php?action=$action");
}
?>















