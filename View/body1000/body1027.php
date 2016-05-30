<?php
$productView=isset($_SESSION['updateInfo'])?$_SESSION['updateInfo']:null;
if($productView) {
    ?>
        <form action="../Ctl/MainCTL.php?action=1028" method="post" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td>순번</td><td><?=$productView['pnum']?></td>
                <td><input type="hidden" name="pnum" value="<?=$productView['pnum']?>" </td>
            </tr>
            <tr>
                <td>카테고리</td><td><?=$productView['pcategory']?></td>
            </tr>
            <tr>
                <td>상품코드</td><td><?=$productView['pcode']?></td>
            </tr>
            <tr>
                <td>상품명</td><td><input type="text" name="pname" value="<?=$productView['pname']?>"></td>
            </tr>
            <tr>
                <td>상품갯수</td><td><input type="text" name="pstock" value="<?=$productView['pstock']?>"></td>
            </tr>
            <tr>
                <td>상품가격</td><td><input type="text" name="pprice" value="<?=$productView[5]?>"></td>
            </tr>
            <tr>
            <td>이미지</td><td><img src="../img/product/<?=$productView['pfimage']?>"></td>
                <input type="hidden" name="pfimage" value="<?=$productView['pfimage']?>">
                <input type="hidden" name="psimage" value="<?=$productView['psimage']?>">
            </tr>
            <tr>
                <td colspan="2"><input type="file" name="pfimage"></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><input type="submit" value="수정완료"></td>
            </tr>
        </table>
        </form>
    <?php } ?>