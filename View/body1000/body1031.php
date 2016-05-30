<?php
$view_result=isset($_SESSION['view_result'])?$_SESSION['view_result']:null;
$image="../img/product/{$view_result['pfimage']}";
$no_image="../img/NOIMG.jpg";
?>
    <form action="../Ctl/MainCTL.php?action=801" method="post">
        <table style="margin-left: 20px">
            <tr>
                <td rowspan="5">
                    <?php if(!file_exists($image) || $view_result['pfimage'] == ""){ ?>
                        <img src="../img/Noimg/NOIMG.jpg">
                    <?php }else{?>
                        <img src="../img/product/<?=$view_result['pfimage']?>">
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><h1 class="product">상품명 </h1></td><td><h1 class="subject"><?=$view_result['pname']?></h1></td>
            </tr>
            <tr>
                <td><h1 class="product">상품갯수 </h1></td><td><h1 class="subject"><?=$view_result['pstock']?></h1></td>
            </tr>
            <tr>
                <td><h1 class="product">상품가격 </h1></td><td><h1 class="subject"><?=$view_result[5]?></h1></td>
            </tr>
            <tr>
            <td><h1 class="product">갯수</h1></td><td><input type="number" name="number" min="1" max="<?=$view_result?>" step="1"></td>
            </tr>
        </table>
        <?php if($id){ ?>
        <div style="text-align: center; margin-top: 15px; margin-right: 100px" >
            <input type="hidden" value="<?=$id?>" name="id">
            <input type="submit" value="장바구니" style="width: 100px;height: 100px; float: right">
        </div>
    </form>
    <form action="../Ctl/MainCTL.php?action=803" style="text-align: right;" method="post">
        <input type="submit" value="바로구매" style="width: 100px;height: 100px; margin-right: 20px">
    </form>
<?php } ?>
