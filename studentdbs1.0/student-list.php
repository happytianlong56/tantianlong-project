<?php include("head.php"); 	
	  include("conn.php");
	  include("func.php");
	  $pagenum = empty($_REQUEST['pagenum'])?1:$_REQUEST['pagenum'];
	  $pagesize = empty($_REQUEST['pagesize'])?5:$_REQUEST['pagesize'];

    ?>
		<div class="sui-layout">
		  <div class="sidebar">
<?php  include("leftmenu.php");?>	  	
		  </div>
		  <div class="content">
			<p class="sui-text-xxlarge my-padd">学生列表</p>
			<table class="sui-table table-primary">
				<tr>
					<th>序号</th>
					<th>学号</th>
					<th>班号</th>
					<th>性别</th>
					<th>出生日期</th>
					<th>手机号</th>
					<th>照片</th>
					<th>姓名</th>
					<th>操作</th>
				</tr>
				<!-- <tr>
					<td>1</td>
					<td>B01</td>
					<td>HTML+CSS基础</td>
					<td><a class="sui-btn btn-small btn-warning">编辑</a>&nbsp;<a class="sui-btn btn-small btn-danger">修改</a></td>
				</tr> -->
<?php 
// 	$pagesize = 5;//每页显示5条
// 	$sql = "select 学号,班号,性别,出生日期,手机号,姓名,照片 from 学生 limit ".($pagenum-1)*$pagesize.",".$pagesize ;
// 	// die($sql);
// 	$result = mysqli_query($conn,$sql);
// 	if( mysqli_num_rows($result)>0){
// 	while($a = mysqli_fetch_assoc($result)){
// 	$arrClass[] = $a;

// 	}
// }
// print_r($arrClass);
	/*
	array(
		0 = array(
			"课程编号" => "B01",
			"课程名" => "HTML+css基础"
		),

	)
	 */
	  $pageAmount = ceil(allList("学生")/$pagesize) ;//最大页数=ceil(总页数/每页条数)

	 $arrClass = pageList($pagenum,$pagesize,"学生");
	//根据结果生成表格页面
	foreach ($arrClass as $key => $value){
		echo "<tr><td>".($key+1)."</td><td>{$value['学号']}</td><td>{$value['班号']}</td>";
		// <td>{$value['性别']}</td>
		if( $value['性别'] == 0 ){
			echo "<td>女</td>";
		}else{
			echo "<td>男</td>";
		}
		echo "<td>{$value['出生日期']}</td><td>{$value['手机号']}</td><td>{$value['照片']}</td><td>
		{$value['姓名']}</td><td><a href='student-edit.php?kid={$value['学号']}' class='sui-btn btn-small btn-warning'>编辑</a>&nbsp;
		<a href='student-del.php?kid={$value['学号']}' class='sui-btn btn-small btn-danger'>删除</a></td></tr>";
	}


	?>

			</table>
			<p>总计：条&nbsp;
			 <a href="?pagenum=1">首页</a>&nbsp;
			 <a href="?pagenum=<?php echo $pagenum-1?>">上一页</a>&nbsp;
			 <?php
			 	for ($i=1; $i <= $pageAmount; $i++) { 
			 		echo "<a href='?pagenum={$i}'>{$i}</a>&nbsp";
			 	}
			 ?>
			 <a href="?pagenum=<?php echo ($pagenum+1>$pageAmount)?$pageAmount:$pagenum+1?>">下一页</a> 
			 <a href="?pagenum=<?php echo $pageAmount;?>">尾页</a>
			</p>
		  </div>
		</div>		
	</div>
<?php
include("foot.php");
?>