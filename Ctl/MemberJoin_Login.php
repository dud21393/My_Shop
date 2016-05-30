<?php
function loginCTL($action)
{
    switch($action)
    {
        case 10:
            $action = 11;
            header("location:./MainCTL.php?action=$action");
            break;
        case 11 : // 로그인 하기 위한 번호
            $login_info['id']   =isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
            $login_info['passwd']   =isset($_REQUEST['id']) ? $_REQUEST['passwd'] : null;
            include "../Mod/Model.php";
            $result=Login_info($login_info);
            echo $result['value'];
            if($result['value'] == 1)
            {
                $_SESSION['id'] = $result['id'];
                $_SESSION['alias'] = $result['alias'];
                $_SESSION['level'] = $result['level'];
                if($result['level']>=999) {
                    $action = 1011;
                }
                else{
                    $action=100;
                }
                echo $action;
                header("location:../Ctl/MainCTL.php?action=$action");
            }
            elseif($result['value'] == -1)
            {
                $action = 16;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        case 12 : //  로그아웃 == 로그인하기위해 들어있던 세션값들을 없애는 작업
            unset($_SESSION['id']);
            unset($_SESSION['alias']);
            unset($_SESSION['level']);
            $action=100;
            header("location:../Ctl/MainCTL.php?action=$action");
            break;
        case 13:
            header("location:../View/MainView.php?action=13");
            break;
        case 14 : //회원가입 처리액션
            $member_join['id']        = isset($_REQUEST['id']) ? $_REQUEST['id'] :null;
            $member_join['passwd']   = isset($_REQUEST['passwd']) ? $_REQUEST['passwd'] :null;
            $member_join['name']     = isset($_REQUEST['name']) ? $_REQUEST['name'] :null;
            $member_join['tel']      = isset($_REQUEST['tel']) ? $_REQUEST['tel'] :null;
            $member_join['alias']      = isset($_REQUEST['alias']) ? $_REQUEST['alias'] :null;
            include "../Mod/Model.php";
            $result=member_Join($member_join);
            if($result == true)
            { //회원가입에 성공하였을 경우!!
                header("location:../View/MainView.php?action=15");
            }
            else
            { //회원가입에 실패하였을 경우!1
                header("location:../View/MainView.php?action=17");
            }
            break;
        case 15:
            break;
        default : header("location:../View/MainView.php?action=$action");
            break;
    }
}