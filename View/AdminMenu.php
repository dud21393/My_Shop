<?php

$Menu=array("회원관리","상품관리","이벤트관리","게시판관리","구매관리","배송관리");

$AdminMenuNum = ($action['action'] / 10 )-1;

for($iCount = 0; $iCount<count($Menu); $iCount++ ) {
    $Code = 1000 + ($iCount*10)+10;
    echo "<a href=../Ctl/MainCTL.php?action=$Code>".$Menu[$iCount]."</a>";
}
?>