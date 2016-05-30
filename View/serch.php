<?php
function Master_serch($action)
{
    echo "<form action='../Ctl/MainCTL.php?action=$action' method='post' align='center'>
        <select name='serch'>
        <option value='mid' selected>아이디</option>
        <option value='mname'>이름</option>
        </select>
        <input type='text' size='10' name='all'>
        <input type='submit' value='찾기'>
        </form>";
}

function Board_serch($action)
{
    echo "<form action='../Ctl/MainCTL.php?action=$action' method='post' align='center'>
        <select name='serch'>
        <option value='all' selected>제목+내용</option>
        <option value='subject'>제목</option>
        </select>
        <input type='text' size='10' name='all'>
        <input type='submit' value='찾기'>
        </form>";

}

?>