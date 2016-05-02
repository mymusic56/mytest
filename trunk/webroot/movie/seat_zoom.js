$(function(){
	 var opt={
		        controller:{
		            type:0,//0：触摸前；1：触摸后
		            scale:1,
		            len:0,//两个触点间的距离
		            sc:0,//捏合后的缩放比例
		            x:0,//单个触点相对可视区域的X坐标
		            y:0,
		            moveX:0,//单个触点相对整个页面的X坐标
		            moveY:0,
		            seatno:"",//座位号
		            defaultL:0,//座位图 默认偏移量
		            defaultT:0,
		            tmpX:0,//当前座位 距离  可视窗口偏移量
		            tmpY:0,
		            tmpCX:0,//中间座位 距离  座位图左边的距离
		            tmpCY:0,
		            l:0,//座位图 实际移动left偏移量（包括类似边框的宽度）
		            t:0,//座位图 实际移动top偏移量
					
		            autoScale:0,//缩放标记
		            limitX:{//座位图 需要移动left偏移量（未包括边框的宽度）
		                min:0,
		                max:0
		            },
		            limitY:{
		                min:0,
		                max:0
		            },
		            limitScale:1//缩放的最大比例， 也就是点击之后座位显示的尺寸所占的比例
		        },
		        size:                  30,//每个座位的宽度+座位之间的宽度
		        sizeH:                 30,//每个座位的高度+座位之间的高
		    };
	 	var spaceRow = $(".spaceRow").length;
//	 	alert(spaceRow);
	 	var mr = parseInt($("#maxRow").val())+2;//座位行
	    var mc = parseInt($("#maxCol").val()) +1;//实际座位个数
	    var seatsW=$("#seatDiv").width();
        var tmpScale=(seatsW)/(mc*opt.size);//实际座位所占宽度+间隙+过道
        tmpScale=tmpScale>1?1:tmpScale;
        opt.controller.scale=tmpScale*1;
        opt.controller.limitScale=tmpScale*1;
        opt.controller.sc=tmpScale*1;
        var seatDiv=$("#seatMap").css({width:mc*opt.size+"px","transform":"scale("+opt.controller.scale+","+opt.controller.scale+")", position:"absolute", display:"block"});
        opt.controller.l=-((mc*opt.size)-seatsW)/2;
        opt.controller.t=-(opt.sizeH*mr-opt.sizeH*mr*opt.controller.scale)/2;
        opt.controller.limitX.min=opt.controller.l;
        opt.controller.limitY.min=opt.controller.t;
        opt.controller.limitX.max=opt.controller.limitX.min;
        opt.controller.limitY.max=opt.controller.limitY.min;
        opt.controller.defaultL=opt.controller.l;
        opt.controller.defaultT=opt.controller.t;
        //第二种计算方式
        opt.controller.l = -seatDiv.offset().left + $("#seatDiv").offset().left;
        opt.controller.t = -seatDiv.offset().top + $("#seatDiv").offset().top;
        
        seatDiv.css({"left":opt.controller.l+"px","top":opt.controller.t+"px"});
        
        var divH  = opt.sizeH*mr*opt.controller.scale+spaceRow*10;
        if(divH < 150){
        	divH = 200;
        }
        $("#seatDiv").css({height:divH, width:"100%"});
        //缩放控制
        $("#seatMap .Seat").bind("click",function(e){
            opt.controller.seatno=$(this).attr("seatno");
//            alert($("#seatMap .Select").length);
             var count=$("#seatMap .Select").length;//已选座位个数
             if(count==0){//------------------------第一次点击
                 opt.controller.autoScale=1;//
             }else if(count==1){//------------------第二次点击
                 opt.controller.autoScale=2;
             }else{//------------------
                 opt.controller.autoScale=0;
             }
			
             $this=$(this);
//             alert($this.offset().left+"---"+$("#seatMap").offset().left);
             opt.controller.tmpX=$this.offset().left-$("#seatMap").offset().left;//---当前座位 距离seatDiv的偏移量，其中5为行号的宽度
             opt.controller.tmpY=$this.offset().top-$("#seatMap").offset().top;
//             alert($this.offset().top+"---"+$("#seatMap").offset().top);
             if(opt.controller.type==0){
            	 chooseSeat($this);//choose_seat.js
                 var count=$("#seatMap .Select").length;
                 if(opt.controller.autoScale==1&&count==1){//----第一次点击，让座位在div中居中显示
                	 //居中后的偏移量
                     var moveX=$("#seatDiv").width()/2-(opt.controller.moveX-$("#seatDiv").offset().left);//div宽度 / 2
                     var moveY=$("#seatDiv").height()/2-(opt.controller.moveY-$("#seatDiv").offset().top);//div高度 / 2 + div距离顶部的距离
//                     alert(opt.controller.moveY+"--"+$("#seatDiv").offset().top+"--"+$(this).offset().top+"--"+moveY );
                     opt.controller.sc=1;//放大比例
					 //**********
                     opt.controller.tmpCX=(opt.size*mc*opt.controller.scale)/2;//中间座位 距离  座位图左边的距离
                     opt.controller.tmpCY=(opt.sizeH*mr*opt.controller.scale)/2;//中间座位 距离  座位图顶部的距离
                     //初始偏移量+放大后的偏移量+居中后的偏移量【偏移量与实际放大或缩小比例有关，
                     //因此是(opt.controller.sc/opt.controller.scale)*, 
                     //当前缩放比例是初始比例的几倍*初始比例下需要缩放的尺寸，也就是说需要将初始尺寸缩放几倍】
//                     opt.controller.l=parseInt(opt.controller.l)+moveX+(opt.controller.tmpCX-opt.controller.tmpX)*(opt.controller.sc/opt.controller.scale);
//                     opt.controller.t=parseInt(opt.controller.t)+moveY+(opt.controller.tmpCY-opt.controller.tmpY)*(opt.controller.sc/opt.controller.scale);
//                     alert(opt.controller.sc+"=="+opt.controller.scale);
                     opt.controller.l=parseInt(opt.controller.l)+moveX+(opt.controller.tmpCX-opt.controller.tmpX)*(opt.controller.sc/opt.controller.scale-1);
                     opt.controller.t=parseInt(opt.controller.t)+moveY+(opt.controller.tmpCY-opt.controller.tmpY)*(opt.controller.sc/opt.controller.scale-1);
                     opt.controller.scale=1;
                     if(opt.controller.scale>opt.controller.limitScale){//获取需要移动的偏移量
//                    	 alert(opt.controller.scale+"--"+opt.controller.limitScale);
					 //实际需要移动的宽度，除以2：初始显示的实际宽度-放大之后的实际宽度，再除以2 恰好是点击后应该移动的偏移量
                         opt.controller.limitX.min=((mc*opt.size*opt.controller.scale)-(mc*opt.size))/2;
                         opt.controller.limitY.min=-(opt.sizeH*mr-opt.sizeH*mr*opt.controller.scale)/2;
                         opt.controller.limitX.max=opt.controller.limitX.min+($("#seatDiv").width()-mc*opt.size*opt.controller.scale);//加上去类似边框的宽度
                         opt.controller.limitY.max=opt.controller.limitY.min+($("#seatDiv").height()-mr*opt.sizeH*opt.controller.scale);
                     }
                     if(parseInt(opt.controller.l)>opt.controller.limitX.min){
                         opt.controller.l=opt.controller.limitX.min;
                     }
                     if(parseInt(opt.controller.l)<opt.controller.limitX.max){
                         opt.controller.l=opt.controller.limitX.max;
                     }
                     if(parseInt(opt.controller.t)>opt.controller.limitY.min){
                         opt.controller.t=opt.controller.limitY.min;
                     }
                     if(parseInt(opt.controller.t)<opt.controller.limitY.max){
                         opt.controller.t=opt.controller.limitY.max;
                     }
                     $("#seatMap").css({"transition-duration":"0.1s"});
                     $("#seatMap").css({
                         "transform":"scale("+opt.controller.scale+","+opt.controller.scale+")",
	                         "left":opt.controller.l,
	                         "top":opt.controller.t
                     });
                     setTimeout(function(){
                         $("#seatMap").css({"transition-duration":"0"});
                     },100);
                 }
//                 if(opt.controller.autoScale==2&&count==0){//取消已选择的唯一一个座位， 返回初始加载状态
//                     opt.controller.sc=opt.controller.limitScale;
//                     opt.controller.scale=opt.controller.limitScale;
//                     opt.controller.l=opt.controller.defaultL;
//                     opt.controller.t=opt.controller.defaultT;
//                     $("#seatMap").css({"transition-duration":"0.1s"});
//                     $("#seatMap").css({
//                         "transform":"scale("+opt.controller.scale+","+opt.controller.scale+")",
//                         "left":opt.controller.l,
//                         "top":opt.controller.t
//                     });
//                     setTimeout(function(){
//                         $("#seatMap").css({"transition-duration":"0"});
//                     },100);
//                 }
             }
         });
         $("#seatDiv").on("touchstart",function(e){
             if(e.originalEvent.touches.length==2){//两个触点间的水平距离、垂直距离
                 var cx=parseInt(e.originalEvent.touches[0].clientX)-parseInt(e.originalEvent.touches[1].clientX);
                 var cy=parseInt(e.originalEvent.touches[0].clientY)-parseInt(e.originalEvent.touches[1].clientY);
				 //两个触点间距离
                 opt.controller.len=Math.sqrt(cx*cx+cy*cy);
                 //
                 var tmpX=e.originalEvent.touches[0].pageX-$("#seatMap").offset().left;
                 var tmpY=e.originalEvent.touches[0].pageY-$("#seatMap").offset().top;
                 var tmpX1=e.originalEvent.touches[1].pageX-$("#seatMap").offset().left;
                 var tmpY1=e.originalEvent.touches[1].pageY-$("#seatMap").offset().top;
                 opt.controller.tmpX=(tmpX+tmpX1)/2;//中间座位距离左边可视区域的距离
                 opt.controller.tmpY=(tmpY+tmpY1)/2;
                 opt.controller.tmpCX=(opt.size*mc*opt.controller.scale)/2;//中间座位距离座位图左边的距离
                 opt.controller.tmpCY=(opt.sizeH*mr*opt.controller.scale)/2;
             }
             if(e.originalEvent.touches.length==1){
				 //单触点：1）获取座位图left和top的偏移量 2）记录触点在可视区域的x,y 坐标， 相对于整个页面的x,y坐标
                 opt.controller.l=$("#seatMap").css("left");
                 opt.controller.t=$("#seatMap").css("top");
                 opt.controller.x=e.originalEvent.touches[0].clientX;
                 opt.controller.y=e.originalEvent.touches[0].clientY;
                 opt.controller.moveX=e.originalEvent.touches[0].pageX;
                 opt.controller.moveY=e.originalEvent.touches[0].pageY;
             }
         });
         $("#seatDiv").on("touchmove",function(e){
             e.originalEvent.preventDefault();//阻止浏览器滚动条
             opt.controller.type=1;
             if(e.originalEvent.touches.length==2){
                 var cx=parseInt(e.originalEvent.touches[0].clientX)-parseInt(e.originalEvent.touches[1].clientX);
                 var cy=parseInt(e.originalEvent.touches[0].clientY)-parseInt(e.originalEvent.touches[1].clientY);
				 //捏合后的缩放比例
                 opt.controller.sc=Math.sqrt(cx*cx+cy*cy)/opt.controller.len*opt.controller.scale;
                 if(opt.controller.sc>=1){
                     opt.controller.sc=1;
                 }else{
                     $("#seatMap").css({
                         "left":parseInt(opt.controller.l)+(opt.controller.tmpCX-opt.controller.tmpX)*(opt.controller.sc/opt.controller.scale-1),
                         "top":parseInt(opt.controller.t)+(opt.controller.tmpCY-opt.controller.tmpY)*(opt.controller.sc/opt.controller.scale-1)
                     });
                 }
                 $("#seatMap").css({"transform":"scale("+opt.controller.sc+","+opt.controller.sc+")"});
             }
			 //单个触点拖拽
             if(e.originalEvent.touches.length==1){
				 //座位图做偏移量：（before）座位图偏移量 + （now）触点相对可视区域距离 - （before）触点相对可视区域距离
                 $("#seatMap").css({left:(parseInt(opt.controller.l)+e.originalEvent.touches[0].clientX-opt.controller.x),top:(parseInt(opt.controller.t)+e.originalEvent.touches[0].clientY-opt.controller.y)});
             }
         });
         $("#seatDiv").bind("touchend",function(e){
			 //触摸后，更新当前触点的相对可视区域的坐标
             if(e.originalEvent.touches.length==1){
                 opt.controller.x=e.originalEvent.touches[0].clientX;
                 opt.controller.y=e.originalEvent.touches[0].clientY;
             }
			 //更新座位图偏移量，缩放比例
             if(opt.controller.type!=0){
                 opt.controller.l=$("#seatMap").css("left");
                 opt.controller.t=$("#seatMap").css("top");
                 opt.controller.scale=opt.controller.sc;
             }
             if(e.originalEvent.touches.length==0&&opt.controller.type!=0){
                 if(opt.controller.scale<=opt.controller.limitScale){
                     opt.controller.scale=opt.controller.limitScale;
                     opt.controller.l=opt.controller.defaultL;
                     opt.controller.t=opt.controller.defaultT;
                 }
                 if(opt.controller.scale>opt.controller.limitScale){
                     opt.controller.limitX.min=((mc*opt.size*opt.controller.scale)-(mc*opt.size))/2;
                     opt.controller.limitY.min=-(opt.sizeH*mr-opt.sizeH*mr*opt.controller.scale)/2;
                     opt.controller.limitX.max=opt.controller.limitX.min+($("#seatDiv").width()-mc*opt.size*opt.controller.scale);
                     opt.controller.limitY.max=opt.controller.limitY.min+($("#seatDiv").height()-mr*opt.sizeH*opt.controller.scale);
                 }
                 if(parseInt(opt.controller.l)>opt.controller.limitX.min){
                     opt.controller.l=opt.controller.limitX.min;
                 }
                 if(parseInt(opt.controller.l)<opt.controller.limitX.max){
                     opt.controller.l=opt.controller.limitX.max;
                 }
                 if(parseInt(opt.controller.t)>opt.controller.limitY.min){
                     opt.controller.t=opt.controller.limitY.min;
                 }
                 if(parseInt(opt.controller.t)<opt.controller.limitY.max){
                     opt.controller.t=opt.controller.limitY.max;
                 }
                 $("#seatMap").css({"transition-duration":"0.1s"});
                 $("#seatMap").css({
                     "transform":"scale("+opt.controller.scale+","+opt.controller.scale+")",
                     "left":opt.controller.l,
                     "top":opt.controller.t
                 });
                 setTimeout(function(){
                     $("#seatMap").css({"transition-duration":"0"});
                 },100);
             }
             if(e.originalEvent.touches.length==0){
                 opt.controller.type=0;
             }
         });
});