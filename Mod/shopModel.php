<?php
function insert_basket($view_result,$stock_count,$id)
{
    $db_conn=db_connection();
    $pprice=$stock_count*$view_result['pprice'];
    $sql="insert into basket (pnum,bstock,bmoney,user_id)
          values ({$view_result['pnum']},$stock_count,$pprice,'$id')";

    $query = mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function shop_select($id)
{
    $db_conn=db_connection();
    $sql="select p.pnum,b.bnum,b.bstock,b.bmoney,b.user_id,p.pcategory,p.pcode,p.pname,p.psimage from basket b,product p where p.pnum=b.pnum AND b.user_id='$id' order by b.bnum desc";
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
/////////////////////
function shop_select2($bnum)
{
    $db_conn=db_connection();

    $sql="select * from basket where bnum=$bnum";
    $query=mysqli_query($db_conn,$sql);
    $rows=mysqli_fetch_array($query,MYSQLI_ASSOC);
    /*-----------------------------------------------*/
    $sql2="delete from basket where bnum=$bnum";
    mysqli_query($db_conn,$sql2);

    mysqli_close($db_conn);
    return $rows;
}
/////////////////////////////
function buy_insert($result)
{
    $db_conn=db_connection();
    $sql="insert into buy(pnum,bystock,bymoney,byuser_id,date)
          VALUES('{$result['pnum']}','{$result['bstock']}','{$result['bmoney']}','{$result['user_id']}',now())";
    mysqli_query($db_conn,$sql);
    $bynum=mysqli_insert_id($db_conn);
    mysqli_close($db_conn);
    return $bynum;
}
function product_update($bynum)
{
    $db_conn=db_connection();
    $sql="select * from buy where bynum=$bynum";
    $query=mysqli_query($db_conn,$sql);
    $rows=mysqli_fetch_array($query);

    $sql2="update product set pstock=pstock-{$rows['bystock']} where pnum={$rows['pnum']}";
    $result=mysqli_query($db_conn,$sql2);

    return $result;
}
function buy_count($id)
{
    $db_conn=db_connection();
    $sql="select count(*) from buy where byuser_id='$id'";
    $query=mysqli_query($db_conn,$sql);
    $count=mysqli_fetch_array($query);
    echo $sql;
    return $count;
}
function buy_select($id,$pagelist,$page)
{
    $db_conn=db_connection();
    $first_num=($pagelist['current_page']-1)*$page;
    $sql="select * from buy b,product p where b.pnum=p.pnum AND byuser_id='$id' order by bynum desc limit $first_num,$page";
    echo $sql;
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
function buy_delete($delete_buy)
{
    $db_conn=db_connection();
    $sql="delete from buy where bynum={$delete_buy['bynum']}";
    $query=mysqli_query($db_conn,$sql);
    $sql2="delete from admin where bynum={$delete_buy['bynum']}";
    $query2=mysqli_query($db_conn,$sql2);

    $sql3="update product set pstock=pstock+{$delete_buy['bystock']} where pnum='{$delete_buy['pnum']}'";
    mysqli_query($db_conn,$sql3);
    mysqli_close($db_conn);
    return $query;
}
function buy_view($buy)
{
    $db_conn=db_connection();
    $sql="select * from buy b,product p where b.pnum=p.pnum AND bynum=$buy order by bynum desc";
    $query=mysqli_query($db_conn,$sql);
    $rows=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $rows;
}
function buy_success($buy_action,$buyView_list)
{
    $db_conn=db_connection();
    $sql="insert into admin(pnum,bynum,name,home,phone)
          VALUES ('{$buyView_list['pnum']}','{$buyView_list['bynum']}','{$buy_action['name']}',
          '{$buy_action['home']}','{$buy_action['phone']}')";
    $query=mysqli_query($db_conn,$sql);
    $sql2="update buy set deposit='{$buy_action['money']}' where bynum={$buyView_list['bynum']}";
    mysqli_query($db_conn,$sql2);
    $sql="update buy set bydelivery='배송준비' where bynum={$buyView_list['bynum']}";
    mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function buy_clear($bynum){
    $db_conn=db_connection();
    $sql="update buy set buy='구매완료' where bynum=$bynum";
    mysqli_query($db_conn,$sql);

    $sql2="select * from buy where bynum=$bynum";
    $query=mysqli_query($db_conn,$sql2);
    $result=mysqli_fetch_array($query);

    mysqli_close($db_conn);
    return $result;
}
function sales($result){
    $db_conn=db_connection();
    $sql="insert into sales(pnum,sstock,smoney) values({$result['pnum']},{$result['bystock']},{$result['bymoney']})";
    $query=mysqli_query($db_conn,$sql);

    echo $sql;
    mysqli_close($db_conn);
    return $query;
}
function sales_count()
{
    $db_conn=db_connection();
    $sql="select count(*) from sales";
    $query=mysqli_query($db_conn,$sql);
    $count=mysqli_fetch_array($query);

    return $count;
}
function Sum_sales_list()
{
    $db_conn=db_connection();
    $sql="select sum(smoney) from sales";
    $money=mysqli_query($db_conn,$sql);
    $result=mysqli_fetch_array($money);
    return $result;
}
function sales_list($sales_pagelist,$page)
{
    $db_conn=db_connection();
    $first_num=($sales_pagelist['current_page']-1)*$page;
    $sql="select * from sales s,product p where s.pnum=p.pnum order by snum desc  limit $first_num,$page";
    $query=mysqli_query($db_conn,$sql);
    $count=0;
    while($rows=mysqli_fetch_array($query))
    {
        $result[$count]=$rows;
        $count++;
    }
    return $result;
}
function adminbuy($pageinfo,$page)
{
    $db_conn=db_connection();
    $first_num=($pageinfo['current_page']-1)*$page;
    $sql="select * from buy b,product p where b.pnum=p.pnum order by bynum desc limit $first_num,$page";
    echo $sql;
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
function adminbuy_count(){
    $db_conn=db_connection();
    $sql="select count(*) from buy";
    $query=mysqli_query($db_conn,$sql);
    $count=mysqli_fetch_array($query);
    return $count;
}
function admin_count()
{
    $db_conn=db_connection();
    $sql="select count(*) from admin a, product p,buy b where a.pnum=p.pnum AND a.bynum=b.bynum order by anum desc";
    $query=mysqli_query($db_conn,$sql);
    $count=mysqli_fetch_array($query);
    return $count;
}
function selectadmin($adminpage_list,$page)
{
    $db_conn=db_connection();
    $first_num=($adminpage_list['current_page']-1)*$page;
    $sql="select * from admin a, product p,buy b where a.pnum=p.pnum AND a.bynum=b.bynum order by anum desc limit $first_num,$page";
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
function delivery_update($buynum)
{
    $db_conn=db_connection();
    $sql2="update buy set bydelivery='배송중' where bynum=$buynum";
    $query=mysqli_query($db_conn,$sql2);
    mysqli_close($db_conn);

    return $query;
}
function delivery_update2($buynum)
{
    $db_conn=db_connection();
    $sql2="update buy set bydelivery='배송완료' where bynum=$buynum";
    $query=mysqli_query($db_conn,$sql2);
    mysqli_close($db_conn);

    return $query;
}
?>