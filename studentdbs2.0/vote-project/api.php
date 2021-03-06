<?php
include("conn.php");
// include("func.php");
session_start();

header("Access-Control-Allow-Origin:*");
$action = $_REQUEST['action'];
//先构造一个基本的code-data-message结构的关联数组 
 $responseArr = array(
    "code"=> 200,
    "msg" =>"数据获取成功",
    "data" =>null
 );
 switch($action){
   //登录验证
    case "login":
      $email = $_REQUEST["email"];
      $password = $_REQUEST["password"];
      //首先根据用户的email查是否至少一条记录
      $sql = "select email,nickname,password from user where email='{$email}'";
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
              "email" =>$arr["email"],
              "nickname" => $arr["nickname"]

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
    
    case "candidatelist":
    //获取私密问题接口
    $sql = "select id,name,position,votenum from vote";
    $result = mysqli_query($conn,$sql);//查询结果记录集
    if(mysqli_num_rows($result)>0){
      $arr = array();
      while($a = mysqli_fetch_assoc($result)){
        $arr[] = $a;//将所有的记录集转为二维关联数组

      }
      $responseArr["data"] = $arr;
    }else{
      $responseArr["code"] = 207;
      $responseArr["msg"] = "暂无记录";
    }
    //关闭数据库连接
    mysqli_close($conn);
    //将数组转换成json发送前端
    die(json_encode($responseArr));
    break;

    //打开投票页面需要请求的数据
    case "candidate" :
    $sql = "select id,name,position,pic,votenum,status from vote";
    $result = mysqli_query($conn,$sql);//查询结果记录集
    if(mysqli_num_rows($result)>0){
      $arr = array();
      while($a = mysqli_fetch_assoc($result)){
        $arr[] = $a;//将所有的记录集转为二维关联数组
      }
      $responseArr["data"] = $arr;
    }else{
      $responseArr["code"] = 207;
      $responseArr["msg"] = "暂无记录";
    }
    //关闭数据库连接
    mysqli_close($conn);
    //将数组转换成json发送前端
    die(json_encode($responseArr));
    break;

    //投票，修改votenum中的数据
    case "toupiao" :
      $votenum = $_REQUEST["votenum"];
      $id = $_REQUEST["id"];
      $voter = $_REQUEST["voter"];
      $sql = "update  `vote` SET `votenum`= '{$votenum}' ,`voter` = '{$voter}' WHERE id= {$id} ";
      // die($sql);
      $result = mysqli_query($conn,$sql);
      if($result){
        $responseArr["data"] = $votenum;
      }else{
        $responseArr["code"] = 201;
        $responseArr["msg"] = "添加失败";
      }
      //关闭数据库
      mysqli_close($conn);
      //将数组转换成json发送到前端
      die(json_encode($responseArr));

      break;
      //判断是否点赞过
      case "is_zan":
      $id = $_REQUEST["id"];
      $voter = $_REQUEST["voter"];
      $sql = "select * from  vote where id = {$id} and voter ='{$voter}' ";
      // die($sql);
      $result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($result)>0){
          $responseArr["code"] = 201;
          $responseArr["msg"] = "同一个候选人只能投票一次";

      }else{
         $responseArr["code"] = 200;
         $responseArr["msg"] = " 可以投票";
         
      }
      //关闭数据库
      mysqli_close($conn);
      //将数组转换成json发送到前端
      die(json_encode($responseArr));

      break;
      //显示候选人姓名、职务、简历等信息接口
      case "xinxi":
      $id = $_REQUEST["id"];
      $sql = "select * from vote where id ='{$id}'";
      $result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($result)>0){
        $arr = mysqli_fetch_assoc($result);
        $responseArr["data"] = $arr;
      }
      //关闭数据库
      mysqli_close($conn);
      //将数组转换成json发送到前端
      die(json_encode($responseArr));
      break;



  }

    
?>

<?php
?>