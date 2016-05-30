<?php
$buyView_list=isset($_SESSION['buyView_list'])?$_SESSION['buyView_list']:null;
?>
<form action="../Ctl/MainCTL.php?action=704&buynum=<?=$buyView_list['buynum']?>&user_id=<?=$buyView_list['user_id']?>" method="post">
<table border="1" width="1100" style="margin-left: 30px;">
    <tr>
        <td colspan="2">상품정보</td><td>판매자</td><td>배송비</td>
    </tr>
    <tr>
        <td width="150"><img src="../img/product_S/<?=$buyView_list['psimage']?>" width="200" height="100"></td>
        <td width="650" align="center">[<?=$buyView_list['pcode']?>]<?=$buyView_list['pname']?> <?=$buyView_list['bystock']?>개</td>
        <td width="100">정석영</td>
        <td width="100">2500</td>
    </tr>
</table>

<h2 style="margin-top: 50px;">주문상품</h2>
<div style="border-top: groove; border-bottom: groove; margin-left: 25px; margin-right: 60px;">
    <table>
        <tr>
            <td><h2>상품금액</h2></td>
            <td width="200" style="text-align: center"><h1>+</h1></td>
            <td><h2>배송비</h2></td>
            <td width="200" style="text-align: center"><h1>=</h1></td>
            <td><h2>최종가격</h2></td>
        </tr>
        <tr>
            <td style="text-align: center"><h2><?=$buyView_list['bymoney']?></h2></td>
            <td width="200" style="text-align: center"><h1>+</h1></td>
            <td style="text-align: center"><h2>2500</h2></td>
            <td width="200" style="text-align: center"><h1>=</h1></td>
            <td style="text-align: center"><h2><?=$buyView_list['bymoney']+2500?></h2></td>
        </tr>
    </table>
</div>

<h2 style="margin-top: 50px;">배송지</h2>
<div style="border:groove ; margin-left: 25px; margin-right: 60px;">
    <table>
        <tr height="50">
            <td>받으시는분</td>
            <td><input type="text" name="name" size="10" value="정석영"></td>
        </tr>
        <tr>
            <td>배송지</td>
            <td><input type="text" name="home" size="50" value="대구남구대명4동3033-18"></td>
        </tr>
        <tr height="50">
            <td>휴대폰</td>
            <td><input type="text" name="phone" size="20" value="01091317665"></td>
        </tr>
    </table>
</div>
<div style="margin-left: 30px">
    <h3><input type="radio" id="phone" name="money" checked>휴대폰결제</h3>
    <h3><input type="radio" id="card" name="money">카드결제</h3>

</div>
<div style=" margin-right: 60px;margin-top: 100px">
    <input type="submit"  value="결제하기" style="text-align: center; width: 200px;height: 100px; float: right">
</div>
</form>
<form action="../Ctl/MainCTL.php?action=702" method="post">
    <div style="text-align: right;">
        <input type="submit"  value="주문취소" style="text-align: center; width: 200px;height: 100px; margin-right: 10px">
    </div>
</form>