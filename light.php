<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/selectordie.css" media="all" />
	<script type="text/javascript" src="scripts/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="scripts/selectordie.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var light_gray="images/circle_gray.png";
			var light_green="images/circle_green.png";
			var light_red="images/circle_red.png";
			
			//返回按钮
			$("#back").click(function(){
				window.location.replace("index.php");
			});
			$("#back_text").click(function(){
				window.location.replace("index.php");
			});
			//确定按钮
			$("#submit").click(function(){
				var str = "?POW="+$("#POW").attr("stat")+
						"&PON="+$("#PON").attr("stat")+
						"&LOS="+$("#LOS").attr("stat")+
						"&LAN="+$("#LAN").attr("stat");
				window.location.replace("result.php"+str);
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
				var label;
				label = $(".content").children("."+obj.attr("id"));
				switch(obj.attr("stat")){
					case "0":
						obj.attr("src",light_gray);
						window.clearInterval(obj.attr("intervalID"));
						//label.html("灭");
						break;
					case "1":
						obj.attr("src",light_green);
						window.clearInterval(obj.attr("intervalID"));
						//label.html("亮");
						break;
					case "2":
						obj.attr("src",light_red);
						window.clearInterval(obj.attr("intervalID"));
						//label.html("亮");
						break;
					case "3":
						window.clearInterval(obj.attr("intervalID"));
						var intervalID = setInterval(function(){
							blink(light_gray,light_green,obj);
						},200); 
						obj.attr("intervalID",intervalID);
						//label.html("闪");
						break;
					case "4":
						window.clearInterval(obj.attr("intervalID"));
						var intervalID = setInterval(function(){
							blink(light_gray,light_red,obj);
						},200); 
						obj.attr("intervalID",intervalID);
						//label.html("闪");
						break;
				}
			}
			
			// //点击灯的点击事件
			// function change_light(obj){
				// switch(parseInt(obj.attr("stat"))){
					// case 0:
						// obj.attr("stat","1");
						// set_light(obj);
						// break;
					// case 1:
						// obj.attr("stat","3");
						// set_light(obj);
						// break;
					// case 2:
						// break;
					// case 3:
						// obj.attr("stat","0");
						// set_light(obj);
						// break;
					// case 4:
						// break;
				// }
				
			// }
			
			// //点击表格的点击事件
			// function light_select(obj){
				// var type = obj.attr("class").split(" ")[1];
				// var light = $("#"+type);
				// var stat = obj.parent().attr("id");
				// switch(stat){
					// case "on":
						// light.attr("stat","1");
						// break;
					// case "flash":
						// light.attr("stat","3");
						// break;
					// case "off":
						// light.attr("stat","0")
						// break;
				// }
				// set_light(light);
			// }
			
			// $(".light").click(function(){
				// change_light($(this));
			// });
			
			// $(".check").click(function(){
				// light_select($(this));
			// });
			
			//下拉菜单选择事件
			function select_light(obj){
				var op = obj.val();
				var type = obj.parents(".check").attr("class").split(" ")[1];
				var light = $("#"+type);
				switch(op){
					case "on":
						light.attr("stat","1");
						break;
					case "flash":
						light.attr("stat","3");
						break;
					case "off":
						light.attr("stat","0");
						break;
				}
				set_light(light);
			}
			
			$("select").val("off");
			$("select").selectOrDie();
			$("select").change(function(){
				select_light($(this));
			});
		});
	</script>
	<style type="text/css">
		body 
		{
			background: #EAEAEA;
			width: 100vw;
			height: 100vh;
			margin: 0;
			padding: 0;
			display:contents;
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
		#modem
		{
			width: 90vw;
			height: 30vh;
			background:white;
			margin-left: 5vw;
			margin-right: 5vw;
			margin-top: 13vh;
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
			border-radius:1.8vh;
			overflow: hidden;
		}
		.form
		{
			width:90vw;
			margin-left:5vw;
			margin-right5vw;
			font-size: 2vh;
			text-align: center;
			table-layout: fixed;
		}
		.form .label
		{
			background: #ED6D00;
			color: white;
			height: 4vh;
		}
		.form .content
		{
			background: white;
			color: #000000;
			height: 4vh;
		}
		#tips
		{
			font-size:1.7vh;
			width:100vw;
			text-align: center;
			color: #777777;
		}
		#submit
		{
			font-size:2.2vh;
			margin-left:5vw;
			margin-right:5vw;
			margin-top:10vh;
			width:90vw;
			height:5vh;
			line-height:5vh;
			text-align:center;
			background:#ED6D00;
			color: white;
			border-radius:1.3vh;
		}
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
		手动选择光猫指示灯
	</div> 
	
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
	
	<table class="form">
		<tr class="label">
			<td>Power</td>
			<td>PON</td>
			<td>LOS</td>
			<td>LAN</td>
		</tr>
		<tr class="content">
			<td class="check POW">
				<select>
					<option value="on">亮</option>
					<option value="off">灭</option>
				</select>
			</td>
			<td class="check PON">
				<select>
					<option value="on">亮</option>
					<option value="flash">闪</option>
					<option value="off">灭</option>
				</select>
			</td>
			<td class="check LOS">
				<select>
					<option value="on">亮</option>
					<option value="flash">闪</option>
					<option value="off">灭</option>
				</select>
			</td>
			<td class="check LAN">
				<select>
					<option value="on">亮</option>
					<option value="flash">闪</option>
					<option value="off">灭</option>
				</select>
			</td>
		</tr>
	</table>
	
	<!--<p id="tips">
		注：点击指示灯也可以改变状态。<br>
		
		
		状态有：灭、亮绿灯、亮红灯、闪绿灯、闪红灯五种<br/><br/>
		实际光猫不止一个LAN口，请以接入网线的端口为准
	</p>-->
	<div id="submit">
		确认
	</div>

</body>
</html>