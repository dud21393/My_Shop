<?php
function Admin_CTL($action)
{
    include_once "../Mod/Model.php";
    include_once "../Mod/shopModel.php";
    include_once "../Mod/boardModel.php";
    switch($action)
    {
        case 1010 :
            $action=1011;
            header("location:./MainCTL.php?action=$action");
            break;
        case 1011 : //회원테이블 뽑는 부분 ..
            ////검색
            $member_serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
            $member_serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
            ////////////
            $page=10;
            $block_page=10;
            if($member_serch['serch'] == null || $member_serch['all'] == "") {
                $page_num['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                $count = member_Page_Count();
                $pageinfo = pagenation($page_num['page'], $count,$page,$block_page);
                $result = member_select($pageinfo,$page);
            }else{
                $member_serch['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
                $serch_page_count=serch_Page_Count($member_serch);
                $pageinfo=pagenation($member_serch['page'],$serch_page_count,$page,$block_page);
                $result=serch_select($member_serch,$pageinfo,$page);
            }
            $_SESSION['rows']=$result;
            $_SESSION['page_info']=$pageinfo;
            $action=1019;
            header("location:../View/MainView.php?action=$action&serch={$member_serch['serch']}&all={$member_serch['all']}");
            break;
        case 1012 : // 수정하는 부분
            $id=isset($_REQUEST['id']) ? $_REQUEST['id'] : null ;
            $result=member_modify_select($id);
            $_SESSION['modify'] = $result;
            $action=1013;
            header("location:../View/MainView.php?action=$action");
            break;
        case 1014 : //수정할수 있게 값 받아오는 부분
            $member_modify['id']        = isset($_REQUEST['id']) ? $_REQUEST['id'] :null;
            $member_modify['passwd']   = isset($_REQUEST['passwd']) ? $_REQUEST['passwd'] :null;
            $member_modify['name']     = isset($_REQUEST['name']) ? $_REQUEST['name'] :null;
            $member_modify['tel']      = isset($_REQUEST['tel']) ? $_REQUEST['tel'] :null;
            $member_modify['level']     = isset($_REQUEST['level']) ? $_REQUEST['level'] : 1;
            $member_modify['page']     = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $m_result=member_modify($member_modify);
            if(!$m_result) {
                $action = 1017;
                header("location:../View/MainView.php?action=$action&page={$member_modify['page']}");
            }
            else{
                $action = 1011;
                header("location:../Ctl/MainCTL.php?action=$action&page={$member_modify['page']}");
            }
            break;
        case 1015 : //회원 삭제할수 있게 하는 부분
            $member_delite_num= isset($_REQUEST['num']) ? $_REQUEST['num'] : null;
            $member_delite_page=isset($_REQUEST['page']) ? $_REQUEST['page'] : null;
            $d_result=member_delete($member_delite_num);
            if(!$d_result) {
                $action = 117;
                header("location:../View/MainView.php?action=$action");
            }else{
                $action = 1011;
                echo $member_delite_page;
                header("location:../Ctl/MainCTL.php?action=$action&page={$member_delite_page['page']}");
            }
            break;
        case 1020://제품 리스트 뽑는곳!!!
            $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $page_count=product_Page_Count();
            $page=10;
            $block_page=10;
            $product_pageinfo=pagenation($page_num,$page_count,$page,$block_page);
            $result=AdminProduct_select($product_pageinfo,$page);
            $_SESSION['productpage_info']=$product_pageinfo;
            $_SESSION['rows']=$result;
            $action=1021;
            header("location:../View/MainView.php?action=$action");
            break;
        case 1022:
            $action=1023;
            header("location:../View/MainView.php?action=$action");
            break;
        case 1024://삼품정보 입력 액션
            $product_imgePath="../img/product/";
            $product_simgePath="../img/product_S/";
            $simageHieght = 150;

            $product_insert['pcategory'] = isset($_REQUEST['pcategory']) ? $_REQUEST['pcategory'] : null;
            $product_insert['pcode'] = $product_insert['pcategory'];
            $product_insert['pname'] = isset($_REQUEST['pname']) ? $_REQUEST['pname'] : null;
            $product_insert['pstock'] = isset($_REQUEST['pstock']) ? $_REQUEST['pstock'] : null;
            $product_insert['pprice'] = isset($_REQUEST['pprice']) ? $_REQUEST['pprice'] : null;
            $product_insert['pfimage'] = isset($_REQUEST['pfimage']) ? $_REQUEST['pfimage'] : null;
            $product_insert['psimage'] = isset($_REQUEST['psimage']) ? $_REQUEST['psimage'] : null;

            $result=product_insert($product_insert);

            if(!$result['query'])
            {
                $action = 1025;
                header("location:../View/MainView.php?action=$action");
            }
            else{
                $pnum=$result['pnum'];

                $Fileinfo['name'] = isset($_FILES['pfimage']['name'])?$_FILES['pfimage']['name']:null;
                $Fileinfo['tmp_name'] = isset($_FILES['pfimage']['tmp_name'])?$_FILES['pfimage']['tmp_name']:null;
                $Fileinfo['type'] = isset($_FILES['pfimage']['type'])?$_FILES['pfimage']['type']:null;
                $Fileinfo['size'] = isset($_FILES['pfimage']['size'])?$_FILES['pfimage']['size']:null;
                $Fileinfo['error'] = isset($_FILES['pfimage']['error'])?$_FILES['pfimage']['error']:null;

                if($Fileinfo['name'] && $Fileinfo['error'] == 0) {
                    //업로드 실행
                    $imgFileType = pathinfo($Fileinfo['name'], PATHINFO_EXTENSION); // 이미지 확장자 추출

                    $saveFileName = $product_insert['pfimage'] . $pnum;
                    $saveFileWithExt = $saveFileName . "." . strval($imgFileType);
                    $thumbnailFileNameWithExt = $saveFileName . "_S" . "." . strval($imgFileType);

                    $img_result = FileUpload($Fileinfo, $product_imgePath, $saveFileWithExt);
                    if ($img_result['upload']) {
                        $product_insert['pfimage'] = $saveFileWithExt; // pfimage 값 설정 후

                        //이미지 파일이 jpg,png,gif면 썸네일 이미지 생성한다
                        if ($imgFileType == "jpg" || $imgFileType == "jpeg" || $imgFileType == "png" || $imgFileType == "jpeg") {
                            $src = $product_imgePath . $saveFileWithExt;
                            $dest = $product_simgePath . $thumbnailFileNameWithExt;
                            thumnailimage($src, $dest, $simageHieght, $imgFileType);

                            $product_insert['psimage'] = $thumbnailFileNameWithExt; // psimage값 설정
                        }
                    }
                }
                    //새롭게 pnum과 pcode 부분을 만든다..
                $product_insert['pnum'] = $pnum;
                $product_insert['pcode'] = $product_insert['pcategory'].$pnum;

                $update_result = update_product($product_insert);

                if($update_result)
                {
                    $action = 1020;
                    header("location:../Ctl/MainCTL.php?action=$action");
                }else
                {
                    $action = 1025;
                    header("location:../View/MainView.php?action=$action");
                }
            }
            break;
        case 1026://제품 삭제 부분
            $product_delete['num'] = isset($_REQUEST['product_num']) ? $_REQUEST['product_num'] : null;
            $product_delete['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $image['pfimage'] = isset($_REQUEST['pfimage']) ? $_REQUEST['pfimage'] : null;
            $image['psimage'] = isset($_REQUEST['psimage']) ? $_REQUEST['psimage'] : null;
            if(($image['pfimage'] || $image['psimage']) != null)
                image_delete($image);
            $delete_result=product_delete($product_delete['num']);

            if(!$delete_result)
            {
                $action=1025;
                header("location:../View/MainView.php?action=$action");
            }else {
                $action=1020;
                header("location:../Ctl/MainCTL.php?action=$action&page={$product_delete['page']}");
            }
            break;
        case 1027://제품 수정하기전 뷰 보여주는 부분
            $product_updateView['pnum']=isset($_REQUEST['pnum'])?$_REQUEST['pnum']:null;
            $update_result=select_view($product_updateView);
            if($update_result) {
                $_SESSION['updateInfo']=$update_result;
                header("location:../View/MainView.php?action=$action");
            }else{
                $action=1027;
                header("location:../View/MainView.php?action=$action");
            }
            break;

        case 1028: //제품 수정하는 부분 이미지새롭게 업로드 및 수정
            $product_update['pnum'] = isset($_REQUEST['pnum']) ? $_REQUEST['pnum'] : null;
            $product_update['pname'] = isset($_REQUEST['pname']) ? $_REQUEST['pname'] : null;
            $product_update['pstock'] = isset($_REQUEST['pstock'])?$_REQUEST['pstock'] : null;
            $product_update['pprice'] = isset($_REQUEST['pprice']) ? $_REQUEST['pprice'] : null;
            $product_image['pfimage'] = isset($_REQUEST['pfimage']) ? $_REQUEST['pfimage'] : null;
            $product_image['psimage'] = isset($_REQUEST['psimage']) ? $_REQUEST['psimage'] : null;

                $pnum = $product_update['pnum'];

                $product_imgePath = "../img/product/";
                $product_simgePath = "../img/product_S/";
                $simageHieght = 150;

                $Fileinfo['name'] = isset($_FILES['pfimage']['name']) ? $_FILES['pfimage']['name'] : null;
                $Fileinfo['tmp_name'] = isset($_FILES['pfimage']['tmp_name']) ? $_FILES['pfimage']['tmp_name'] : null;
                $Fileinfo['type'] = isset($_FILES['pfimage']['type']) ? $_FILES['pfimage']['type'] : null;
                $Fileinfo['size'] = isset($_FILES['pfimage']['size']) ? $_FILES['pfimage']['size'] : null;
                $Fileinfo['error'] = isset($_FILES['pfimage']['error']) ? $_FILES['pfimage']['error'] : null;

                if ($Fileinfo['name'] && $Fileinfo['error'] == 0) {

                    if (($product_image['pfimage'] || $product_image['psimage']) != null)
                        image_delete($product_image);
                    //업로드 실행
                    $imgFileType = pathinfo($Fileinfo['name'], PATHINFO_EXTENSION); // 이미지 확장자 추출

                    $saveFileName = $pnum;

                    $imageFullname = $saveFileName . "." . strval($imgFileType);
                    $thumbnailFullname = $saveFileName . "_S" . "." . strval($imgFileType);
                    $product_update['pfimage']=$imageFullname;
                    $product_update['psimage']=$thumbnailFullname;

                    $img_result = FileUpload($Fileinfo, $product_imgePath, $imageFullname);

                    if ($img_result['upload']) {
                        //이미지 파일이 jpg,png,gif면 썸네일 이미지 생성한다
                        if ($imgFileType == "jpg" || $imgFileType == "jpeg" || $imgFileType == "png" || $imgFileType == "jpeg") {
                            $src = $product_imgePath . $imageFullname;
                            $dest = $product_simgePath . $thumbnailFullname;
                            thumnailimage($src, $dest, $simageHieght, $imgFileType);
                        }
                    }
                    update_product2($product_update);
                    $action=1020;
                header("location:./MainCTL.php?action=$action");
            }else{
                $action=1025;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        case 1031:
            $product_View['pnum']=isset($_REQUEST['pnum'])?$_REQUEST['pnum']:null;
            $product_View['return']=isset($_REQUEST['return'])?$_REQUEST['return']:null;

            $view_result=select_view($product_View);
            if($view_result) {
                $_SESSION['view_result']=$view_result;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        case 1040://관리자 관리 게시판 리스트 뽑기
            $bpnum = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $board_serch['serch'] = isset($_REQUEST['serch'])?$_REQUEST['serch']:null;
            $board_serch['all']   = isset($_REQUEST['all'])?$_REQUEST['all']:null;

            $page=10;
            $block_page=10;

            if($board_serch['serch'] == null || $board_serch['all'] == "")
            {
                $count=board_select_Count();
                $bpageinfo = pagenation($bpnum, $count, $page, $block_page);
                $select_result = board_select($bpageinfo, $page);
            }else {
                $count=serch_board_Count($board_serch);
                $bpageinfo=pagenation($bpnum,$count,$page,$block_page);
                $select_result=serch_board_select($bpageinfo,$page,$board_serch);
            }
            $reply_list=select_reply();
            $_SESSION['reply_list'] = $reply_list;
            $_SESSION['boardList'] = $select_result;
            $_SESSION['boardpageInfo'] = $bpageinfo;
            header("location:../View/MainView.php?action=$action&serch={$board_serch['serch']}&all={$board_serch['all']}");
            break;
        case 1041: //댓글관리
            $reply_bnum= isset($_REQUEST['bnum']) ? $_REQUEST['bnum'] : null;
            $renum=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
            $board_view['hit']  = isset($_REQUEST['hit'])? $_REQUEST['hit'] : null;
            $page_num=isset($_REQUEST['reply_page'])?$_REQUEST['reply_page']:1;

            $page=10;
            $block_page=10;

            $count=reply_count($reply_bnum);
            $pageinfo=pagenation($page_num,$count,$page,$block_page);
            $result=reply_select($reply_bnum,$pageinfo,$page);

            $_SESSION['reply_pageinfo']=$pageinfo;
            $_SESSION['reply_list']=$result;

            header("location:../Ctl/MainCTL.php?action=1042&bnum=$reply_bnum&renum=$renum&hit={$board_view['hit']}&page=$page");
            break;
        case 1042: //하나의 뷰관리
            $board_view['bnum'] = isset($_REQUEST['bnum']) ? $_REQUEST['bnum'] : null;
            $board_view['hit']  = isset($_REQUEST['hit'])? $_REQUEST['hit'] : null;
            $page =isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $renum=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
            $result_view=board_view($board_view);
            $img_list=image_view($board_view['bnum']);
            $_SESSION['boardView']=$result_view;
            $_SESSION['img_list']=$img_list;
            header("location:../View/MainView.php?action=$action&renum=$renum&page=$page");
            break;
        case 1043: //댓글 삭제관리
            $reply_bnum=isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            $reply_renum=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
            $result=reply_delete($reply_renum);
            if($result) {
                header("location:../Ctl/MainCTL.php?action=1041&bnum=$reply_bnum");
            }else{
                echo "실패";
            }
            break;
        case 1044: //댓글수정하기
            $reply_bnum=isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            $reply_modify['renum']=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
            $reply_modify['contents']=isset($_REQUEST['contents'])?$_REQUEST['contents']:null;
            $result=reply_modify($reply_modify);
            if($result) {
                header("location:../Ctl/MainCTL.php?action=1041&bnum=$reply_bnum");
            }else{
                echo "실패";
            }
            break;
        case 1045: //게시판 글쓰기위한 뷰
            $bnum= isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            header("location:../View/MainView.php?action=$action&bnum=$bnum");
            break;
        case 1046: //게시판 삭제관리
            $board_delete['bnum'] = isset($_REQUEST['bnum'])? $_REQUEST['bnum'] : null;
            $image_delete= isset($_REQUEST['image'])?$_REQUEST['image']:null;

            board_delete($board_delete);
            board_image_delete($image_delete);

            $action=1040;
            header("location:./MainCTL.php?action=$action");
            break;
        case 1047: //관리자 게시물 쓰기
            $board_insert['id']=isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
            $board_insert['subject']=isset($_REQUEST['subject']) ? $_REQUEST['subject'] : null;
            $board_insert['contents']=isset($_REQUEST['contents']) ? $_REQUEST['contents'] : null;
            $board_insert['alias']=isset($_REQUEST['alias']) ? $_REQUEST['alias'] : null;

            $insert_result=board_insert($board_insert);

            if($insert_result['result'])
            {
                $board_imgePath="../img/product/";

                $bnum=$insert_result['bnum'];
                $Fileinfo=isset($_FILES['bimage'])?$_FILES['bimage']:null;

                if($Fileinfo[0]['name']!="") {
                    for ($iCount = 0; $iCount < count($Fileinfo['name']); $iCount++) {
                        $num = img_insert($bnum);
                        if ($Fileinfo['name'][$iCount] && $Fileinfo['error'][$iCount] == 0) {
                            $imgFileType = pathinfo($Fileinfo['name'][$iCount], PATHINFO_EXTENSION);

                            $saveFileName = $bnum;
                            $saveFileWithExt = $saveFileName . $num . "." . strval($imgFileType);


                            $barrel['tmp_name'] = $Fileinfo['tmp_name'][$iCount];
                            $img_result = FileUpload($barrel, $board_imgePath, $saveFileWithExt);
                            if ($img_result['upload']) {
                                $image_update['name'] = $saveFileWithExt;
                                $image_update['inum'] = $num;
                            }
                        }
                        image_update($image_update);
                    }
                }
                $action=1040;
                header("location:./MainCTL.php?action=$action");
            }else
            {
                $action=17;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        case 1048: // 댓글입력
            $reply_insert['bnum'] = isset($_REQUEST['bnum'])?$_REQUEST['bnum'] : null;
            $reply_insert['alias'] = isset($_REQUEST['alias'])?$_REQUEST['alias'] : null;
            $reply_insert['contents'] = isset($_REQUEST['contents'])?$_REQUEST['contents'] : null;

            $result=reply_insert($reply_insert);
            if($result)
            {
                header("location:../Ctl/MainCTL.php?action=1041&bnum={$reply_insert['bnum']}");
            }else{
                echo "실패";
            }
            break;
        case 1050:
            $page_num=isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $count=adminbuy_count();
            $page=10;
            $block_page=10;
            $pageinfo=pagenation($page_num,$count,$page,$block_page);
            $adminbuy=adminbuy($pageinfo,$page);

            $_SESSION['pageinfo']=$pageinfo;
            $_SESSION['admin_buy']=$adminbuy;
            header("location:../View/MainView.php?action=$action");
            break;
        case 1060://배송관리 테이블
            $page_num=isset($_REQUEST['page'])?$_REQUEST['page']:1;
            $page=10;
            $block_page=10;
            $admin_count=admin_count();
            $admin_pagelist=pagenation($page_num,$admin_count,$page,$block_page);
            $result=selectadmin($admin_pagelist,$page);

            $_SESSION['admin_pagelist']=$admin_pagelist;
            $_SESSION['admin_list']=$result;
            header("location:../View/MainView.php?action=$action");
            break;
        case 1061: //배송중
            $bynum=isset($_REQUEST['bynum'])?$_REQUEST['bynum']:null;
            delivery_update($bynum);
            header("location:../Ctl/MainCTL.php?action=1060");
            break;
        case 1062: //배송완료
            $bynum=isset($_REQUEST['bynum'])?$_REQUEST['bynum']:null;
            delivery_update2($bynum);
            header("location:../Ctl/MainCTL.php?action=1060");
            break;
        case 1070://매출관리
            $page_num=isset($_REQUEST['page'])?$_REQUEST['page']:1;

            $count=sales_count();
            $page=10;
            $block_page=10;
            $sales_pagelist=pagenation($page_num,$count,$page,$block_page);
            $sales_list=sales_list($sales_pagelist,$page);
            $money=Sum_sales_list();
            $_SESSION['money']=$money[0];
            $_SESSION['sales_list']=$sales_list;
            $_SESSION['sales_pagelist']=$sales_pagelist;
            header("location:../View/MainView.php?action=$action");
            break;
        default :
            header("location:../View/MainView.php?action=$action");
            break;
    }
}

?>