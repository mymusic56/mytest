
/**
 * 开发方法： 
 * 1. 先找出要实现的功能
 * 2. 每个功能实现的方法
 */
window.onload = function(){
	/*1. 搜索栏透明度渐变*/
	search();
	/*2. 轮播图*/
	banner();
	/*3. 倒计时*/
	downTime();
}


var search = function(){
	/*1. 初始化页面的时候，透明度为0*/
	/*2. 当页面滚动的时候，透明度值变大*/
	/*3. 当页面滚动距离高于banner的时候，透明度不再发生变化*/
	
	var search = document.querySelector(".search_box");
	var banner = document.querySelector(".banner");
	var height = banner.offsetHeight;
	window.onscroll = function(){
		//当前页面滚动的距离
		//var top = document.body.scrollTop;
		var top = document.documentElement.scrollTop;
		var opacity = 0;
		if (top > height) {
			opacity = 0.95;
		} else {
			opacity = 0.95*(top / height);
		}
		search.style.background = 'rgba(216,80,92, '+opacity+')';
	}
}

var banner = function(){
	/**
	 * 1. 无缝滚动&无缝滑动 （定时器 过渡 位移）
	 * 2. 点盒子对应改变	（改变样式）
	 * 3. 可以滑动		（touch事件，触摸点之间的距离，位移）
	 * 4. 当滑动距离不够的时候可以被吸附回去		（过渡 位移）
	 * 5. 当滑动距离够的时候，可以跳到上一张 或者 下一张	（判断方向， 过渡， 位移）
	 */
	
	//滑动
	//大容器
	var banner = document.querySelector('.banner');
	//轮播图宽度
	var bannerWidth = banner.offsetWidth;
	//获取图片容器
	var imageBox = document.querySelector(".banner ul:first-child");
	//图片数量
	var iamgeCounts = 8;
	//获取点容器
	var pointBox = document.querySelector(".banner ul:last-child");
	var points = pointBox.querySelectorAll("li");
	
	var index = 1;
	/**
	 * 提取公共方法
	 * 加过渡，清除过渡，位移
	 */
	var addTransition = function(){
		imageBox.style.transition = 'all 0.2s';
		imageBox.style.webkitTransition = 'all 0.2s';
	}
	
	var removeTransition = function(){
		imageBox.style.transition = 'none';
		imageBox.style.webkitTransition = 'none';
	}
	
	var setTranslateX = function(translateX){
		imageBox.style.transform = 'translateX('+translateX+'px)';
		imageBox.style.webkitTransform = 'translateX('+translateX+'px)';/*兼容处理*/
	}
	
	
	var timer = setInterval(function(){
		index ++;
		/*过渡效果*/
		addTransition();
		/*位移*/
		setTranslateX(-index*bannerWidth);
		//最后一张图片播放完成后回到第一张
//		if (index > iamgeCounts) {
//			//这样会从最后一张再次滑到第一张，重复两次，希望在最后一张的时候，就能直接定位到第一张banner图, 并且清楚过渡效果
//			index = 1;
//		}
		
	},1000);
	
	imageBox.addEventListener("transitionend", function(){
		if (index >= 7) {
			index = 1;
			//清除过渡效果
			removeTransition();
			//位移
			setTranslateX(-index*bannerWidth);
		} else if(index <= 0) {
			//无缝滑动, 在第一张的时候，向右滑动
			index = 6;
			removeTransition();
			setTranslateX(-index*bannerWidth);
		}
		
		//2. 点的颜色改变
		//点的颜色改变 1 - 6
		setPoint();
		
	});
	
	var setPoint = function(){
		//方法一：
//		pointBox.querySelector(".now").classList.remove('now');
//		document.querySelector(".banner ul:last-child li.now").classList.remove('now');
		
		//方法二:
		for (var i = 0 ; i < points.length; i++) {
			points[i].classList.remove('now');
		}
		
//		document.querySelector(".banner ul:last-child li:nth-child("+index+")").classList.add('now');
		points[index-1].classList.add('now');
	}
	
}
var downTime = function(){
	
}