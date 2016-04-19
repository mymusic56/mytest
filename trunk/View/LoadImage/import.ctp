<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title></title>

   <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
	wx.config({
	    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	    appId: '', // 必填，公众号的唯一标识
	    timestamp: , // 必填，生成签名的时间戳
	    nonceStr: '', // 必填，生成签名的随机串
	    signature: '',// 必填，签名，见附录1
	    jsApiList: [
			'checkJsApi',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage'
	    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	wx.ready(function(){

	    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
	});
	</script>
</head>

<body>
        <!--#固定在页面中心的初始化动画提示-->
        <div id="loading"> <div class="card"> <span class="dots-loader">页面加载中...</span> </div> </div>
        <!-- content -->
        <div class="content_">
            <div class="padd-l-0_5 padd-r-0_5">
                <!--活动圈-->
                    <form  class="marg-t-0_5" method='post'  onsubmit="return checkSubmit();">
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
            <a id="sub"> <button class="icon icon-hand"></span> 提交发布 </button>
        </div>
</body>

</html>