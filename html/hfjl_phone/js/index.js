var scrollUp = function() {
	var comment = document.querySelector(".comment");
	var slide1 = document.querySelector("#slide1");
	document.querySelector("#slide2").innerHTML = slide1.innerHTML;
	var speed = 30;
	
	function mySlide(){
		if (slide1.offsetTop - comment.scrollTop <= 0) {
			comment.scrollTop -= slide1.offsetHeight;
		}else{
			comment.scrollTop++;
		}
//	    console.log(slide1.offsetTop +"--"+ comment.scrollTop)
	}
	
	var timer = setInterval(mySlide, speed);

	document.addEventListener("touchstart", function() {
		console.log("tocuhstart");
		clearInterval(timer);
	});
	document.addEventListener("touchend", function() {
		console.log("touchend");
		clearInterval(timer);
		timer = setInterval(mySlide, speed);
	});
}

scrollUp();

var ua = navigator.userAgent.toLowerCase();
var phone = /iphone|ipad|ipod/.test(ua);
var android = /android/.test(ua);
var downbtn = document.getElementById('downbtn');
downbtn.onclick = function () {
//	if(phone){ // 苹果
//		window.location.href="https://itunes.apple.com/cn/app/id1298950965?mt=8"; // 待修改
//	}else if(android){ // 安卓
//		window.location.href="http://qiniubigresource.nineton.cn/avatar110_share.apk";// 待修改
//	}
    downLoad();
}
var downbtn2 = document.getElementById('downbtn2');
downbtn2.onclick = function () {
    downLoad();
}

var browser = {
    versions: function () {
        var u = navigator.userAgent, app = navigator.appVersion;
        return {//移动终端浏览器版本信息
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
            mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), //是否为移动终端
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
            iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
};

function downLoad() {
    if (browser.versions.ios || browser.versions.iPhone || browser.versions.iPad) {
        console.log("下载Ios");
        window.location.href = 'https://itunes.apple.com/cn/app/id1353728980?mt=8';
    } else if (browser.versions.android) {
        //window.location.href = "http://qiniubigresource.nineton.cn/avatar111_qm.apk";
        console.log("下载Android");
    } else {
        console.log("下载Android");
        //window.location.href = "http://qiniubigresource.nineton.cn/avatar111_qm.apk";
    }
}