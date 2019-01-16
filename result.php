<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//返回按钮
			$("#back").click(function(){
				history.back(-1);
			});
			$("#back_text").click(function(){
				history.back(-1);
			});
			
			//获取参数
			function GetQueryString(name)
			{
				var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
				var r = window.location.search.substr(1).match(reg);
				if(r!=null)return  unescape(r[2]); return null;
			}
			
			var POW = GetQueryString("POW");
			var PON = GetQueryString("PON");
			var LOS = GetQueryString("LOS");
			var LAN = GetQueryString("LAN");
			
			//触摸反馈
			$(".button").on("touchstart",function(){
				$(this).attr("class","button pressed");
			});
			$(".button").on("touchend",function(){
				$(this).attr("class","button");
			});
			$(".button").on("touchcancel",function(){
				$(this).attr("class","button");
			});
			
			var json_url = "./assets/trouble.json";
			//从JSON文件读取故障类型组合
			$.getJSON(json_url,function(data,stat){
				if(stat == "success"){
					var flag = true;
					for(var i=0;i<data.length&&flag;i++){
						if(data[i]["POW"]==POW&&data[i]["PON"]==PON&&data[i]["LOS"]==LOS&&data[i]["LAN"]==LAN){
							flag = false;
							$("#reason").html(data[i]["reason"]);
							
							//初始为第一步，上一步应设定为不可用，并取消触摸事件
							$("#prev").attr("class","button pressed");
							$("#prev").unbind("touchstart");
							$("#prev").unbind("touchend");
							$("#prev").unbind("touchcancel");
							
							var solution = data[i]["solution"];
							$("#solution").attr("index",0);
							$("#solution").html(solution[0]);			
							
							$("#prev").click(function(){
								var index = parseInt($("#solution").attr("index"));
								console.log(index);
								if(index <= 0){
									console.log("index too small!");
								}else{
									$("#solution").attr("index",index-1);
									$("#solution").html(solution[index-1]);
									if(index-1 == 0){
										//若index-1后为0，即不能再上一步
										$("#prev").attr("class","button pressed");
										$("#prev").unbind("touchstart");
										$("#prev").unbind("touchend");
										$("#prev").unbind("touchcancel");
									}
									if(index == solution.length-1){
										//index等于solution长度-1则需要恢复“下一步”的触摸事件
										$("#next").attr("class","button");
										$("#next").on("touchstart",function(){
											$("#next").attr("class","button pressed");
										});
										$("#next").on("touchend",function(){
											$("#next").attr("class","button");
										});
										$("#next").on("touchcancel",function(){
											$("#next").attr("class","button");
										});
									}
								}
							});
							$("#next").click(function(){
								var index = parseInt($("#solution").attr("index"));
								console.log(index);
								if(index >= solution.length-1){
									console.log("index too large!");
								}else{
									$("#solution").attr("index",index+1);
									$("#solution").html(solution[index+1]);	
									if(index+1 == solution.length-1){
										//若index+1后等于solution的长度，即不能再"下一步"
										$("#next").attr("class","button pressed");
										$("#next").unbind("touchstart");
										$("#next").unbind("touchend");
										$("#next").unbind("touchcancel");
									}
									if(index == 0){
										//index等于0，则需要恢复“上一步”的触摸事件
										$("#prev").attr("class","button");
										$("#prev").on("touchstart",function(){
											$("#prev").attr("class","button pressed");
										});
										$("#prev").on("touchend",function(){
											$("#prev").attr("class","button");
										});
										$("#prev").on("touchcancel",function(){
											$("#prev").attr("class","button");
										});
									}
								}
							});
						}
					}
					if(flag){
						console.log("没有对应的组合类型");
					}
				}else{
					console.log("无法获取故障列表");
					//光猫故障情况获取失败
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
			width: 100vw;
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
		.container{
			width: 90vw;
			background:white;
			margin-left: 5vw;
			margin-right: 5vw;
			margin-top: 3vh;
			margin-bottom: 7vh;
			border-radius:2vh;
		}
		.reason{
			height: 20vh;
		}
		
		.container > .box_title{
			height:7vh;
			line-height:7vh;
			text-align:center;
			font-size:3vh;
			color: #777777;
		}
		.container > .content{
			margin:5vw;
			font-size:2vh;
			color: #333333;
		}
		hr
		{
			margin-top: 0;
			margin-bottom: 0;
			margin-left: 4vw;
			margin-right: 4vw;
			border: 0;
			height: 0.1vh;
			background-image: linear-gradient(to right, rgba(200, 200, 200, 0.5), rgba(0, 0, 0, 0.75), rgba(200, 200, 200, 0.5));
		}
		.solution{
			height: 40vh;
			position: relative;
			overflow: hidden;
		}
		#prev
		{
			position: absolute;
			bottom: 0;
			left: 0;
			width:44.9vw;
		}
		#next
		{
			position: absolute;
			bottom: 0;
			right: 0;
			width:44.9vw;
		}
		.button
		{
			display:inline-block;
			position: absolute;
			bottom:5vh;
			font-size:2.2vh;
			height:5vh;
			line-height:5vh;
			text-align:center;
			background:#ED6D00;
			color: white;
		}
		.pressed{
			background:#CB4B00;
			color: #AAAAAA;
		}
		#no_solve
		{
			width:42.5vw;
			left: 5vw;
			border-radius:1vh;
		}
		#solve
		{
			width:42.5vw;
			right: 5vw;
			border-radius:1vh;
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
		故障解决建议
	</div> 
	
	<div class="container reason">
		<div class="box_title">
			初步分析
		</div>
		<hr/>
		<div id="reason" class="content">
			
		</div>
	</div>
	
	<div class="container solution">
		<div class="box_title">
			解决建议
		</div>
		<hr/>
		<div id="solution" class="content">
		</div>
		<span id="prev" class="button">
			上一步
		</span>
		<span id="next" class="button">
			下一步
		</span>
	</div>
	
	<span id="no_solve" class="button">
		问题未解决
	</span>
	<span id="solve" class="button">
		问题完美解决！
	</span>
</body>
</html>