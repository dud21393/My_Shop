<?php
$action['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : 100;
@session_start();
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$level = isset($_SESSION['level']) ?$_SESSION['level'] : 1;
$alias = isset($_SESSION['alias']) ?$_SESSION['alias'] : null;
$pageinfo=isset($_SESSION['page_info'])?$_SESSION['page_info'] : null;
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/css.css">
    <script src="../javascript/jquery-1.9.1.js"></script>
    <script src="../javascript/java.js"></script>
    <link href="../bootstrap-3.3.2-dist/bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>

<div class="top">
    <?php
    include_once "topmenu.php";
    ?>
</div>
<header>
    <?php
    include_once "./Title.php";
    ?>
</header>
<section style="width: 1400px; margin: auto">
    <div class="fix">
        <?php
        include 'Name.php'
        ?>
    </div>
<nav>
    <ul class="menu">
        <li>
            <?php
             if($level < 999) {
                 include 'Menu.php';
             }else
             {
                 include "AdminMenu.php";
             }
             ?>
             <?php
            if($level < 999){
                include 'SubMenu.php';
            }
            else{
                include 'AdminLeftMenu.php';
            }
            ?>
        </li>
    </ul>
</nav>
    <article style="margin-top:50px; border: 2px solid;">
        <?php include 'MainBody.php' ?>
    </article>
</section>
    <footer style="margin: auto;">
        <?php include 'Copyright.php' ?>
    </footer>
</body>
</html>