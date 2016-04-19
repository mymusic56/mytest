<?php echo $this->fetch('content'); 
if(isset($js))
{
	?>
	
	<script  type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
	$(function(){

wx.config({
    debug: false,
    appId: 'wx7785f03b84d44129',
    timestamp: '<?php echo $js['timestamp'];?>',
    nonceStr: '<?php echo $js['nonce_str'];?>',
    signature: '<?php echo $js['signature'];?>',
    jsApiList: [
      'checkJsApi',
      'hideMenuItems',
      'showOptionMenu',
      'hideOptionMenu',
      'showMenuItems',
      'hideAllNonBaseMenuItem',
      'onMenuShareTimeline',
      'onMenuShareAppMessage'
    ]
});

wx.ready(function () {
	  wx.hideMenuItems({
		    menuList: [
				"menuItem:exposeArticle",
				"menuItem:setFont",
				"menuItem:dayMode",
				"menuItem:nightMode",
				"menuItem:refresh",
				"menuItem:profile",
				"menuItem:addContact",
				"menuItem:share:qq",
				"menuItem:share:weiboApp",
				"menuItem:favorite",
				"menuItem:share:facebook",
				'menuItem:share:QZone',
				"menuItem:editTag",
				"menuItem:delete",
				"menuItem:copyUrl",
				"menuItem:originPage",
				"menuItem:readMode",
				"menuItem:openWithQQBrowser",
				"menuItem:openWithSafari",
				"menuItem:share:email",
				"menuItem:share:brand",
				"menuItem:share:appMessage",
				"menuItem:share:timeline"
			 ] // 要隐藏的菜单项，所有menu项见附录3
		});
});
	});
</script>
	<?php 
}
?>