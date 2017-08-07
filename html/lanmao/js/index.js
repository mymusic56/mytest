define(['jquery','lmmodal'], function($,lmmodal){
    var lanmaoindex = {
        slidetop:function (node) {
            if(node.find('li').size() > 1){
                var i = 0;
                var len = node.find('li').size();
                setInterval(function () {
                    var oLi = node.find('li');
                    if(i == len - 1){
                        oLi.show();
                        i = 0;
                    }else{
                        oLi.eq(i).slideUp(1000,function () {
                            i++;
                        });
                    }
                }, 2000);
            }
        },
        dealauigridninebug:function(){
            $(".aui-grid-nine li").click(function () {
                var url = $(this).find("a").attr("href");
                if(url != undefined){
                    document.location.href = $(this).find("a").attr("href");
                }
            });
        },
        checkweixin:function () {
            var domhtml = '<div id="fenxiangyindao"><img src="http://static.nineton.cn/11static/mfront/img/fenxiangyindao.png" class="img-rounded" alt="分享引导"></div>';
            var ua = window.navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i) == 'micromessenger'){
                var node = $(domhtml);
                if(window.navigator.userAgent.toLowerCase().match(/android/) != null){
                    node.find("img").attr("src","http://static.nineton.cn/11static/mfront/img/fenxiangyindao_wx_android.png");
                }
                $("body").append(node);
                $("#fenxiangyindao").show();
            }
        },
        shoutujiangli:function() {
            $(".lingqu-btn-available").click(function(){
                var ljtype = $(this).data("type");
                $.ajax({
                    url: "/Apprentice/lingjiang.html",
                    type: 'post',
                    data:{type:ljtype},
                    dataType: 'json',
                    success: function (r) {
                        lmmodal.tip(r.msg);
                        setTimeout(function () {
                            window.location.reload();
                        },1500);
                    },
                    error: function (r) {
                        lmmodal.tip("提交失败，请稍后再试");
                    }
                });
            });
        }
    }
    return lanmaoindex;
});