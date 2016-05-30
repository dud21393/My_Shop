<?php
define("Page",6);
function board_insert($board_insert)
{
    $db_conn=db_connection();
    $sql="insert into board(user_id,subject,contents,reg_date,user_alias) values('{$board_insert['id']}','{$board_insert['subject']}','{$board_insert['contents']}',now(),'{$board_insert['alias']}')";
    $insert_result['result'] = mysqli_query($db_conn,$sql);
    $insert_result['bnum']=mysqli_insert_id($db_conn);
    $sql2="update board set bgroup_num={$insert_result['bnum']} where bnum={$insert_result['bnum']}";
    mysqli_query($db_conn,$sql2);
    mysqli_close($db_conn);
    return $insert_result;
}
function insert_reply($parent,$board_insert){
    $db_conn=db_connection();
    $sql="update board set bord=bord+1 where bgroup_num={$parent['bgroup_num']}AND bord > {$parent['bord']}";
    mysqli_query($db_conn,$sql);

    $ord=$parent['bord']+1;
    $depth=$parent['bdepth']+1;
    $re="└";

    $sql2="insert into board(user_id,subject,contents,reg_date,user_alias,bgroup_num,bdepth,bord)
           values('{$board_insert['id']}','$re{$board_insert['subject']}','{$board_insert['contents']}',now(),'{$board_insert['alias']}',{$parent['bgroup_num']},$depth,$ord)";
    $insert_result['result']=mysqli_query($db_conn,$sql2);
    $insert_result['bnum']=mysqli_insert_id($db_conn);

    return $insert_result;
}
function select_reply()
{
    $db_conn=db_connection();
    $sql="select bnum,count(*) as 'num' from reply group by bnum";
    $_SESSION['sql']=$sql;
    $query=mysqli_query($db_conn,$sql);
    $iCount=0;
    while($rows=mysqli_fetch_array($query))
    {
        $result[$iCount]=$rows;
        $iCount++;
    }
    return $result;
}
function board_select($bpageinfo,$page)
{
    $db_conn=db_connection();
    $firstNum= ($bpageinfo['current_page'] -1 ) * $page;
    $sql="select * from board order by bgroup_num desc,bord asc limit $firstNum,".$page;
    $query= mysqli_query($db_conn,$sql);
    $iCount=0;
    while($rows=mysqli_fetch_array($query))
    {
        $result[$iCount]=$rows;
        $iCount++;
    }
    mysqli_close($db_conn);
    return $result;

}
function board_select_Count()
{
    $db_conn = db_connection();
    $sql = "select count(*) from board";
    $query = mysqli_query($db_conn,$sql);
    $count= mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $count;
}
function serch_board_Count($board_serch)
{
    $db_conn = db_connection();

    if($board_serch['serch'] == "all")
    {
        $sql = "select count(*) from board where subject like '%{$board_serch['all']}%' OR contents like '%{$board_serch['all']}%'";
    }else {
        $sql = "select count(*) from board where subject like '%{$board_serch['all']}%'";
    }
    $query = mysqli_query($db_conn,$sql);
    $count= mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $count;
}
function serch_board_select($bpageinfo,$page,$board_serch)
{
    $db_conn=db_connection();
    $firstNum= ($bpageinfo['current_page'] -1 ) * $page;
    if($board_serch['serch'] == "all")
    {
        $sql = "select * from board where subject like '%{$board_serch['all']}%' OR contents like '%{$board_serch['all']}%' order by bnum desc limit $firstNum,$page ";
    }else
        $sql = "select * from board where subject like '%{$board_serch['all']}%' order by bnum desc limit $firstNum,$page";

    $query= mysqli_query($db_conn,$sql);
    $iCount=0;
    while($rows=mysqli_fetch_array($query))
    {
        $result[$iCount]=$rows;
        $iCount++;
    }
    mysqli_close($db_conn);
    return $result;
}
function board_view($board_view)
{
    $db_conn= db_connection();
    if($board_view['hit'])
    {
        $hit_sql="update board set hits=hits+1 where bnum={$board_view['bnum']}";
        mysqli_query($db_conn,$hit_sql);
    }
    $sql ="select * from board where bnum={$board_view['bnum']}";
    $query=mysqli_query($db_conn,$sql);
    $rows=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $rows;
}
function board_view2($board_view)
{
    $db_conn= db_connection();
    $sql ="select * from board where bnum={$board_view['bnum']}+1";
    $query=mysqli_query($db_conn,$sql);
    $rows=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $rows;
}
function board_update($board_update)
{
    $db_conn= db_connection();
    $sql="update board set subject='{$board_update['subject']}',contents='{$board_update['contents']}' where bnum={$board_update['bnum']} ";
    echo $sql;
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function board_delete($board_delete)
{
    $db_conn=db_connection();
    $sql="delete from board where bnum={$board_delete['bnum']}";
    $sql1="delete from image where bnum={$board_delete['bnum']}";
    $sql2="delete from reply where bnum={$board_delete['bnum']}";
    $query=mysqli_query($db_conn,$sql);
    mysqli_query($db_conn,$sql1);
    mysqli_query($db_conn,$sql2);
    mysqli_close($db_conn);
    return $query;
}
function reply_insert($reply_insert)
{
    $db_conn=db_connection();
    $sql="insert into reply(bnum,user_alias,contents,re_date)
          values('{$reply_insert['bnum']}','{$reply_insert['alias']}','{$reply_insert['contents']}',now())";
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function reply_select($reply_bnum,$pageinfo,$page_num)
{
    $db_conn=db_connection();
    $first_num=($pageinfo['current_page']-1)*10;
    $sql = "select * from reply where bnum=$reply_bnum order by re_num desc limit $first_num,$page_num";
    $query = mysqli_query($db_conn,$sql);
    $iCount=0;
    while($rows=mysqli_fetch_array($query))
    {
        $reply_result[$iCount]=$rows;
        $iCount++;
    }
    mysqli_close($db_conn);
    return $reply_result;
}
function reply_count($reply_bnum)
{
    $db_conn=db_connection();
    $sql= "select count(*) from reply where bnum=$reply_bnum";
    $query=mysqli_query($db_conn,$sql);
    $count=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $count;
}
function reply_modify($reply_modify)
{
    $db_conn=db_connection();
    $sql="update reply set contents='{$reply_modify['contents']}' where re_num={$reply_modify['renum']}";
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function reply_delete($reply_num)
{
    $db_conn=db_connection();
    $sql="delete from reply where re_num=$reply_num";
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function img_insert($bnum)
{
    $db_conn=db_connection();
    $sql="insert into image(bnum) values ($bnum)";
    mysqli_query($db_conn,$sql);
    $num=mysqli_insert_id($db_conn);
    mysqli_close($db_conn);
    return $num;
}
function image_update($image_update)
{
    $db_conn=db_connection();
    $sql="update image set i_name='{$image_update['name']}' where i_num='{$image_update['inum']}'";
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function image_view($image_view)
{
    $db_conn=db_connection();
    $sql="select * from image where bnum={$image_view}";
    $query=mysqli_query($db_conn,$sql);
    $iCount=0;
    while($rows=mysqli_fetch_array($query))
    {
        $result[$iCount]=$rows;
        $iCount++;
    }
    mysqli_close($db_conn);
    return $result;
}
function board_image_delete($image)//board에서 받은 이미지들
{
    for($iCount=0; $iCount<count($image); $iCount++)
    {
        $image = "../img/product/{$image[$iCount]}";
        unlink($image);
    }
}
function board_image_delete2($image)
{
    $db_conn=db_connection();
    for($iCount=0; $iCount<count($image); $iCount++) {
        $sql = "delete from image where i_name='{$image[$iCount]}'";
        mysqli_query($db_conn, $sql);
    }
    mysqli_close($db_conn);
}
function parent($bnum)
{
    $db_conn=db_connection();

}