<?php include("head.php"); 	
    header("content-type:text/html;charset=utf-8");
    $kid = empty($_GET['kid'])?"null":$_GET["kid"];
    if($kid == "null"){
    	die("请选择要修改的记录");
    }else{
    	include("conn.php");
    	$sql = "select 班号,教室,班主任,班长 from 班级 where 班号 = '{$kid}'";
    	
    	$result = mysqli_query($conn,$sql);
    	//判断有没记录
    	if(mysqli_num_rows($result)>0){
    		$arrClass = mysqli_fetch_assoc($result);
    	}else{
    		echo "<script>alert('暂无记录!');</script>";
    		header("Refresh:1;url=kecheng-list.php");
    	}
    	
    	mysqli_close($conn);
    }
    ?>
		<div class="sui-layout">
		  <div class="sidebar">
<?php  include("leftmenu.php");?>	  	
		  </div>
		  <div class="content">
			<p class="sui-text-xxlarge my-padd">班级修改</p>
			<form class="sui-form form-horizontal sui-validate" method="get" action="class-update.php">
				<div class="control-group">
			    <label for="inputEmail" class="control-label">班号：</label>
			    <div class="controls">
			      <input type="text" name="class_name" value="<?php echo $arrClass['班号'];?>"  class="input-large input-fat" placeholder="输入教室" data-rules="required|minlength=2|maxlength=15">
			    </div>
			  </div>
			  <div class="control-group">
			    <label for="inputEmail" class="control-label">教室：</label>
			    <div class="controls">
			      <input type="text" name="class_position" value="<?php echo $arrClass['教室'];?>"  class="input-large input-fat" placeholder="输入教室" data-rules="required|minlength=2|maxlength=15">
			    </div>
			  </div>
			  <div class="control-group">
			    <label for="inputEmail" class="control-label">班主任：</label>
			    <div class="controls">
			      <input type="text" name="teacher" value="<?php echo $arrClass['班主任'];?> "  class="input-large input-fat"   placeholder="输入班主任">
			    </div>
			  </div>
			  <div class="control-group">
			    <label for="inputEmail" class="control-label">班长：</label>
			    <div class="controls">
			      <input type="text" name="monitor" value="<?php echo $arrClass['班长'];?> "  class="input-large input-fat"   placeholder="输入课程编号">
			    </div>
			  </div>	
			  <div class="control-group">
			  	<label class="control-label"></label>
			  	<div class="controls">
			  		<input type="submit" value="修改" name="" class="sui-btn btn-large btn-primary">
			  	</div>
			  </div>	  
			</form>
		  </div>
		</div>		
	</div>
<?php
include("foot.php");
?>