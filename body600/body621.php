<h1 align="center">상품관리</h1>
<form action="../Ctl/MainCTL.php?action=622" method="post" style="text-align: right; padding-right: 26%">
<input type="submit" value="상품입력">
</form>
<table border="1" align="center">
    <tr><td>번호</td><td>카테고리</td><td>상품코드</td><td>상품이름</td><td>재고량</td><td>가격</td><td>큰이미지</td><td>작은이미지</td><td>삭제</td></tr>
    <?php
    $product_Listinfo = isset($_SESSION['rows']) ? $_SESSION['rows'] : null;
    $product_pageinfo = isset($_SESSION['productpage_info']) ? $_SESSION['productpage_info'] : null;
    $product_serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
    $product_serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
    $pageNumParaName = "";
        if($product_Listinfo) {
            for ($iCount = 0; $iCount < count($product_Listinfo); $iCount++) {
                echo "<tr>";
                for ($jCount = 0; $jCount < 8; $jCount++) {
                    echo "<td>" . $product_Listinfo[$iCount][$jCount] . "</td>";
                }
                echo "<td><a href='../Ctl/MainCTL.php?action=626&page={$product_pageinfo['current_page']}&product_num={$product_Listinfo[$iCount][0]}'>삭제</a></td>";
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan='9'> 저장된 데이터 값이 없습니다.</td></tr>";
        }
    ?>
</table>
<?php
if($product_Listinfo) {
    include "./page.php";
    $product_action = 620;
    Master_pagenation($product_pageinfo, $product_action, $product_serch, $pageNumParaName);
}
    ?>