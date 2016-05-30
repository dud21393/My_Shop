
<h1 style="text-align: center">배송관리</h1>
<?php
$admin_list=isset($_SESSION['admin_list'])?$_SESSION['admin_list']:null;
$pagelist=isset($_SESSION['admin_pagelist'])?$_SESSION['admin_pagelist']:null;
if($admin_list) {
    ?>
    <table border="1" align="center" style="text-align: center;margin-bottom: 30px">
        <tr>
            <td>번호</td>
            <td>상품이미지</td>
            <td>상품이름</td>
            <td>카테고리</td>
            <td>상품코드</td>
            <td>유저아이디</td>
            <td>받는사람</td>
            <td>주소지</td>
            <td>휴대폰번호</td>
            <td>구매번호</td>
            <td>배송여부</td>
        </tr>
        <?php for($iCount=0; $iCount<count($admin_list); $iCount++){ ?>
        <tr>
            <td><?=$admin_list[$iCount]['anum']?></td>
            <td><img src="../img/product_S/<?=$admin_list[$iCount]['psimage']?>" style="width: 150px; height: 150px; margin-bottom:3px;margin-top: 3px"></td>
            <td><?=$admin_list[$iCount]['pname']?></td>
            <td><?=$admin_list[$iCount]['pcategory']?></td>
            <td><?=$admin_list[$iCount]['pcode']?></td>
            <td><?=$admin_list[$iCount]['byuser_id']?></td>
            <td><?=$admin_list[$iCount]['name']?></td>
            <td><?=$admin_list[$iCount]['home']?></td>
            <td><?=$admin_list[$iCount]['phone']?></td>
            <td><?=$admin_list[$iCount]['bynum']?></td>
            <td>
                <?php if($admin_list[$iCount]['bydelivery'] == '배송준비') { ?>
                <a href="../Ctl/MainCTL.php?action=1061&&bynum=<?=$admin_list[$iCount]['bynum']?>"><?=$admin_list[$iCount]['bydelivery']?></a>
                <?php }elseif($admin_list[$iCount]['bydelivery'] == '배송중'){ ?>
                   <a href="../Ctl/MainCTL.php?action=1062&bynum=<?=$admin_list[$iCount]['bynum']?>"><?=$admin_list[$iCount]['bydelivery']?></a>
               <?php  }elseif($admin_list[$iCount]['bydelivery'] == '배송완료'){ ?>
                    <?=$admin_list[$iCount]['bydelivery']?>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php
}else{
    echo "목록이 비어있습니다.";
}
?>
<?php
if($pagelist)
{
    include "page.php";
    $action=$action['action'];
    $pageNumParaName="";
    $serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
    $serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;

    Master_pagenation($pagelist,$action,$serch,$pageNumParaName);


}
?>

