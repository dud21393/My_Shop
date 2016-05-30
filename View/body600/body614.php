<?php
$boardView=isset($_SESSION['boardView'])?$_SESSION['boardView']:null;
$image_list = isset($_SESSION['img_list'])?$_SESSION['img_list']:null;
$Image_path="../img/product/";
?>
<form action="../Ctl/MainCTL.php?action=615" style="text-align: center;" method="post" enctype="multipart/form-data">
    <h1><?=$boardView[1]?>님의 글</h1>
    <table width="900px" border="1" align="center">
        <tr height="10"><td width="100">글번호</td><td><?=$boardView[0]?>
            <input type="hidden" name=bnum value="<?=$boardView[0]?>"></td></tr>
        <tr height="20"><td>글쓴이</td><td><?=$boardView[6]?></td></tr>
        <tr height="100"><td>제목</td><td><input type="text" name="subject" value="<?=$boardView[2]?>"></td></tr>
        <tr height="500">
            <td>내용</td>
            <td>
                <?php
                for($iCount=0; $iCount<count($image_list); $iCount++)
                {
                    echo "<div>";
                    echo "<img src='$Image_path{$image_list[$iCount][2]}'>";
                    echo "<input type='checkbox' value='{$image_list[$iCount][2]}' name='image[]'>";
                    echo "</div>";
                }
                ?>
                <textarea name="contents" style="resize:none; width: 800px;"><?=$boardView[3]?></textarea>
            </td>
        </tr>
    </table>
    <input type='file' name="reimage[]" style="margin-left: 150px" multiple>;

    <div style="text-align: right; margin-right: 150px">
    <input type="submit" value="수정완료">
    </div>
</form>
