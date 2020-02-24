<?php include("head.php"); 	
	  include("conn.php");
    header("content-type:text/html;charset=utf-8");
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
				<tbody id="xueshenglist"></tbody>
			</table>
			
			<div id="test" class="sui-pagination pagination-small">
				<ul>
				<li class="prev disabled"><a href=" ">«上一页</a></li>
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li class="dotted"><span>...</span></li>
				<li class="next"><a href="#">下一页»</a></li>
				</ul>
				<div><span>共10页&nbsp;</span><span>
				到
				<input type="text" class="page-num"><button class="page-confirm" onclick="alert(1)">确定</button>
				页</span></div>
				</div>
		  </div>
		</div>		
	</div>
<?php
include("foot.php");
?>
<script>


window.onload = function(){
	$.ajax({
		url:"api3.php?action=xuesheng",
		type:"get",
		data:{
			pagenum:1,
			pagesize:5
		},
		dataType:"json",
		beforeSend:function(){
			$("#xueshenglist").html("<tr><td>正在查询请稍后...</td></tr>");
		},
	success:function(data,textStatus){
		
		renderData(data);
		//渲染分页条
		$('#test').pagination({
			pageSize:5,//每页显示条数
			itemsCount:data.allnum,//获取记录总条数
			styleClass: ['pagination-large'],  //默认的css样式
			showCtrl: true,	//是否展示总页数和跳转控制器，默认为false
			onSelect: function(num){
				console.log("我是"+ num ); //打开控制台观察
				$.ajax({
					url:"api3.php?action=xuesheng",
					type:"get",
					beforeSend:function(){
						$("#xueshenglist").html("<tr><td>正在查询请稍后...</td></tr>");
					},
					dataType:"json",
					data:{
						pagenum:num,
						pageSize:5
					},
					success:function(data,textStatus){
						console.log(data.data);
						if(data.code==200){
							renderData(data);
						}else{
							alert("网络故障");
						}
					}
				});
			}      
		});
	} ,
	error:function(XMLHttpRequest,textStatus,errorThrown){
		$("#xueshenglist").html("<tr><td>网络故障，请刷新一次</td></tr>");
	}    


	})
}

function renderData(data){
		// console.log(data);
	  var str = "";
	  $.each(data.data,function(key,value){
	  	str += "<tr><td>"+(key+1)+"</td>;"
	  		console.log(data);
	  	$.each(value,function(i,item){
	  		if(item == 0){
	  			str+="<td>女</td>";
	  		}else if(item == 1){
	  			str+="<td>男</td>";
	  		}else{

	  		str += "<td>"+item+"</td>";
	  		}
	  	})
	  	str+="<td><a class='sui-btn btn-samll btn-warning' href='student-edit.php?kid="+value.学号+"'>修改</a>&nbsp;&nbsp;<a class='sui-btn btn-samll btn-danger' href='api5.php?action=student_del&kid="+value.学号+"'>删除</a></td>";
	  	str += "</tr>";
   

	  })
	$("#xueshenglist").html(str);
}

</script>