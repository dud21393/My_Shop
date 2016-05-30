<?php
$buy_list=isset($_SESSION['buy_list'])?$_SESSION['buy_list']:null;
$buy_pagelist=isset($_SESSION['buypage_list'])?$_SESSION['buypage_list']:null;
if($id)
{
    if($id == $buy_list[0]['byuser_id'])
    {
        ?>
        <table border="1" style="text-align: center;margin-left: 0px; margin-bottom: 20px;" >
            <h1 align="center">주문배송</h1>
            <tr><td>번호</td><td>이미지</td><td>상품명</td><td>갯수</td><td>가격</td><td>주문날짜</td><td>입금여부</td><td>주문취소</td></tr>
            <?php for($iCount=0; $iCount<count($buy_list); $iCount++) { ?>
                <tr>
                    <td width="100"><?= $buy_list[$iCount]['bynum'] ?></td>
                    <td><img src="../img/product_S/<?=$buy_list[$iCount]['psimage']?>" style="width: 150px; height: 150px; margin-top: 3px; margin-bottom: 3px"></td>
                    <td width="150"><?= $buy_list[$iCount]['pname'] ?></td>
                    <td width="150"><?= $buy_list[$iCount]['bystock'] ?></td>
                    <td width="150"><?= $buy_list[$iCount]['bymoney'] ?></td>
                    <td width="200"><?=$buy_list[$iCount]['date']?></td>
                    <td width="150">
                        <?php if($buy_list[$iCount]['deposit'] != "on") {?>
                        <a href="../Ctl/MainCTL.php?action=703&bynum=<?=$buy_list[$iCount]['bynum']?>">입금대기</a>
                        <?php  }else{
                           echo $buy_list[$iCount]['bydelivery'];
                        }?>
                    </td>
                    <td width="150">
                        <?php
                        if($buy_list[$iCount]['bydelivery'] != '배송완료'){?>
                        <a href="../Ctl/MainCTL.php?action=702&buynum=<?=$buy_list[$iCount]['bynum']?>&bystock=<?=$buy_list[$iCount]['bystock']?>&pnum=<?=$buy_list[$iCount]['pnum']?>">주문취소</a>
                        <?php }elseif($buy_list[$iCount]['buy']=='구매완료') {
                            echo $buy_list[$iCount]['buy'];
                        }elseif($buy_list[$iCount]['bydelivery'] == '배송완료'){
                            echo "<a href='../Ctl/MainCTL.php?action=705&bynum={$buy_list[$iCount]['bynum']}'>구매확정</a><br>";
                            echo "<a href='../Ctl/MainCTL.php?action=702&buynum={$buy_list[$iCount]['bynum']}&bystock={$buy_list[$iCount]['bystock']}&pnum={$buy_list[$iCount]['pnum']}'>환불하기</a>";
                        }?>
                    </td>
                </tr>
                <?php
            }?>
        </table>
    <?php }else{
        echo "목록이 비었습니다.";
    } ?>
<?php }else{
    echo "로그인 후 이용가능 합니다.";
} ?>
<?php
if($buy_pagelist)
{
    include_once "./page.php";
    $action=700;
    $pageNumParaName="";
    $serch['serch'] = isset($_REQUEST['serch']) ? $_REQUEST['serch'] : null;
    $serch['all'] = isset($_REQUEST['all']) ? $_REQUEST['all'] : null;
    Master_pagenation($buy_pagelist,$action,$serch,$pageNumParaName);
}
?>

