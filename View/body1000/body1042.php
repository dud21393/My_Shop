<?php
$renum=isset($_REQUEST['renum'])?$_REQUEST['renum']:null;
$boardView=isset($_SESSION['boardView'])?$_SESSION['boardView']:null;
$reply_list = isset($_SESSION['reply_list'])?$_SESSION['reply_list'] : null;
$reply_pageinfo=isset($_SESSION['reply_pageinfo'])?$_SESSION['reply_pageinfo']:null;
$image_list = isset($_SESSION['img_list'])?$_SESSION['img_list']:null;
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
$Image_path="../img/product/";
?>
    <form style="text-align: center;">
        <h1><?=$boardView[6]?>님의 글</h1>
        <table width="1000px" border="1" align="center">
            <tr height="10"><td width="100">글번호</td><td><?=$boardView[0]?></td></tr>
            <tr height="20"><td>글쓴이</td><td><?=$boardView[6]?></td></tr>
            <tr height="20"><td>조회수</td><td><?=$boardView[4]?></td></tr>
            <tr height="100"><td>제목</td><td><?=$boardView[2]?></td></tr>
            <tr height="500">
                <td>내용</td><td>
                    <?php
                    if($image_list) {
                        for ($iCount = 0; $iCount < count($image_list); $iCount++) {
                            echo "<div>";
                            echo "<img src='$Image_path{$image_list[$iCount][2]}'>";
                            echo "</div>";
                        }
                    }
                    ?>
                    <?=$boardView[3]?>
                </td>
            </tr>
        </table>
    </form>
    <div style="width: 1100px">
        <form action="../Ctl/MainCTL.php?action=1040&bnum=<?=$boardView[0]?>&page=<?=$page?>" style="float: left; margin-left: 100px" method="post">
            <input type="submit" value="돌아가기">
        </form>
        <form action="../Ctl/MainCTL.php?action=1045&bnum=<?=$boardView[0]?>" style="margin-left: 20px; float: left" method="post">
            <input type="submit" value="답글달기">
        </form>

        <form action="../Ctl/MainCTL.php?action=1046&bnum=<?=$boardView[0]?>" style="float: right" method="post">
            <?php

            for($iCount=0; $iCount<count($image_list); $iCount++)
            {
                echo "<input type='hidden' value='{$image_list[$iCount][2]}' name='image[]'>";
            }
            ?>
            <input type="submit" value="삭제">
        </form>
    </div>
<?php
include "./reply.php";
$re_action=1048;
if($id) {
    reply($re_action, $boardView[0], $alias);
}
if($reply_list)
{
    include_once "./page.php";
    for($iCount=0; $iCount<count($reply_list); $iCount++)
    {
        echo "<div style='margin-left: 100px; margin-bottom: 10px; width: 1000px'>";
        echo "<div>";
        echo $reply_list[$iCount][2]."&nbsp&nbsp";
        echo $reply_list[$iCount][4];
        echo "</div>";
        if($reply_list[$iCount][1] != $renum) {
            echo $reply_list[$iCount][3];
            echo "<form action=../Ctl/MainCTL.php?action=1043&bnum={$reply_list[$iCount][0]}&renum={$reply_list[$iCount][1]} style='float:right' method='post'>";
            echo "<input type=submit value='삭제' >";
            echo "</form>";
            if ($alias == $reply_list[$iCount][2]) {
                echo "<form action=../Ctl/MainCTL.php?action=1041&bnum={$reply_list[$iCount][0]}&renum={$reply_list[$iCount][1]} style='float: right' method='post'>";
                echo "<input type=submit value='수정' >";
                echo "</form>";
            }
        }else{
    echo "<form action=../Ctl/MainCTL.php?action=1044&bnum={$reply_list[$iCount][0]}&renum={$reply_list[$iCount][1]} method='post'>";
    echo "<textarea name='contents' style='width: 900px; resize: none'>{$reply_list[$iCount][3]}</textarea>";
    echo "<input type=submit value='완료' >";
    echo "</form>";
}
        echo "</div>";
    }
    echo "</div>";
    $action=1041;
    $serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
    $serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
    $pageNumParaName="";
    sub_pagenation($reply_pageinfo,$action,$serch,$pageNumParaName,$boardView[0]);
}
?>