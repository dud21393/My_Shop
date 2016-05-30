<?php
$page_list=isset($_SESSION['sales_pagelist'])?$_SESSION['sales_pagelist']:null;
$sales_list=isset($_SESSION['sales_list'])?$_SESSION['sales_list']:null;
$sales_money=isset($_SESSION['money'])?$_SESSION['money']:null;
?>
<h1 style="text-align: center">매출관리</h1>
<div align="right" style="margin-right: 20px">
<h2>총매출 : <?=$sales_money?></h2>
</div>
<table border="1" align="center" style="margin-bottom: 30px">
    <tr>
        <td>번호</td><td>이미지</td><td>상품이름</td><td>갯수</td><td>가격</td>
    </tr>
    <?php
    for($iCount=0; $iCount<count($sales_list); $iCount++)
    {
        echo "<tr align='center'>";
        echo "<td width='50'>".$sales_list[$iCount]['snum']."</td>";
        echo "<td><img src='../img/product_S/{$sales_list[$iCount]['psimage']}' style=\"width: 150px; height: 150px; margin-bottom:3px;margin-top: 3px></td>";
        echo "<td width='150px'>".$sales_list[$iCount]['pname']."</td>";
        echo "<td width='100px'>".$sales_list[$iCount]['sstock']."</td>";
        echo "<td width='100px'>".$sales_list[$iCount]['smoney']."</td>";
        echo "<tr>";
    }
    $total=0;
    for($iCount=0; $iCount<count($sales_list); $iCount++)
    {
        $total+=$sales_list[$iCount]['smoney'];
    }
    ?>
</table>

<?php
if($page_list)
{
    $serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
    $serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
    $pageNumParaName="";
    include_once "page.php";
    $action=$action['action'];
    Master_pagenation($page_list,$action,$serch,$pageNumParaName);
}
?>
