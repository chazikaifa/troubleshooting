<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var light_gray="images/circle_gray.png";
			var light_green="images/circle_green.png";
			var light_red="images/circle_red.png";
			
			//获取参数
			function GetQueryString(name)
			{
				var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
				var r = window.location.search.substr(1).match(reg);
				if(r!=null)return  unescape(r[2]); return null;
			}
			
			var id = GetQueryString("id");
			
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
					
					$.each(modem_list,function(index,item){
						if(item.id == id){
							$("#name").html("<b>"+item.name+"</b>");
						}
					});
				}else{
					//GET参数正常时不会出现
					$("#name").html("<b>未知光猫</b>");
				}
			});
			
			//返回按钮
			$("#back").click(function(){
				history.back(-1);
			});
			$("#back_text").click(function(){
				history.back(-1);
			});
			//确定按钮
			$(".submit").click(function(){
				var str = "?POW="+$("#POW").attr("stat")+
						"&PON="+$("#PON").attr("stat")+
						"&LOS="+$("#LOS").attr("stat")+
						"&LAN="+$("#LAN").attr("stat");
				window.location.href = "result.php"+str;
			});
			
			//触摸反馈
			$(".submit").on("touchstart",function(){
				$(".submit").attr("class","submit pressed");
			});
			$(".submit").on("touchend",function(){
				$(".submit").attr("class","submit");
			});
			$(".submit").on("touchcancel",function(){
				$(".submit").attr("class","submit");
			});
			
			//定义定时器,控制灯闪烁
			function blink(img1,img2,obj){
				if(obj.attr("src")==img1){
					obj.attr("src",img2);
				}else{
					obj.attr("src",img1);
				}
			}
			
			//灯有几种状态
			//0：灭
			//1: 绿灯亮
			//2：红灯亮
			//3：绿灯闪
			//4：红灯闪
			function set_light(obj){
				var label_on,label_flash,label_off;
				label_on = $("#on").children("."+obj.attr("id"));
				label_flash = $("#flash").children("."+obj.attr("id"));
				label_off = $("#off").children("."+obj.attr("id"));
				switch(obj.attr("stat")){
					case "0":
						obj.attr("src",light_gray);
						window.clearInterval(obj.attr("intervalID"));
						label_on.children("img").attr("class","noSelect");
						label_flash.children("img").attr("class","noSelect");
						label_off.children("img").attr("class","select");
						break;
					case "1":
						obj.attr("src",light_green);
						window.clearInterval(obj.attr("intervalID"));
						label_on.children("img").attr("class","select");
						label_flash.children("img").attr("class","noSelect");
						label_off.children("img").attr("class","noSelect");
						break;
					case "2":
						obj.attr("src",light_red);
						window.clearInterval(obj.attr("intervalID"));
						label_on.children("img").attr("class","select");
						label_flash.children("img").attr("class","noSelect");
						label_off.children("img").attr("class","noSelect");
						break;
					case "3":
						window.clearInterval(obj.attr("intervalID"));
						var intervalID = setInterval(function(){
							blink(light_gray,light_green,obj);
						},200); 
						obj.attr("intervalID",intervalID);
						label_on.children("img").attr("class","noSelect");
						label_flash.children("img").attr("class","select");
						label_off.children("img").attr("class","noSelect");
						break;
					case "4":
						window.clearInterval(obj.attr("intervalID"));
						var intervalID = setInterval(function(){
							blink(light_gray,light_red,obj);
						},200); 
						obj.attr("intervalID",intervalID);
						label_on.children("img").attr("class","noSelect");
						label_flash.children("img").attr("class","select");
						label_off.children("img").attr("class","noSelect");
						break;
				}
			}
			
			//点击灯的点击事件
			function change_light(obj){
				switch(parseInt(obj.attr("stat"))){
					case 0:
						if(obj.attr("id")=="LOS"){
							obj.attr("stat","2");
						}else{
							obj.attr("stat","1");
						}
						
						set_light(obj);
						break;
					case 1:
						if(obj.attr("id")=="LOS"){
							obj.attr("stat","4");
						}else{
							obj.attr("stat","3");
						}
						set_light(obj);
						break;
					case 2:
						if(obj.attr("id")=="LOS"){
							obj.attr("stat","4");
						}else{
							obj.attr("stat","3");
						}
						set_light(obj);
						break;
					case 3:
						obj.attr("stat","0");
						set_light(obj);
						break;
					case 4:
						obj.attr("stat","0");
						set_light(obj);
						break;
				}
				
			}
			
			//点击表格的点击事件
			function light_select(obj){
				if(obj.children("img").attr("class")!="select"){
					var type = obj.attr("class").split(" ")[1];
					var light = $("#"+type);
					var stat = obj.parent().attr("id");
					switch(stat){
						case "on":
							if(light.attr("id")=="LOS"){
								light.attr("stat","2");
							}else{
								light.attr("stat","1");
							}
							break;
						case "flash":
							if(light.attr("id")=="LOS"){
								light.attr("stat","4");
							}else{
								light.attr("stat","3");
							}
							break;
						case "off":
							light.attr("stat","0")
							break;
					}
					set_light(light);
				}
			}
			
			$(".light").click(function(){
				change_light($(this));
			});
			
			$(".check").click(function(){
				light_select($(this));
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
		#name
		{
			height:8vh;
			line-height:14vh;
			font-size:3vh;
			width:100vw;
			text-align: center;
			color: #ED6D00;
		}
		#modem
		{
			width: 90vw;
			height: 30vh;
			background:white;
			margin-left: 5vw;
			margin-right: 5vw;
			margin-top: 0;
			margin-bottom: 7vh;
			border-radius:5vh;
			box-shadow: 2vh 2vh 1vh #888888;
			position:relative;
		}
		#modem > #logo
		{
			position:absolute;
			width:10vh;
			height:6vh;
			bottom: 7vh;
			right: 1vh;
		}
		#modem > #wo
		{
			position:absolute;
			width:10vh;
			height:5.6vh;
			top: 50%;
			left: 50%;
			margin-top: -2.8vh;
			margin-left:-5vh;
		}
		#modem > .light_label
		{
			position:absolute;
			width: 5vw;
			height: 7vh;
			bottom: 0;
			color: #AAAAAA;
			font-size:1vh;
		}
		#modem > .light
		{
			position:absolute;
			width:2.5vh;
			height:2.5vh;
			bottom: 2vh;
		}
		#modem > #POW_label
		{
			left:15%;
		}
		#modem > #PON_label 
		{
			left:30%;
		}
		#modem > #LOS_label 
		{
			left:45%;
		}
		#modem > #LAN_label 
		{
			left:70%;
		}
		#modem > #POW
		{
			left: 16%;
		}
		#modem > #PON
		{
			left: 30.6%;
		}
		#modem > #LOS
		{
			left: 45.1%;
		}
		#modem > #LAN
		{
			left: 70.3%;
		}
		#box
		{
			border-radius:2vh;
			width:90vw;
			margin-left:5vw;
			margin-right:5vw;
			overflow: hidden;
		}
		#form
		{
			font-size: 2vh;
			width:90vw;
			text-align: center;
			table-layout: fixed;
		}
		#form .label
		{
			background: #ED6D00;
			color: white;
			height: 6vh;
		}
		#form .content
		{
			background: white;
			color: #000000;
			height: 6vh;
		}
		#form .check > img
		{
			width: 3vh;
			height: 3vh;
			margin-top:0.5vh;
		}
		#form .noSelect
		{
			display: none;
		}
		#form .select
		{
			display: inline;
		}
		#tips
		{
			font-size:1.7vh;
			width:100vw;
			text-align: center;
			color: #777777;
		}
		.submit
		{
			font-size:2.2vh;
			margin-left:5vw;
			margin-right:5vw;
			margin-top:6vh;
			width:90vw;
			height:5vh;
			line-height:5vh;
			text-align:center;
			background:#ED6D00;
			color: white;
			border-radius:1.3vh;
		}
		.pressed{
			background:#CB4B00;
			color: #AAAAAA;
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
		请选择光猫指示灯
	</div> 
	
	<p id="name">
		<b>光猫名称</b><br/>
		
	</p>
	
	<div id="modem">
		<img id="logo" src="images/logo.jpg" />
		<img id="wo" src="images/wo.jpg" />
		<div class="light_label" id="POW_label">
			Power
		</div>
		<div class="light_label" id="PON_label">
			PON
		</div>
		<div class="light_label" id="LOS_label">
			LOS
		</div>
		<div class="light_label" id="LAN_label">
			LAN
		</div>
		<img src="images/circle_gray.png" class="light" id="POW" stat="0"/>
		<img src="images/circle_gray.png" class="light" id="PON" stat="0"/>
		<img src="images/circle_gray.png" class="light" id="LOS" stat="0"/>
		<img src="images/circle_gray.png" class="light" id="LAN" stat="0"/>
	</div>
	
	<div id="box">
		<table id="form">
			<tr class="label">
				<td>&nbsp </td>
				<td>Power</td>
				<td>PON</td>
				<td>LOS</td>
				<td>LAN</td>
			</tr>
			<tr class="content" id="on">
				<td>亮</td>
				<td class="check POW"><img class="noSelect" src="images/check-circle.png"></td>
				<td class="check PON"><img class="noSelect" src="images/check-circle.png"></td>
				<td class="check LOS"><img class="noSelect" src="images/check-circle.png"></td>
				<td class="check LAN"><img class="noSelect" src="images/check-circle.png"></td>
			</tr>
			<tr class="content" id="flash">
				<td>闪</td>
				<td class="check POW"><img class="noSelect" src="images/check-circle.png"></td>
				<td class="check PON"><img class="noSelect" src="images/check-circle.png"></td>
				<td class="check LOS"><img class="noSelect" src="images/check-circle.png"></td>
				<td class="check LAN"><img class="noSelect" src="images/check-circle.png"></td>
			</tr>
			<tr class="content" id="off">
				<td>灭</td>
				<td class="check POW"><img class="select" src="images/check-circle.png"></td>
				<td class="check PON"><img class="select" src="images/check-circle.png"></td>
				<td class="check LOS"><img class="select" src="images/check-circle.png"></td>
				<td class="check LAN"><img class="select" src="images/check-circle.png"></td>
			</tr>
		</table>
	</div>
	<p id="tips">
		注：点击指示灯也可以改变状态。<br>
		
		<!--
		状态有：灭、亮绿灯、亮红灯、闪绿灯、闪红灯五种<br/><br/>
		实际光猫不止一个LAN口，请以接入网线的端口为准-->
	</p>
	<div class="submit">
		确认
	</div>
</body>
</html>