<html>
<head>

</head>
<body>
<?php
if (!$id) {
    echo"   <table>
    <form action='../Ctl/MainCTL.php?action=11' method='post' style='float: left'>
        <tr><td>id</td><td><input type='text' size='15' name='id' ></td></tr>
        <tr><td>password</td><td><input type='password' size='15' name='passwd'></td></tr>
        <tr><td colspan='2' align='right'><input type='submit' value='로그인'></td></tr>
    </form>
    <form action='../Ctl/MainCTL.php?action=13' method='post'>
        <tr><td colspan='2' align='right'><input type='submit' value='가입' ></td></tr>
    </form>
   </table>";
    }
else{
    if($level < 999) {
        echo $id . "님<br>";
        echo "로그인완료";
        echo "<form action='../Ctl/MainCTL.php?action=12' method='post'>
          <input type=submit value='로그아웃'>
          </form>";
    }else{
        echo "관리자님<br>";
        echo "어서오세요";
        echo "<form action='../Ctl/MainCTL.php?action=12' method='post'>
          <input type=submit value='로그아웃'>
          </form>";
    }
}
?>
</body>
</html>