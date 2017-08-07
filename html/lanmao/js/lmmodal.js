define(['jquery',"jquery.cookie"], function($,jquerycookie){
    //定义懒猫未jquery的扩展,和返回.requireJS 和 扩展两种方式都可以调用
    $.lanmao = {
        modalhtml : '<div class="aui-dialog lanmao-tip"><div class="tip-header aui-text-left">懒猫提醒:</div><div class="aui-dialog-body"></div><div><span class="aui-text-info aui-btn confirm aui-pull-right">确定</span><span class="aui-text-info aui-btn cancel aui-pull-right">取消</span></div></div>',
        alert : function (msg,alertcallback) {
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html(msg);
            node.find(".cancel").remove();
            $("body").append(node);
            node.find(".confirm").click(function () {
                node.remove();
                mask.remove();
                if(alertcallback != undefined){
                    alertcallback.call();
                }
            });
        },
        detail_help : function(){
            var mask = $('<div class="aui-mask"></div>');
            var node = $('<div class="aui-dialog lanmao-tip" style="border-radius:8px; top:50%">' +
                '<div style="padding: 25px;padding-bottom: 20px;padding-top: 0px;"><button class="aui-col-xs-12 aui-btn-info" style="height: 40px;">我知道了</button></div></div>');
            $("body").append(node);
            node.find(".confirm").click(function () {
                node.remove();
                mask.remove();
                if(alertcallback != undefined){
                    alertcallback.call();
                }
            });
        },
        ios101 : function(alertcallback){
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $('<div class="aui-dialog lanmao-tip" style="border-radius:8px; top:50%">' +
                '<div style="background-image:url(/Public/static_new/img/img_border.png);height: 4px;width: 98%;"></div>'+
                '<div class="aui-text-center" style="background:#f6f6f6;padding: 15px;font-size: 18px;font-weight: bold">返回桌面，打开应用</div>' +
                '<div class="aui-dialog-body" style="padding: 25px;"><img src="/Public/static_new/img/img-info.png" style="width: 98%;"></div>' +
                '<div style="padding: 25px;padding-bottom: 20px;padding-top: 0px;"><button class="aui-col-xs-12 aui-btn-info confirm" style="height: 40px;">我知道了</button></div></div>');
            $("body").append(node);
            node.find(".confirm").click(function () {
                node.remove();
                mask.remove();
                if(alertcallback != undefined){
                    alertcallback.call();
                }
            });
        },
        alertcommenttask:function(msg,alertcallback){
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html('<div style="margin-top: 15px;margin-bottom: 10px;"><img src="/Public/static_new/img/successsumbit.png" style="width: 30%"></div>' +
                '<div style="font-size: 18px;">提交成功!</div><div style="color:#949494;font-size: 15px;margin-bottom: 20px;">等待审核，审核通过后将在次日到账。</div>' +
                '<div><button class="aui-col-xs-12 aui-btn-info clic">我知道了</button></div>');
            node.find(".cancel").remove();
            node.find(".confirm").remove();
            node.find(".tip-header").remove();
            $("body").append(node);
            node.find(".clic").click(function () {
                node.remove();
                mask.remove();
                if(alertcallback != undefined){
                    alertcallback.call();
                }else{
                    document.location.reload();
                }
            });

        },
        confirm:function (msg,funcancel,funconfirm) {
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html(msg);
            $("body").append(node);
            node.find(".confirm").click(function () {
                node.remove();
                mask.remove();
                funconfirm.call();

            });
            node.find(".cancel").click(function () {
                node.remove();
                mask.remove();
                funcancel.call();
            });
        },
        tip:function (msg) {
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html(msg);
            node.find(".aui-dialog-body").removeClass("aui-text-left");
            node.find(".cancel").remove();
            node.find(".confirm").remove();
            $("body").append(node);
            setTimeout(function () {
                node.remove();
                mask.remove();
            },3500);
        },
        qd_progress:function () {
            var html = '<div class="qd aui-text-center"><img src="http://nineton-static.oss-cn-hangzhou.aliyuncs.com/12static/img/qd.gif" alt="抢任务中" style="width: 150px;"><div>小懒猫努力抢夺任务中......</div></div>';
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html(html);
            node.find(".cancel").remove();
            node.find(".confirm").remove();
            node.find(".tip-header").remove();
            $("body").append(node);
            this.progressnode = node;
            this.progressnodemask = mask;
        },
        qd_progress_remove:function () {
            if(this.progressnode != undefined){
                this.progressnode.remove();
            }
            if(this.progressnodemask != undefined){
                this.progressnodemask.remove();
            }
        },
        upload_progress:function () {
            var html = '<div class="qd aui-text-center"><img src="http://nineton-static.oss-cn-hangzhou.aliyuncs.com/12static/img/qd.gif" alt="抢任务中" style="width: 150px;"><div>上传图片中......</div></div>';
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html(html);
            node.find(".cancel").remove();
            node.find(".confirm").remove();
            node.find(".tip-header").remove();
            $("body").append(node);
            this.uploadprogressnode = node;
            this.uploadprogressnodemask = mask;
        },
        upload_progress_remove:function () {
            if(this.uploadprogressnode != undefined){
                this.uploadprogressnode.remove();
            }
            if(this.uploadprogressnodemask != undefined){
                this.uploadprogressnodemask.remove();
            }
        },linkserver:function(){
            document.location.href="redEnvelopes://openLocalServer";
        },
        alertnolanmao:function () {
            if(this.nolanmaonode != undefined && this.nolanmaomask != undefed){
                return;
            }
            var html = '<div class="qd aui-text-center nolanmao"><img src="http://www' +
                '.cattry.com/Public/static_new/img/nolanmao.png" alt="没有懒猫"><div class="nolanmao-tip">没有检测到懒猫助手,请打开懒猫助手</div><div class="aui-btn-block aui-btn">打开助手</div><div class="nolanmao-openlanmao">助手闪退,<span><a href="/Guide/login.html">请重新下载助手</a></span></div></div>';
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.find(".aui-dialog-body").html(html);
            node.find(".cancel").remove();
            node.find(".confirm").remove();
            node.find(".tip-header").remove();
            node.find(".aui-btn-block").click(function () {
                if(developfrom == "redenvelopes"){
                    document.location.href="redEnvelopes://opencatfromweb?"
                }else{
                    document.location.href="lazycat://opencatfromweb?";
                }
            });
            $("body").append(node);
            this.nolanmaonode = node;
            this.nolanmaomask = mask;
        },
        alertnolanmao_remove:function () {
            if(this.nolanmaonode != undefined){
                this.nolanmaonode.remove();
            }
            if(this.nolanmaomask != undefined){
                this.nolanmaomask.remove();
            }
        },
        tip_hongbao:function () {
            // $.cookie("openedhongbao",null);
            if($.cookie("openedhongbao") == 1){
                return;
            }

            if(this.hongbaonode != undefined && this.hongbaomask != undefed){
                return;
            }
            var html = '<div class="aui-text-center"><a href="/Vplus/hongbaodes.html"><img style="width: 100%;" src="http://www' +
                '.cattry.com/Public/static_new/img/lanmao_hb.png" alt=""></a></div>';
            var mask = $('<div class="aui-mask"></div>');
            $("body").append(mask);
            var node = $(this.modalhtml);
            node.css("background","none");
            node.css("bottom","100px");
            node.find(".aui-dialog-body").html(html);
            node.find(".cancel").remove();
            node.find(".confirm").remove();
            node.find(".tip-header").remove();
            $("body").append(node);
            this.hongbaonode = node;
            this.hongbaomask = mask;
            var _this = this;
            node.find("a").click(function () {
                _this.hongbaonode.remove();
                _this.hongbaonode = null;
                _this.hongbaomask.remove();
                _this.hongbaomask = null;
            });
            this.hongbaomask.click(function () {
                _this.hongbaonode.remove();
                _this.hongbaonode = null;
                _this.hongbaomask.remove();
                _this.hongbaomask = null;
            });
        }
    };
    return $.lanmao;
});
