window.onload = function(){
	/*左侧菜单栏滑动*/
	leftWiper();
	rightWiper();
	iScrollLeftWiper();
	iScrollRightWiper();
}

var iScrollLeftWiper = function(){
	
}
var iScrollRightWiper = function(){
	
}

var leftWiper = function(){
	var cate_left = document.querySelector(".cate_left ul");
	var lis = cate_left.querySelectorAll("li");
	
	var currentY = 0,//当前定位 
		startY = 0, //初始定位
		distantY = 0;//Y轴移动距离
		
	cate_left.addEventListener("touchstart", function(e){
		startY = e.touches[0].clientY;
	});
	
	/*给容器绑定事件*/
	cate_left.addEventListener("touchmove", function(e){
		/*向↓为Y轴正方向，向→为X轴正方向*/
		distantY = e.touches[0].clientY - startY;
		console.log(distantY)
		//位移距离，上一次的位置 + 当前移动的距离
		var translateY = currentY + distantY;
		cate_left.style.transform = "translateY("+translateY+"px)";
		cate_left.style.webkitTransform = "translateY("+translateY+"px)";
	});
	cate_left.addEventListener("touchend", function(e){
		//移动结束之后，重新记录当前位移， 当前位置 = 上一次的位置 + 移动的距离
		currentY = currentY + distantY;
	});
}

var rightWiper = function(){
	var cate_right = document.querySelector(".combo_box");
	
	var currentY = 0,//当前定位 
		startY = 0, //初始定位
		distantY = 0;//Y轴移动距离
		
	cate_right.addEventListener("touchstart", function(e){
		startY = e.touches[0].clientY;
	});
	
	/*给容器绑定事件*/
	cate_right.addEventListener("touchmove", function(e){
		/*向↓为Y轴正方向，向→为X轴正方向*/
		distantY = e.touches[0].clientY - startY;
		console.log(distantY)
		//位移距离，上一次的位置 + 当前移动的距离
		var translateY = currentY + distantY;
		cate_right.style.transform = "translateY("+translateY+"px)";
		cate_right.style.webkitTransform = "translateY("+translateY+"px)";
	});
	cate_right.addEventListener("touchend", function(e){
		//移动结束之后，重新记录当前位移 = 上一次的当前位移 + 移动的距离
		currentY = currentY + distantY;
	});
}