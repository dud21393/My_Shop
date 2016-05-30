<?php

function boardCTL($action)
{
    include_once "../Mod/boardModel.php";
    include_once "../Mod/Model.php";
    switch($action)
    {
        case 600:
            $action = 610;
            header("location:./MainCTL.php?action=$action");
            break;
        case 610: //게시판 리스트 뽑는 부분
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
            reply_count($select_result);
            header("location:../View/MainView.php?action=$action&serch={$board_serch['serch']}&all={$board_serch['all']}");
            break;
        case 611:
            $bnum= isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            header("location:../View/MainView.php?action=$action&bnum=$bnum");
            break;
        case 612: // insert함수 사용하여 게시글 넣기
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

                if($Fileinfo['name'][0]!="") {
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
                $action=610;
                header("location:./MainCTL.php?action=$action");
            }else
            {
                $action=17;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        case 613://하나의 게시글 보기
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
        case 614://수정하기 위한 뷰 보기
            $board_view['bnum'] = isset($_REQUEST['bnum']) ? $_REQUEST['bnum'] : null;
            $result_view=board_view($board_view);
            $img_list=image_view($board_view['bnum']);
            $_SESSION['boardView']=$result_view;
            $_SESSION['img_list']=$img_list;
            header("location:../View/MainView.php?action=$action");
            break;
        case 615://수정완료요청
            $board_update['bnum'] = isset($_REQUEST['bnum']) ? $_REQUEST['bnum'] : null;
            $board_update['subject'] = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : null;
            $board_update['contents'] = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : null;
            $current_image=isset($_REQUEST['image'])?$_REQUEST['image']:null;

            $imageFile=$Fileinfo=isset($_FILES['reimage'])?$_FILES['reimage']:null;


            if($current_image)
            {
                board_image_delete($current_image);
                board_image_delete2($current_image);
            }

            $board_imgePath="../img/product/";

            if($imageFile) {
                for ($iCount = 0; $iCount < count($Fileinfo['name']); $iCount++) {
                    $num = img_insert($board_update['bnum']);
                    if ($Fileinfo['name'][$iCount] && $Fileinfo['error'][$iCount] == 0) {
                        $imgFileType = pathinfo($Fileinfo['name'][$iCount], PATHINFO_EXTENSION);

                        $saveFileName = $board_update['bnum'];
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
            $board_result=board_update($board_update);
            if($board_result)
            {
                $action=610;
                header("location:./MainCTL.php?action=$action");
            }else{
                $action=17;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        case 616://삭제 요청
            $board_delete['bnum'] = isset($_REQUEST['bnum'])? $_REQUEST['bnum'] : null;
            $image_delete= isset($_REQUEST['image'])?$_REQUEST['image']:null;

            $delete_result=board_delete($board_delete);
            board_image_delete($image_delete);
            if($delete_result)
            {
                $action=610;
                header("location:./MainCTL.php?action=$action");
            }else{
                $action=17;
                header("location:../View/MainView.php?action=$action");
            }
            break;

        case 617://댓글달기
            $reply_insert['bnum'] = isset($_REQUEST['bnum'])?$_REQUEST['bnum'] : null;
            $reply_insert['alias'] = isset($_REQUEST['alias'])?$_REQUEST['alias'] : null;
            $reply_insert['contents'] = isset($_REQUEST['contents'])?$_REQUEST['contents'] : null;

            $result=reply_insert($reply_insert);
            if($result)
            {
                header("location:../Ctl/MainCTL.php?action=618&bnum={$reply_insert['bnum']}");
            }else{
                echo "실패";
            }
            break;
        case 618: //댓글 리스트 뽑기
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
           header("location:../Ctl/MainCTL.php?action=613&bnum=$reply_bnum&renum=$renum&hit={$board_view['hit']}&page=$page");
            break;
        case 619: //댓글 수정 하기
            $reply_bnum=isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            $reply_modify['renum']=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
            $reply_modify['contents']=isset($_REQUEST['contents'])?$_REQUEST['contents']:null;
            $result=reply_modify($reply_modify);
            if($result) {
                header("location:../Ctl/MainCTL.php?action=618&bnum=$reply_bnum");
            }else{
                echo "실패";
            }
                break;
        case 620: //댓글 삭제하기
            $reply_bnum=isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            $reply_renum=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
            $result=reply_delete($reply_renum);
            if($result) {
                header("location:../Ctl/MainCTL.php?action=618&bnum=$reply_bnum");
            }else{
                echo "실패";
            }
            break;
        case 621:
            $bnum = isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
            $board_insert['id']=isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
            $board_insert['subject']=isset($_REQUEST['subject']) ? $_REQUEST['subject'] : null;
            $board_insert['contents']=isset($_REQUEST['contents']) ? $_REQUEST['contents'] : null;
            $board_insert['alias']=isset($_REQUEST['alias']) ? $_REQUEST['alias'] : null;

            $parent=$_SESSION['boardView'];


            $insert_result=insert_reply($parent,$board_insert);

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
                $action=610;
                header("location:./MainCTL.php?action=$action");
            }else
            {
                $action=17;
                header("location:../View/MainView.php?action=$action");
            }
            break;
        default:
            header("location:../View/MainView.php?action=$action");
            break;

    }
}