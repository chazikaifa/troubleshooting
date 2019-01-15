<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//返回按钮
			$("#back").click(function(){
				//window.location.replace("index.php");
				console.log("back");
			});
			$("#back_text").click(function(){
				//window.location.replace("index.php");
				console.log("back");
			});
			
			//光猫类
			function modem(id,name,des)
			{
				this.id = id;
				this.name = name;
				this.des = des;
			}
			
			var json_url = "./assets/modem_list.json";
			//从JSON文件读取光猫列表
			var modem_list = new Array();
			$.getJSON(json_url,function(data,stat){
				if(stat == "success"){
					for(var i=0;i<data.length;i++){
						modem_list[i] = new modem(data[i]["id"],data[i]["name"],data[i]["des"]);
					}
					
					//获取模板的克隆并删除模板
					var templet = $("#templet").clone();
					var parent = $("#modem_list");
					$("#templet").remove();
					$.each(modem_list,function(index,item){
						var list_item = templet.clone();
						var hit_box = list_item.find(".list_item");
						
						//id小于0的为不需要跳转的项目，令背景为灰色且不加触摸与点击事件
						if(item.id >= 0){
							//鼠标反馈
							// hit_box.mousedown(function(){
								// hit_box.css("background","#E0E0E0");
							// });
							// hit_box.mouseup(function(){
								// hit_box.css("background","#FFFFFF");
							// });
							// hit_box.mouseout(function(){
								// hit_box.css("background","#FFFFFF");
							// });
							hit_box.click(function(){
								var str="?id="+item.id;
								window.location.replace("light.php"+str);
							});
							
							//触屏反馈
							hit_box.on("touchstart",function(){
								hit_box.css("background","#E0E0E0");
							});
							hit_box.on("touchend",function(){
								hit_box.css("background","#FFFFFF");
							});
							hit_box.on("touchcancel",function(){
								hit_box.css("background","#FFFFFF");
							});

						}else{
							hit_box.css("background","#E0E0E0");
						}
						list_item.attr("id",item.id)
						list_item.find(".name").html(item.name);
						list_item.find(".des").html(item.des);
						parent.append(list_item);
					});
				}else{
					alert("光猫列表获取失败！")
				}
			});
		});
	</script>
	<style type="text/css">
	body
	{
		background: #EAEAEA;
		width: 100vw;
		height: 100vh;
		display:contents;
		margin: 0;
		padding: 0;
	}
	#back
	{
		width: 10vw;
		height: 5vh;
		position: absolute;
	}
	#back > img
	{
		width: 4vh;
		height: 4vh;
		padding: 0.5vh;
	}
	#back_text
	{
		font-size: 1.8vh;
		width: 20vw;
		height: 5vh;
		color: white;
		line-height: 5vh;
		position: absolute;
		left: 5.5vh;
	}
	.title
	{
		font-size: 1.8vh;
		text-align: center;
		width: 100vw;
		height: 5vh;
		background: #ED6D00;
		color: white;
		line-height: 5vh;
	}
	ul
	{
		margin:0;
		padding: 0;
		height: 95vh;
		overflow:auto;
	}
	li
	{
		list-style: none;
	}
	.list_item
	{
		width: 92vw;
		height:10vh;
		margin:4vw;
		background:white;
		border-radius:1.5vh;
	}
	.list_item > .name
	{
		height: 3.2vh;
		width: 82vw;
		line-height: 4vh;
		margin-left: 5vw;
		margin-right: 5vw;
		font-size: 3.8vw;
		color: #777777;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.list_item > hr
	{
		margin-top: 0;
		margin-bottom: 0;
		margin-left: 4vw;
		margin-right: 4vw;
		border: 0;
		height: 0.1vh;
		background-image: linear-gradient(to right, rgba(200, 200, 200, 0.5), rgba(0, 0, 0, 0.75), rgba(200, 200, 200, 0.5));
	}
	.list_item > .des
	{
		width:82vw;
		height:5.2vh;
		font-size: 3vw;
		color: #AAAAAA;
		line-height: 2.5vh;
		margin-top: 0.3vh;
		margin-bottom: 0.3vh;
		margin-left: 5vw;
		margin-right: 5vw;
		overflow: hidden;
	}
	</style>
</head>
<body>
	<div id="back">
		<img src="images/back.png" />
	</div>
	<div id="back_text">
		返回
	</div>
	<div class="title">
		请选择光猫型号
	</div> 
	
	<ul id="modem_list">
		<li id="templet">
			<div class="list_item">
				<div class="name">
					光猫型号
				</div>
				<hr/>
				<div class="des">
					光猫描述
				</div>
			</div>
		</li>
		
	</ul>
</body>
</html>