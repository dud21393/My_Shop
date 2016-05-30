<?php
function Master_pagenation($pageinfo,$action,$member_serch,$pageNumParaName)
{
    echo "<form align='center'>";
//////////////처음페이지로 가는 기호
    if ($pageinfo['firstPageinfo'] == true)
        echo "<a href=../Ctl/MainCTL.php?action=$action&page={$pageinfo['firstPageinfo']}&serch={$member_serch['serch']}&{$pageNumParaName}={$pageinfo['firstPageinfo']}&all={$member_serch['all']}>▲</a>&nbsp&nbsp";

//////////////////

//////////////////이전 블럭으로 가는 기호
    if ($pageinfo['preblock'] != 0)
        echo "<a href=../Ctl/MainCTL.php?action=$action&page={$pageinfo['preblock']}&{$pageNumParaName}={$pageinfo['preblock']}&serch={$member_serch['serch']}&all={$member_serch['all']}>≪</a>&nbsp&nbsp";

//////////////////////


/////////////////////// 이전페이지로 가는 기호
    if ($pageinfo['firstPageinfo'] == true) {
        $prePage = $pageinfo['current_page'] - 1;
        echo "<a href=../Ctl/MainCTL.php?action=$action&page={$prePage}&{$pageNumParaName}={$prePage}&serch={$member_serch['serch']}&all={$member_serch['all']}>◀</a>&nbsp&nbsp";
    }
///////////////////

    for ($iCount = 0; $iCount < $pageinfo['countPage']; $iCount++) {
        $currentPage = $pageinfo['blockFirstPagenum'] + $iCount;
        echo "<a href='../Ctl/MainCTL.php?action=$action&{$pageNumParaName}={$currentPage}&page={$currentPage}&serch={$member_serch['serch']}&all={$member_serch['all']}'>";
        if ($pageinfo['current_page'] == $currentPage) {
            echo "[" . $currentPage . "]";
        } else {
            echo $currentPage;
        }
        echo "</a>&nbsp&nbsp";
    }

//////////////////////////

///////////////////////다음 페이지로 가는 기호
    if ($pageinfo['lastPageinfo'] == true) {
        $nextPage = $pageinfo['current_page'] + 1;
        echo "<a href=../Ctl/MainCTL.php?action=$action&page={$nextPage}&serch={$member_serch['serch']}&{$pageNumParaName}={$nextPage}&all={$member_serch['all']}>▶</a>&nbsp&nbsp";
    }
//////////////

//////////////////////////다음 블럭으로 가는 기호
    if ($pageinfo['nextblock'] != 0)
        echo "<a href=../Ctl/MainCTL.php?action=$action&page={$pageinfo['nextblock']}&serch={$member_serch['serch']}&{$pageNumParaName}={$pageinfo['nextblock']}&all={$member_serch['all']}>≫</a>&nbsp&nbsp";

/////////////

///////////////////////////마지막 페이지로 가는 기호
    if ($pageinfo['lastPageinfo'] != false)
        echo "<a href=../Ctl/MainCTL.php?action=$action&page={$pageinfo['full_page']}&serch={$member_serch['serch']}&{$pageNumParaName}={$pageinfo['full_page']}&all={$member_serch['all']}>▼</a>&nbsp&nbsp";

    echo "</form>";
}
?>

<?php
function sub_pagenation($pageinfo,$action,$member_serch,$pageNumParaName,$bnum)
{
    echo "<form align='center'>";
//////////////처음페이지로 가는 기호
    if ($pageinfo['firstPageinfo'] == true)
        echo "<a href=../Ctl/MainCTL.php?action=$action&reply_page={$pageinfo['firstPageinfo']}&serch={$member_serch['serch']}&{$pageNumParaName}={$pageinfo['firstPageinfo']}&all={$member_serch['all']}&bnum=$bnum>▲</a>&nbsp&nbsp";

//////////////////

//////////////////이전 블럭으로 가는 기호
    if ($pageinfo['preblock'] != 0)
        echo "<a href=../Ctl/MainCTL.php?action=$action&reply_page={$pageinfo['preblock']}&{$pageNumParaName}={$pageinfo['preblock']}&serch={$member_serch['serch']}&all={$member_serch['all']}&bnum=$bnum>≪</a>&nbsp&nbsp";

//////////////////////


/////////////////////// 이전페이지로 가는 기호
    if ($pageinfo['firstPageinfo'] == true) {
        $prePage = $pageinfo['current_page'] - 1;
        echo "<a href=../Ctl/MainCTL.php?action=$action&reply_page={$prePage}&{$pageNumParaName}={$prePage}&serch={$member_serch['serch']}&all={$member_serch['all']}&bnum=$bnum>◀</a>&nbsp&nbsp";
    }
///////////////////

    for ($iCount = 0; $iCount < $pageinfo['countPage']; $iCount++) {
        $currentPage = $pageinfo['blockFirstPagenum'] + $iCount;
        echo "<a href='../Ctl/MainCTL.php?action=$action&{$pageNumParaName}={$currentPage}&reply_page={$currentPage}&serch={$member_serch['serch']}&all={$member_serch['all']}&bnum=$bnum'>";
        if ($pageinfo['current_page'] == $currentPage) {
            echo "[" . $currentPage . "]";
        } else {
            echo $currentPage;
        }
        echo "</a>&nbsp&nbsp";
    }

//////////////////////////

///////////////////////다음 페이지로 가는 기호
    if ($pageinfo['lastPageinfo'] == true) {
        $nextPage = $pageinfo['current_page'] + 1;
        echo "<a href=../Ctl/MainCTL.php?action=$action&reply_page={$nextPage}&serch={$member_serch['serch']}&{$pageNumParaName}={$nextPage}&all={$member_serch['all']}&bnum=$bnum>▶</a>&nbsp&nbsp";
    }
//////////////

//////////////////////////다음 블럭으로 가는 기호
    if ($pageinfo['nextblock'] != 0)
        echo "<a href=../Ctl/MainCTL.php?action=$action&reply_page={$pageinfo['nextblock']}&serch={$member_serch['serch']}&{$pageNumParaName}={$pageinfo['nextblock']}&all={$member_serch['all']}&bnum=$bnum>≫</a>&nbsp&nbsp";

/////////////

///////////////////////////마지막 페이지로 가는 기호
    if ($pageinfo['lastPageinfo'] != false)
        echo "<a href=../Ctl/MainCTL.php?action=$action&reply_page={$pageinfo['full_page']}&serch={$member_serch['serch']}&{$pageNumParaName}={$pageinfo['full_page']}&all={$member_serch['all']}&bnum=$bnum>▼</a>&nbsp&nbsp";

    echo "</form>";
}
?>
