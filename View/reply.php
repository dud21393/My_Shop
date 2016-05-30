<?php

function reply($action,$bnum,$alias)
{?>
    <div style="margin-top:80px; margin-left: 100px;">
        <form action="../Ctl/MainCTL.php?action=<?=$action?>" method="post">
            <input type="hidden" name="bnum" value="<?=$bnum?>">
            <input type="hidden" name="alias" value="<?=$alias?>">
            <textarea name="contents" style="width: 900px; height: 100px; resize: none; float: left;"></textarea>
            <input type="submit" value="확인" style="width: 90px; height:100px; margin-left: 10px; background-color: white;">
        </form>
    </div>
<?php }?>