<?php
session_start();
include "../Mod/myDB.php";
$action['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : 100 ;
$num = intval($action['action'] / 100);

/*
 *
 */
switch($num)
{
    case 0 :
        include_once "MemberJoin_Login.php"; // 만약 action값이 1보다 작을 때 로그인,로그아웃
        loginCTL($action['action']);           //  회원가입 등등 .. 유저를 위한 컨트롤러
        break;
    case 1 :
    case 2 :
    case 3 :
    case 4 :
    case 5 :
        include_once "Product_CTL.php";      //상품을 보여주기위해 상품들을 리스트 등등 하기위해
        product($action['action']);            //유저를 위한 컨트롤러
        break;                                 //1~5 까지 전부 Product_CTL로 가서
        //하나의 함수로 들어간다!!

    case 6 :
        include_once "boardCTL.php";
        boardCTL($action['action']);
        break;

    case 7:
    case 8:
        include_once "shop_CTL.php";
        shop_CTL($action['action']);
        break;

    case 10 : include_once "Admin_CTL.php";
            Admin_CTL($action['action']);
        break;
    default :header("location:../View/MainView.php?action={$action['action']}");
        break;
}

?>