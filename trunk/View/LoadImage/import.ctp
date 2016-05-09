<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title></title>
<script type="text/javascript" src="/js/jquery-2.1.4.min.js"></script>
   <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
	var images = {
			localIds : [],
			serverId : []
	};
	/*
	   * 注意：
	   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
	   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
	   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
	   *
	   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
	   * 邮箱地址：weixin-open@qq.com
	   * 邮件主题：【微信JS-SDK反馈】具体问题
	   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
	   */
	  wx.config({
	    debug: true,
	    appId: '<?php echo $signPackage["appId"];?>',
	    timestamp: <?php echo $signPackage["timestamp"];?>,
	    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	    signature: '<?php echo $signPackage["signature"];?>',
	    jsApiList: [
	    			'checkJsApi',
	    			'chooseImage',
	    			'previewImage',
	    			'uploadImage',
	    			'downloadImage'
	    	    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	  });
	wx.ready(function(){
		$("#chooseImage").on("click", function(){
			wx.chooseImage({
			    count: 1, // 默认9
			    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			    success: function (res) {
			        images.localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
			    }
			});
		});
		$("#uploadImage").on("click", function(){
			wx.uploadImage({
			    localId: localIds, // 需要上传的图片的本地ID，由chooseImage接口获得
			    isShowProgressTips: 1, // 默认为1，显示进度提示
			    success: function (res) {
			       	images.serverId = res.serverId; // 返回图片的服务器端ID
			    }
			});
		});
        $('#previewImage').on("click", function () {

            var imgList = [

                'http://wp83.net__PUBLIC__/images/gallery/image-1.jpg',

                'http://wp83.net__PUBLIC__/images/gallery/image-2.jpg'

            ];

            wx.previewImage({

                current: imgList[0],

                urls:  imgList

            });

        });
	    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
	});
	
// 	wx.previewImage({
// 	    current: '', // 当前显示图片的http链接
// 	    urls: [] // 需要预览的图片http链接列表
// 	});
	
// 	wx.downloadImage({
// 	    serverId: '', // 需要下载的图片的服务器端ID，由uploadImage接口获得
// 	    isShowProgressTips: 1, // 默认为1，显示进度提示
// 	    success: function (res) {
// 	        var localId = res.localId; // 返回图片下载后的本地ID
// 	    }
// 	});
	</script>
</head>

<body>
        <!--#固定在页面中心的初始化动画提示-->
        <div id="loading"> <div class="card"> <span class="dots-loader">页面加载中...</span> </div> </div>
        <!-- content -->
        <div class="content_">
            <div class="padd-l-0_5 padd-r-0_5">
                <!--活动圈-->
                    <form  class="marg-t-0_5" method='post' >
                        <textarea rows="5" placeholder="请输入活动信息" name='content' id="tcontent"></textarea>
                        <button id="chooseImage">添加照片</button>
                        <input type='hidden' name='imageurl' id='imageurl'>
                    </form>
                    <br>
                     <div class="table-view-cell media bg-white act" style="border:none">   
                    <div id='div_img' class="">
                    </div>
                    </div>
            </div>
        </div>
        <!-- /content -->

        <!--#固定在底部的按钮条-->
        <div class="b-btn">
            <a id="sub"> <button id="uploadImage" class="icon icon-hand"></span> 提交发布 </button>
        </div>
</body>

</html>