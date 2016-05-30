<?php
$boardList=isset($_SESSION['boardList'])?$_SESSION['boardList'] : null;
$boardpageInfo=isset($_SESSION['boardpageInfo'])?$_SESSION['boardpageInfo']:null;
$pageNumParaName="";
$board_serch['serch']=isset($_REQUEST['serch'])?$_REQUEST['serch']:null;
$board_serch['all']=isset($_REQUEST['all'])?$_REQUEST['all']:null;
$reply_list   =isset($_SESSION['reply_list'])?$_SESSION['reply_list']:null;

?>

    <h1 style="text-align: center">게시판관리</h1>
    <table border="1" width="800px" align="center">
        <tr align="center">
            <td>글번호</td>
            <td>닉네임</td>
            <td>제목</td>
            <td colspan="2">날짜</td>
            <td>조회수</td>
        </tr>
        <?php
        if($boardList) {
            for ($iCount = 0; $iCount < count($boardList); $iCount++) {
                echo "<tr>";
                echo "<td width='80' align='center'>" . $boardList[$iCount][0] . "</td>"; //글번호
                echo "<td align='center'>" . $boardList[$iCount][6] . "</td>"; //닉네임
                ?>
                <td><a href='../Ctl/MainCTL.php?action=1041&bnum=<?=$boardList[$iCount][0]?>&hit=true&page=<?=$boardpageInfo['current_page']?>'>
                        <?php
                        for($jCount=0; $jCount<$boardList[$iCount][8]; $jCount++)
                        {
                            echo "&nbsp&nbsp";
                        }
                        $temp=mb_strlen("{$boardList[$iCount][2]}","utf-8");
                        if($temp<20) {
                            echo $boardList[$iCount][2];
                        }else{
                            echo substr($boardList[$iCount][2],0,18)."...";
                        }
                        for($zCount=0; $zCount<count($reply_list); $zCount++) {
                            if ($reply_list[$zCount]['bnum'] == $boardList[$iCount][0])
                            {
                                echo "&nbsp&nbsp[".$reply_list[$zCount]['num']."]";
                            }
                        }
                        ?>
                </td>
                <?php
                echo "<td colspan='2' align='center'>" . $boardList[$iCount][5] . "</td>"; //날짜
                echo "<td align='center'>" . $boardList[$iCount][4] . "</td>"; //조회수
                echo "</tr>";
            }
        }else{
            echo "<td colspan='6'> 데이터가 없습니다.</td>";
        }
        ?>
    </table>

<?php
if($id) {
    echo "<form style='text-align: right; width: 950px'>";
    echo "<a href='../Ctl/MainCTL.php?action=1045'>글쓰기</a>";
    echo "</form>";
}
if($boardList)
{
    include "./page.php";
    include "./serch.php";
    $master_action=$action['action'];
    Master_pagenation($boardpageInfo,$master_action,$board_serch,$pageNumParaName);
    Board_serch($master_action);
}

?>

