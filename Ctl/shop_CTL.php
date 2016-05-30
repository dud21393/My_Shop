<?php
function shop_CTL($action){
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    include_once "../Mod/shopModel.php";
    include_once "../Mod/Model.php";
    switch($action)
    {
        case 700: //결제 창으로 이동 액션
            if($id) {
                $page_num=isset($_REQUEST['page'])?$_REQUEST['page']:1;
                $count = buy_count($id);
                $page = 10;
                $block_page = 10;
                $page_list = pagenation($page_num, $count, $page, $block_page);
                $result = buy_select($id, $page_list, $page);
                $_SESSION['buypage_list'] = $page_list;
                $_SESSION['buy_list'] = $result;
            }
            $action=701;
            header("location:../View/MainView.php?action=$action");
            break;
        case 702: //주문취소 액션
            $delete_buy['bynum']=isset($_REQUEST['buynum'])?$_REQUEST['buynum']:null;
            $delete_buy['bystock']=isset($_REQUEST['bystock'])?$_REQUEST['bystock']:null;
            $delete_buy['pnum']=isset($_REQUEST['pnum'])?$_REQUEST['pnum']:null;
            buy_delete($delete_buy);

            header("location:../Ctl/MainCTL.php?action=700");
            break;
        case 703: //결제액션
            $buy=isset($_REQUEST['bynum'])?$_REQUEST['bynum']:null;
            $result=buy_view($buy);
            $_SESSION['buyView_list']=$result;
            header("location:../View/MainView.php?action=$action");

            break;
        case 704: //결제 완료 액션
            $buy_action['name']=isset($_REQUEST['name'])?$_REQUEST['name']:null;
            $buy_action['home']=isset($_REQUEST['home'])?$_REQUEST['home']:null;
            $buy_action['phone']=isset($_REQUEST['phone'])?$_REQUEST['phone']:null;
            $buy_action['money']=isset($_REQUEST['money'])?$_REQUEST['money']:null;
            var_dump($buy_action);

            $buyView_list=$_SESSION['buyView_list'];
            buy_success($buy_action,$buyView_list);

            header("location:../Ctl/MainCTL.php?action=700");
            break;
        case 705:
            $bynum=isset($_REQUEST['bynum'])?$_REQUEST['bynum']:null;
            $result=buy_clear($bynum);
            var_dump($result);
            sales($result);
            header("location:../Ctl/MainCTL.php?action=700");
            break;
        case 800:
            $result=shop_select($id);
            $_SESSION['basket_list']=$result;
            header("location:../View/MainView.php?action=$action");
            break;
        case 801:
            $view_result=isset($_SESSION['view_result'])?$_SESSION['view_result']:null;
            $stock_count=isset($_REQUEST['number'])?$_REQUEST['number']:null;
            $user_id    =isset($_REQUEST['id'])?$_REQUEST['id']:null;
            insert_basket($view_result,$stock_count,$user_id);
            header("location:../View/MainView.php?action=1031");
            break;
        case 802:
            $bnum=isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            $result=shop_select2($bnum);
            $bynum=buy_insert($result);
            product_update($bynum);
            header("location:../Ctl/MainCTL.php?action=700");
            break;
        case 803:
            $view_result=$_SESSION['view_result'];
            $id=$_SESSION['id'];
            $result=buy_insert2($view_result,$id);
            header("location:../Ctl/MainCTL.php?action=700&pstock={$result['pstock']}&pcode={$result['pcode']}");
            break;
    }
}

?>