<html>
<head>
    <h2 align="center">회원</h2>
</head>
<body>
<?php
$pageinfo=$_SESSION['page_info'];
$row=$_SESSION['modify'];
?>
<table align="center" width="400" border="1">
    <form action="../Ctl/MainCTL.php?action=614" method="post">
        <?php
        echo "<tr><td width='100'>번호</td><td>$row[0]</td></tr>";
        echo "<tr><td width='100'>아이디</td><td>$row[1]<input type='hidden' value='$row[1]'name='id'></td></tr>";
        echo "<tr><td width='100'>비번</td><td><input type='text' value='$row[2]' size='20' name='passwd'></td></tr>";
        echo "<tr><td width='100'>이름</td><td><input type='text' value='$row[3]' size='20' name='name'></td></tr>";
        echo "<tr><td width='100'>전화번호</td><td><input type='text' value='$row[4]' size='20' name='tel'></td></tr>";
        echo "<tr><td width='100'>레벨</td><td><input type='text' value='$row[5]' size='20' name='level'></td></tr>";
        echo "<tr><td colspan='2' align='center'>
                  <input type='submit' value='전송'>
                  <input type='hidden' value='{$pageinfo['current_page']}' name='page'>
                   </td></tr>";
        ?>
    </form>
</table>
</body>
</html>