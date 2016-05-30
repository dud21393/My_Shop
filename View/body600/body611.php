<?php
$bnum=isset($_REQUEST['bnum'])?$_REQUEST['bnum']:null;
if(!$bnum)
{
?>
<form action="../Ctl/MainCTL.php?action=612" method="post" enctype="multipart/form-data">
    <?php
    }else{
    ?>
    <form action="../Ctl/MainCTL.php?action=621&bnum=<?=$bnum?>" method="post" enctype="multipart/form-data">
        <?php
        }
        ?>
    <table  width="900px">
    <tr><td>아이디</td><td><?=$id?>
            <input type="hidden" name="id" value="<?=$id?>">
        </td>
    </tr>
    <tr><td>닉네임</td><td><?=$alias?>
            <input type="hidden" name="alias" value="<?=$alias?>">
        </td>
    </tr>
    <tr><td>제목</td><td><input type="text" name="subject" style="width: 800px"></td></tr>
    <tr><td>내용</td><td><textarea name='contents' style="resize:none; width: 800px; height: 500px"></textarea></td></tr>
    <tr><td>사진첨부</td><td><input type="file" name="bimage[]" multiple></td></tr>
    <tr><td colspan="2"><input type="submit" value="확인"</td></tr>
</table>
</form>
