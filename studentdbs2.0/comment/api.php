<?php
include("../conn.php");
include("func.php");
session_start();
$action = $_REQUEST['action'];
//先构造一个基本的code-data-message结构的关联数组 
 $responseArr = array(
 		"code"=> 200,
 		"msg" =>"数据获取成功",
 		"data" =>null
 );
switch($action){
  //留言板接口
	case "comment" :
    $pagenum = empty($_REQUEST['pagenum'])?1:$_REQUEST['pagenum'];
    $pagesize = empty($_REQUEST['pagesize'])?5:$_REQUEST['pagesize'];
    $arr = pageList($pagenum,$pagesize,"comment");

    //给resoponsArr数组添加
    $responseArr["data"] = $arr ;
   //关闭数据库连接
  mysqli_close($conn);
  //将数组转换成json发送到前端
  die(json_encode($responseArr));
  break;
  //留言板接口
  case "comment1" :
    $pagenum = empty($_REQUEST['pagenum'])?1:$_REQUEST['pagenum'];
    $pagesize = empty($_REQUEST['pagesize'])?5:$_REQUEST['pagesize'];
    $arr = pageList($pagenum,$pagesize,"comment");
   
    //给resoponsArr数组添加
    $responseArr["data"] = $arr ;
   //关闭数据库连接
  mysqli_close($conn);
  //将数组转换成json发送到前端
  die(json_encode($responseArr));
  break;
  //登录接口
    case "login":
      $email = $_REQUEST["email"];
      $password = $_REQUEST["password"];
      //首先根据用户的email查是否至少一条记录
      $sql = "select id,email,nickname,password from user where email='{$email}'";

      $result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($result)>0){
      //如果邮箱正确，在判断密码是否相等
        $arr = mysqli_fetch_assoc($result);
        if($password == $arr["password"]){
          //邮件密码都对
          $_SESSION["email"] = $arr["email"];
          $_SESSION["nickname"] = $arr["nickname"];
          //假如用户有头像，页创建session保存
          $responseArr["data"] = array(
          	  "id" =>$arr['id'],
              "email" =>$arr["email"],
              "nickname" => $arr["nickname"],
              "password" =>$arr["password"]
          );
        }else{
          //提示邮件不对
        $responseArr["code"] = 20001;
        $responseArr["msg"] = "密码错误";
        }

      }else{
        //提示邮件不对
        $responseArr["code"] = 20004;
        $responseArr["msg"] = "邮件不存在";
      }
      //关闭数据库连接
    mysqli_close($conn);
    //将数组转换成json发送前端
    die(json_encode($responseArr));
    break;
    //发表评论，数据库添加数据
    case 'add_shuju' :
     $user_id = $_REQUEST["user_id"];
     $content =$_REQUEST["content"];
     $sql = "insert into comment(user_id,content,publish_time) values('{$user_id}','{$content}',now()) ";
     $result = mysqli_query($conn,$sql);
     if($result){
        $responseArr['code'] = 200;
        $responseArr["data"] =array(
              "user_id" =>  $user_id,
              "content" =>  $content,
              

        );

     }else{
       $responseArr["code"] =201;
       $responseArr["msg"] = "操作不成功";
     }
     //关闭数据
     mysqli_close($conn);
     die(json_encode($responseArr));
     break;
   
  



}

?>