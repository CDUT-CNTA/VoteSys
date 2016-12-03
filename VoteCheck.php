<?php
    //引用数据库信息文件
    require_once 'DataBaseInfo.php';
    
    header("Content-type: text/html; charset=utf-8"); 

    //【投票统计】
    //传递变量如下：
    //部门节目    depart
    //姓名    name 
    //时间    time
    //其中会员的登陆密码默认为学号，登陆昵称默认为真实姓名

    $link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if( !$link ){
        die("连接数据库失败</br>".mysqli_connect_error($link));
    }

    //提交人姓名查重判断
    $sql = "SELECT `id` FROM `cnta_vote` WHERE `name` = '".$_POST['name']."'";

    if( !($res = mysqli_query( $link, $sql)) ){
        echo "数据库查询失败，请重试。";
        $link->close();
        die();
    }
        
    $check_repeat = mysqli_fetch_assoc( $res);

    if($check_repeat['id']){
        echo "请勿重复提交投票。";
        $link->close();
        die();
    }

    //获取当前提交时间
    $time_check = date("Y-m-d H:i:s",time());
    
    //提交数据
    $sql = "INSERT INTO `cnta_vote`(`depart`, `name`, `time`) VALUES ('".$_POST['depart']."','".$_POST['name']."','".$time_check."')";
 
    mysqli_query( $link, $sql);

    mysqli_free_result( $res);

    mysqli_close( $link);
    
    echo "恭喜你！投票成功";
    
    die();

?>