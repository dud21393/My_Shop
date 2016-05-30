<?php
$admin_buy=isset($_SESSION['admin_buy'])?$_SESSION['admin_buy']:null;
$pageinfo =isset($_SESSION['pageinfo'])?$_SESSION['pageinfo']:null;
$product_serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
$product_serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
$pageNumParaName="";
if($admin_buy)
{?>
    <h1 align="center">구매신청여부</h1>
    <table border="1" align="center" style="text-align: center; margin-bottom: 30px">
        <tr>
            <td>번호</td><td>상품이미지</td><td>상품이름</td><td>카테고리</td><td>상품코드</td><td>주문수량</td><td>주문금액</td><td>유저아이디</td><td>입금여부</td><td>주문날짜</td><td>주문상태</td>
        </tr>
        <?php for($iCount=0; $iCount<count($admin_buy); $iCount++){ ?>
        <tr>
            <td><?=$admin_buy[$iCount]['bynum']?></td>
            <td><img src="../img/product_S/<?=$admin_buy[$iCount]['psimage']?>" style="width: 150px; height: 150px; margin-bottom:3px;margin-top: 3px"></td>
            <td><?=$admin_buy[$iCount]['pname']?></td>
            <td><?=$admin_buy[$iCount]['pcategory']?></td>
            <td><?=$admin_buy[$iCount]['pcode']?></td>
            <td><?=$admin_buy[$iCount]['bystock']?></td>
            <td><?=$admin_buy[$iCount]['bymoney']?></td>
            <td><?=$admin_buy[$iCount]['byuser_id']?></td>
            <td><?=$admin_buy[$iCount]['deposit']?></td>
            <td><?=$admin_buy[$iCount]['date']?></td>
            <?php if($admin_buy[$iCount]['deposit'] == 'no')
            {
                echo "<td><a href='../Ctl/MainCTL.php'>주문취소</a></td>";
            }else{
                echo "<td>주문완료</td>";
            }?>
        </tr>
        <?php } ?>
    </table>
<?php
}else{
    echo "목록이 비어있습니다.";
}
?>

<?php
if($pageinfo) {
    include_once "./page.php";
    $action = $action['action'];
    Master_pagenation($pageinfo, $action, $product_serch, $pageNumParaName);
}
?>

