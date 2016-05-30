<?php

function Login_info($value) // 로그인을 위한 함수
{
    $db_conn = db_connection();
    $sql = "select * from member where mid='{$value['id']}'AND mpassword='{$value['passwd']}'";

    $query = mysqli_query($db_conn, $sql);
    $result = mysqli_fetch_array($query);
    if($result['mid'] == $value['id'] && $result['mpassword'] == $value['passwd'])
    {
        $code['value']=1;
        $code['level'] = $result['mlevel'];
        $code['id'] = $result['mid'];
        $code['alias'] = $result['malias'];
    }
    else
    {
        $code['value'] = -1;
    }
    mysqli_close($db_conn);
    return $code;
}
function member_Join($value) //맴버 가입을 위함 함수
{
    $db_conn=db_connection();
    $sql ="insert into member(mid,mpassword,mname,mtel,malias) values('{$value['id']}','{$value['passwd']}','{$value['name']}','{$value['tel']}','{$value['alias']}')";
    $query=mysqli_query($db_conn,$sql);

    mysqli_close($db_conn);
    return $query;
}
function member_select($page_info,$page) // 맴버 전체 나타내기 위한 함수
{
    $db_conn=db_connection();
    $firstNum= ($page_info['current_page'] -1 ) * $page;
    $sql="select * from member order by mnum desc limit $firstNum,".$page;

    $query=mysqli_query($db_conn,$sql);

    $iCount=0;
    while($row=mysqli_fetch_array($query))
    {
        $array[$iCount]=$row;
        $iCount++;
    }
    mysqli_close($db_conn);

    return $array;
}
function member_modify_select($id) //수정하기 위해 회원id를 클릭하고 나타낼려고 만든 함수
{
    $db_conn=db_connection();
    $sql = "select * from member where mid='$id';";
    $query=mysqli_query($db_conn,$sql);
    $rs=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $rs;
}
function member_modify($data) //회원수정
{
    $db_conn=db_connection();
    $sql = "update member set mid='{$data['id']}',mname='{$data['name']}',mpassword='{$data['passwd']}',mtel='{$data['tel']}',mlevel='{$data['level']}' where mid='{$data['id']}'";
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function member_delete($member_num) // 회원삭제
{
    $db_conn=db_connection();
    $sql= "delete from member where mnum=$member_num";
    $d_result = mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $d_result;
}
function serch_select($serch_data,$page_info,$page) //회원 검색
{
    $db_conn=db_connection();
    $serch_first_page=($page_info['current_page'] -1 ) * $page;;
    $sql="select * from member where {$serch_data['serch']}='{$serch_data['all']}' limit $serch_first_page,".$page;
    $serch_query=mysqli_query($db_conn,$sql);
    $iCount=0;
    while($serch_row=mysqli_fetch_array($serch_query))
    {
        $serch_result[$iCount]=$serch_row;
        $iCount++;
    }
    mysqli_close($db_conn);
    return $serch_result;
}

function product_select($ppage_info,$pcategory,$page)//상품 리스트
{
    $db_conn=db_connection();
    $product_first_page=($ppage_info['current_page'] -1 ) * $page;
    $sql = "select * from product where pcategory like'{$pcategory}' order by pnum desc limit $product_first_page,".$page;

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
function AdminProduct_select($product_pageinfo,$page)
{
    $db_conn=db_connection();
    $first_info=($product_pageinfo['current_page'] -1) *$page;
    $sql="select * from product order by pnum desc limit $first_info,".$page;
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
function product_insert($product_data)
{
    $db_conn=db_connection();
    $sql="insert into product(pcategory,pcode,pname,pstock,pprice,pfimage,psimage) values('{$product_data['pcategory']}','{$product_data['pcode']}','{$product_data['pname']}','{$product_data['pstock']}','{$product_data['pprice']}','{$product_data['pfimage']}','{$product_data['psimage']}')";

    $query=mysqli_query($db_conn,$sql);
    $pnum=mysqli_insert_id($db_conn);

    $result['query'] =$query;
    $result['pnum'] =$pnum;
    mysqli_close($db_conn);
    return $result;
}
function FileUpload($Fileinfo,$product_imgePath,$saveFileWithExt)
{
    $targetDir=$product_imgePath;
    $targetFile=$targetDir.basename($saveFileWithExt);
    $imgeFileType=pathinfo($targetFile,PATHINFO_EXTENSION);

    //이미지파일인지 아닌지 확인
    $img_check=getimagesize($Fileinfo['tmp_name']);
    if($img_check)
    {
        $result['upload'] = 1;
    }else
    {
        $result['msg'][0]="이미지 파일이 아닙니다";
        $result['upload'] = 0;
    }
    //파일 있는지 확인
    if(file_exists($targetFile))
    {
        $result['msg'][1] = "존재하는 파일입니다.";
        $result['upload'] = 0;
    }
    //이미지 파일이 jpg,jpeg,png,gif인지 확인
    if($imgeFileType != "jpg" && $imgeFileType != "png" && $imgeFileType != "jpeg" && $imgeFileType != "gif")
    {
        $result['msg'][2] = "이미지의 확장가 형식이 맞지 않습니다.";
        $result['upload'] = 0;
    }

    // 위 사항 점검에 이상 없는지 확인 후 업로드 실시한다.
    if($result['upload'] == 0)
    {
        $result['msg'][3] = "파일 업로드 불가능";
    }else
    {
        if(move_uploaded_file($Fileinfo['tmp_name'], $targetFile))
        {
            $result['msg'][4] = "파일 업로드 실시";
        }else
        {
            $result['msg'][4] = "파일 업로드 불가능";
        }
    }

    return $result;
}

//썸네일이미지 생성 함수
function thumnailimage($src,$dest,$areaHieght,$imgFileType)
{

    //Imagick::resizeImage();
    if($imgFileType == "jpg" || $imgFileType == "jepg")
    {
        $orginImage = imagecreatefromjpeg($src);
    }elseif($imgFileType == "png")
    {
        $orginImage = imagecreatefrompng($src);
    }else{
        $orginImage = imagecreatefromgif($src);
    }

    $width=imagesx($orginImage);
    $height=imagesy($orginImage);

    //이미 크기 조정
    $areaWidth= floor($width * ($areaHieght/$height));

    //새롭게 사용할 이미지 생성
    $useImage = imagecreatetruecolor($areaWidth, $areaHieght);

    imagecopyresampled($useImage,$orginImage,0,0,0,0,$areaWidth,$areaHieght,$width,$height);

    if($imgFileType == "jpg" || $imgFileType == "jege")
    {
        imagejpeg($useImage,$dest);
    }elseif($imgFileType == "png")
    {
        imagepng($useImage,$dest);
    }else{
        imagegif($useImage,$dest);
    }

}
function select_view($pnum){
    $db_conn=db_connection();
    $sql="select * from product where pnum={$pnum['pnum']}";
    $query=mysqli_query($db_conn,$sql);

    $rows=mysqli_fetch_array($query);

    return $rows;

}

function image_delete($image){//이미지 삭제 부분 구현
    $image['pfimage'] = "../img/product/{$image['pfimage']}";
    $image['psimage'] = "../img/product_S/{$image['psimage']}";
    unlink($image['pfimage']);
    unlink($image['psimage']);
}

function update_product($product_insert){
    $db_conn = db_connection();
    $sql = "update product set pcode='{$product_insert['pcode']}',pfimage='{$product_insert['pfimage']}',psimage='{$product_insert['psimage']}' where pnum = {$product_insert['pnum']}";
    $query = mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function update_product2($product_update){
    var_dump($product_update);
    $db_conn = db_connection();
    $sql="update product set pname='{$product_update['pname']}',pstock='{$product_update['pstock']}',pprice='{$product_update['pprice']}',pfimage='{$product_update['pfimage']}',psimage='{$product_update['psimage']}' where pnum={$product_update['pnum']}";
    $query = mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}

function member_Page_Count() //회원전체 페이지네이션 숫자값
{
    $db_conn=db_connection();
    $sql="select count(*) from member";
    $query=mysqli_query($db_conn,$sql);
    $member_count=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $member_count;
}

function serch_Page_Count($serch_data) //회원검색 페이지네이션 숫자
{
    $db_conn=db_connection();
    $sql="select count(*) from member where {$serch_data['serch']}='{$serch_data['all']}'";
    $query=mysqli_query($db_conn,$sql);
    $serch_count=mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $serch_count;
}
function product_Page_Count()  //상품관리 페이지네이션 숫자
{
    $db_conn=db_connection();
    $sql="select count(*) from product";
    $query=mysqli_query($db_conn,$sql);

    $product_Count = mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $product_Count;
}
function pcategory_count($pcategory)
{
    $db_conn=db_connection();
    $sql="select count(*) from product where pcategory like '$pcategory'";
    $query=mysqli_query($db_conn,$sql);
    $count = mysqli_fetch_array($query);
    mysqli_close($db_conn);
    return $count;

}
function  product_delete($product_num)
{
    $db_conn=db_connection();
    $sql="delete from product where pnum=$product_num";
    $query=mysqli_query($db_conn,$sql);
    mysqli_close($db_conn);
    return $query;
}
function pagenation($page_num,$count,$page,$block_page)  //페이지네이션 계산
{
    $page=isset($page)?$page:10;
    $block_page=isset($block_page)?$block_page:10;

    $full_count=$count[0]; //전체 레코드 숫자
    $full_page=ceil($full_count/$page); // 전체 페이지 숫자
    $full_block=ceil($full_page/$block_page); // 전체 블럭 숫자

    $current_block=ceil($page_num/$block_page); //현재 페이지의 블럭 숫자
    $last_block_page=$full_page -(($full_block-1)*$block_page); //마지막 블럭의 마지막 페이지 갯수

    $page_info['firstPageinfo'] = ($page_num == 1) ? false : true; //처음 페이지 표시 여부
    $page_info['lastPageinfo'] = ($page_num == $full_page) ? false : true; // 마지막 페이지 표시 여부
    $page_info['blockFirstPagenum'] =(($current_block*$block_page)+1)-$block_page; // 현 블럭에서의 시작 페이지 번호
    $page_info['current_page']=($page_num<=$full_page) ? $page_num : $page_num-1;//현재 page 번호
    $page_info['nextblock']=($current_block>=$full_block)?0:$page_info['blockFirstPagenum']+$block_page;//다음 블럭으로 옮기기

    $page_info['preblock']=($page_num<=$block_page)?0:$page_info['blockFirstPagenum']-$block_page;//이전 블럭으로 옮기기
    $page_info['countPage']=($current_block != $full_block)?$block_page:$last_block_page; //페이지 뿌리는 갯수

    $page_info['full_count']=$full_count;
    $page_info['full_page']=$full_page;
    $page_info['full_block']=$full_block;

    $page_info['current_block']=$current_block;
    $page_info['last_block_page']=$last_block_page;

    return $page_info;
}

?>