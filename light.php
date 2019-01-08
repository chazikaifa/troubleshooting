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
			var b_POW,b_PON,b_LOS,b_LAN;
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
			function change_light(obj){
				switch(parseInt(obj.attr("stat"))){
					case 0:
						obj.attr("stat","1");
						obj.attr("src",light_green);
						break;
					case 1:
						obj.attr("stat","2");
						obj.attr("src",light_red);
						break;
					case 2:
						obj.attr("stat","3");
						var intervalID = setInterval(function(){
							blink(light_gray,light_green,obj);
						},200); 
						obj.attr("intervalID",intervalID);
						break;
					case 3:
						obj.attr("stat","4");
						window.clearInterval(obj.attr("intervalID"));
						var intervalID = setInterval(function(){
							blink(light_gray,light_red,obj);
						},200);
						obj.attr("intervalID",intervalID);
						break;
					case 4:
						obj.attr("stat","0");
						obj.attr("src",light_gray);
						window.clearInterval(obj.attr("intervalID"));
						break;
					default:
						break;
				}
			}
			
			$(".light").click(function(){
				change_light($(this));
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
			margin-top: 15vh;
			margin-bottom: 5vh;
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
			border-radius:2vw;
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
	<p id="tips">
		注：点击指示灯改变状态。<br/><br/>
		实际光猫不止一个LAN口，请以接入网线的端口为准
	</p>
	
	<div id="submit">
		确认
	</div>
</body>
</html>