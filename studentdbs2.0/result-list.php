<?php include("head.php"); 	
	  include("conn.php");
    header("content-type:text/html;charset=utf-8");
    ?>
		<div class="sui-layout">
		  <div class="sidebar">
<?php  include("leftmenu.php");?>	  	
		  </div>
		  <div class="content">
			<p class="sui-text-xxlarge my-padd">成绩列表</p>
			<table class="sui-table table-primary">
				<tr>
					<th>序号</th>
					<th>学号号</th>
					<th>课程编号</th>
					<th>成绩</th>
					<th>操作</th>
				</tr>
				<!-- <tr>
					<td>1</td>
					<td>B01</td>
					<td>HTML+CSS基础</td>
					<td><a class="sui-btn btn-small btn-warning">编辑</a>&nbsp;<a class="sui-btn btn-small btn-danger">修改</a></td>
				</tr> -->
<?php 
	$sql = "select 学号,课程号,成绩 from 成绩";
	
	$result = mysqli_query($conn,$sql);
	if( mysqli_num_rows($result)>0){
	while($a = mysqli_fetch_assoc($result)){
	$arrClass[] = $a;

	}
}
// print_r($arrClass);
	/*
	array(
		0 = array(
			"课程编号" => "B01",
			"课程名" => "HTML+css基础"
		),

	)
	 */
	//根据结果生成表格页面
	foreach ($arrClass as $key => $value){
		echo "<tr><td>".($key+1)."</td><td>{$value['学号']}</td><td>{$value['课程号']}</td><td>{$value['成绩']}<td><a class='sui-btn btn-small btn-warning'>编辑</a>&nbsp;<a class='sui-btn btn-small btn-danger'>修改</a></td></tr>";
	}


	?>

			</table>
		  </div>
		</div>		
	</div>
<?php
include("foot.php");
?>