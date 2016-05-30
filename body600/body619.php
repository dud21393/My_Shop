<?php
$page=isset($_SESSION['page_info']) ? $_SESSION['page_info'] : 1;
$member_serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
$member_serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
?>
<html>
<head>
    <h2 align="center">회원정보</h2>
</head>
<body>
<table width="800" border="1" align="center">
    <tr align="center"><td>번호</td><td>아이디</td><td>패스워드</td><td>이름</td><td>전화번호</td><td>레벨</td><td>정보삭제</td></tr>
    <?php
    $pageNumParaName="";
    $row=$_SESSION['rows'];
    for($iCount=0; $iCount<count($row); $iCount++)
    {
        echo "<tr align='center'>";
        for($jCount=0; $jCount<6; $jCount++)
        {
            if($row[$iCount][$jCount] == $row[$iCount][1])
            {
                echo "<td><a href='../Ctl/MainCTL.php?action=612&id={$row[$iCount][$jCount]}'>".$row[$iCount][$jCount]."</td>";
            }else {
                echo "<td>" . $row[$iCount][$jCount] . "</td>";
            }
        }
        echo "<td align='center'><a href='../Ctl/MainCTL.php?action=615&num={$row[$iCount][0]}&page={$page['current_page']}'>삭제</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<?php
include "./page.php";
include "./serch.php";
$member_action = 611;
Master_pagenation($pageinfo,$member_action,$member_serch,$pageNumParaName);
?>
</body>
</html>
