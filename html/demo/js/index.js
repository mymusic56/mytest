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
	/**/
	
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
	
}
var downTime = function(){
	
}