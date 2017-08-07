define(['jquery',"lmmodal","common"], function($,lmmodal,common){
    var guide = {
        dologin:function (clientBaseurl) {
            var clientloginurl = clientBaseurl + "/login";
            var loginfromurl = clientBaseurl + "/successloginwanpan";
            var loginindex = "/Guide/index.html";
            this.checkversion(clientBaseurl,function () {
                $.ajax({
                    url: clientloginurl,
                    type: 'get',
                    dataType: 'json',
                    success: function (r) {
                        if (r.status == 1) {
                            if(r.data.newlogin != true){
                                //这时候助手未能正常连接服务器
                                $.ajax({url:loginfromurl,type:"get",dataType:'json',success:function(boundinfo){
                                    if(boundinfo.status == 1){
                                        if("cn.nineton.cattry" == boundinfo.data.from){
                                            lmmodal.alert("您助手未能连接上服务器，请重新打开懒猫助手。");
                                            // document.location.href = loginindex;
                                        }
                                        if("cn.nine.search" == boundinfo.data.from){
                                            lmmodal.alert("您助手未能连接上服务器，请重新打开网盘搜索。");
                                            // document.location.href = loginindex;
                                        }
                                    }
                                }});
                                return;
                            }
                            var openudid = r.data.openudid;
                            var idfa = r.data.idfa;
                            var type = 0;
                            var isjailbreak = 1;
                            if (r.data.type) type = r.data.type;
                            if (type == 1) type = 2;//客户端1是ipad ，服务端2是ipad
                            if (type == 2) type = 1;
                            if (r.data.isjailbreak) isjailbreak = r.data.isjailbreak;
                            if (isjailbreak == 2) {
                                lmmodal.alert("越狱设备暂时不支持。");
                                return false;
                            }
                            //登录服务器
                            var ajaxLoginUrl = "/Guide/dologin.html";
                            var nowDate = new Date();
                            var nowTime = nowDate.getTime() / 1000;
                            var logindata = {openudid:openudid,idfa:idfa,type:type,time:nowTime};
                            $.get(ajaxLoginUrl,logindata, function (serverData) {
                                if (serverData.status == 1) {
                                    window.location.href = "/";
                                }else{
                                    lmmodal.alert(serverData.info);
                                }
                            });
                        } else {
                            lmmodal.tip("您的助手未打开,或未安装,请下载懒猫助手后打开.");
                            setTimeout(function () {
                                document.location.href = loginindex;
                            },2000);
                        }
                    },
                    error: function (r) {
                        lmmodal.tip("您的助手未打开,或未安装,请下载懒猫助手后打开.");
                        setTimeout(function () {
                            document.location.href = loginindex;
                        },3000);
                    }
                });
            });
        },
        checklogin:function (clientBaseurl) {
            var clientloginurl = clientBaseurl + "/login";
            var loginfromurl = clientBaseurl + "/successloginwanpan";
            var loginindex = "/Guide/index.html";
            this.checkversion(clientBaseurl,function () {
                $.ajax({
                    url: clientloginurl,
                    type: 'get',
                    dataType: 'json',
                    success: function (r) {
                        if (r.status == 1) {
                            if(r.data.newlogin != true){
                                //这时候助手未能正常连接服务器
                                $.ajax({url:loginfromurl,type:"get",dataType:'json',success:function(boundinfo){
                                    if(boundinfo.status == 1){
                                        if("cn.nineton.cattry" == boundinfo.data.from){
                                            lmmodal.alert("您助手未能连接上服务器，请重新打开懒猫助手。");
                                            setTimeout(function () {
                                                document.location.href = loginindex;
                                            },2000);
                                        }
                                        if("cn.nine.search" == boundinfo.data.from){
                                            lmmodal.alert("您助手未能连接上服务器，请重新打开网盘搜索。");
                                            setTimeout(function () {
                                                document.location.href = loginindex;
                                            },2000);
                                        }
                                    }
                                }});
                                return;
                            }
                        } else {
                            lmmodal.tip("您的助手未打开,或未安装,请下载懒猫助手后打开.");
                            setTimeout(function () {
                                document.location.href = loginindex;
                            },2000);
                        }
                    },
                    error: function (r) {
                        lmmodal.tip("您的助手未打开,或未安装,请下载懒猫助手后打开.");
                        setTimeout(function () {
                            document.location.href = loginindex;
                        },1000);
                    }

                });
            },function(){
                if(developfrom == "redenvelopes"){
                    lmmodal.linkserver();
                }else{
                    lmmodal.alertnolanmao();
                }
            });
        },
        checkversion:function (clientBaseurl,successcall,errorcall) {
            var getversionurl = clientBaseurl + "/getappinfo";
            var dockeckversion = function(){
                $.ajax({
                    url: getversionurl,
                    type: 'get',
                    dataType: 'json',
                    success:function (data) {
                        lmmodal.alertnolanmao_remove();
                        clearInterval(cheversion_lop);
                        if(data.status == 1){
                            if(common.compareversion(data.data.version,"4.0.0")){
                                if(!common.compareversion(data.data.version,"3.6.0")){
                                    $.get('/Task/getagent.html',{}, function (r) {
                                        if(r.data){
                                            lmmodal.tip("IOS 10.1用户请更新版本");
                                            //lmmodal.ios101("IOS 10.1用户请更新版本");
                                            //lmmodal.ios101(function(){
                                            //    document.location.href="https://itunes.apple.com/cn/app/id1134421857?mt=8&at=1000l8vm";
                                            //});
                                            if(errorcall != undefined){
                                                setTimeout(function () {
                                                    document.location.href="https://itunes.apple.com/cn/app/id1134421857?mt=8&at=1000l8vm";
                                                },3500);
                                            }
                                        }
                                    });
                                }

                                if(successcall != undefined){
                                    successcall.call();
                                }}else{
                                lmmodal.tip("您的当前版本太低,请删除懒猫助手重新下载最新版.");
                                /*if(errorcall != undefined){
                                    setTimeout(function () {
                                        document.location.href="/Guide/downloadios9.html";
                                    },3500);
                                }*/
                            }
                        }else{
                            lmmodal.tip("您的助手未打开,或未安装,请下载懒猫助手后打开.");
                            if(errorcall != undefined){
                                setTimeout(function () {
                                    errorcall.call();
                                },3000);
                            }
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown) {
                        if(errorcall != undefined){
                            errorcall.call();
                        }
                    }
                });
            };
            var cheversion_lop = setInterval(dockeckversion,1000);
        }
    }
    return guide;
});
