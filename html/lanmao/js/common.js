define(['jquery'], function($){
    var common = {
        iosversion:function () {
            if ((navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i))) {
                // 判断系统版本号是否大于 9
                if(navigator.userAgent.match(/OS [9]_\d[_\d]* like Mac OS X/i)){
                    return 9
                }
                if(navigator.userAgent.match(/OS [8]_\d[_\d]* like Mac OS X/i)){
                    return 8
                }
                if(navigator.userAgent.match(/OS [7]_\d[_\d]* like Mac OS X/i)){
                    return 7
                }
                if(navigator.userAgent.match(/OS [6]_\d[_\d]* like Mac OS X/i)){
                    return 6
                }
            } else {
                return 0;
            }
        },
        copynewkeyword:function(keyword,clientBaseurl){
            var copyurl = clientBaseurl + "/v2pasteboard?" + keyword;
            $.get(copyurl,function (copyreturn) {
                if(copyreturn.status == 1){}
            },"json");
        },
        copyevent:function (node,callback,clientBaseurl) {
            if(node.length == 0){
                return;
            }
            var copyUseImg = '<img id="copyUseImg" style="-webkit-user-select:none;position: absolute; display:block;z-index: 5;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAABBJREFUeNpi/v//PwNAgAEACQsDAUdpTjcAAAAASUVORK5CYII=">';
            var ios9select = '<div id="ios9select" style="position: absolute; display:block;z-index: 99; margin: 0 auto;"></div>';
            var copyUseImgNode = $(copyUseImg);
            var ios9selectNode = $(ios9select);
            if(node.find("span") != undefined){
                var keyword = node.find("span").html();
                var left = node.offset().left;
                var left = (node.outerWidth() - node.find("span").outerWidth()) / 2;
                var width = node.find("span").outerWidth();
                var height = node.find("span").outerHeight()
                copyUseImgNode.width(width);
                copyUseImgNode.height(height);
                copyUseImgNode.offset({left:left,top:0})
                ios9selectNode.width(width);
                ios9selectNode.height(height);
                ios9selectNode.offset({left:left,top:0})
                if (this.iosversion() >= 9){
                    copyUseImgNode.attr("alt",keyword);
                }
                node.before(copyUseImgNode);
                node.before(ios9selectNode);
                copyUseImgNode.bind("copy",function(){
                    if (clientBaseurl != undefined) {
                        var getversionurl = clientBaseurl + "/getappinfo";
                        $.get(getversionurl,function (data) {
                            if(data.status == 1){
                                if(common.compareversion(data.data.version,"3.1.0")){
                                    //调用助手复制
                                    var copyurl = clientBaseurl + "/v2pasteboard?" + keyword;
                                    $.get(copyurl,function (copyreturn) {
                                        if(copyreturn.status == 1){
                                            callback.call();
                                        }
                                    },"json");
                                }else{
                                    callback.call();
                                }
                            }
                        },"json");
                    } else {
                        callback.call();
                    }
                });
            }
        },
        //ver1大于等于ver2返回true,ver2大返回false
        compareversion:function(ver1,ver2){
            var result = ver1.localeCompare(ver2);
            if(result != -1){
                return true;
            }else{
                return false;
            }
        }
    }
    return common;
});
