var num = 0;//选择的座位数量
	var selected = $(".Tick");//显示选择的座位
	var aprice = $("#aprice").val()*1;
	var eprice = $("#eprice").val()*1;
//	var totalPrice = $("#totalPrice");
	var tempPrice = '';
	var isActivity = $("#isActivity").val();
	var seatType="", rowTr="", tds="", tempno="";
	//座位类型， td的父节点tr, 所有td, tempno:座位列号， 用于循环判断当前座位前的情侣座位个数; 
	var flag = true;//是否为单个座位标记

function chooseSeat(_this){
	if(_this.attr("class") == "Seat" || _this.attr("class") == "Seat Lovers"){//未被购买
		if(num >= 4){//从0 开始， 选择后再加一
			$(".Cover").attr("style", "");
			$(".Tips").text("一次最多购买4张票，超过四张请分批购买"); 
			setTimeout(function(){
				$(".Cover").attr("style", "display:none");
			}, 2000);
			return;
		}
		seat1 = _this.attr("data-seat");
		seatType = _this.attr("data-seattype");
		
//			alert(seat1); 
		//--------------------------避免出现单个座位----未完善---------------------------
		
		//--------------------------避免出现单个座位-------------------------------
		if(seatType == 1){//情侣座
//				alert(1111);
			tempno = _this.attr("data-tempno");
			rowTr = _this.parent();
			var loverSeatNumBefore = getParentNode(rowTr, tempno);//获取当前点击座位前面情侣座个数
			chooseOnLovers(loverSeatNumBefore, _this, selected);
//				alert(loverSeatNumBefore);
		}else{
			//非情侣座才进行是否留下单个座位判断
			flag = avoidSingleSeat(_this);
			if(!flag){
				return;
			}
			//使用setno作为当前座位的id
			selected.append('<div class="Tli" id="'+_this.attr("seatno")+'">'+_this.attr("data-seat")+'</div>');
			//判断上一个上一个座位
			_this.attr("class", "Seat Select");
			num ++;
		}
		//活动价格
		if(isActivity == 1){
			var comboTotalPrice = new Number(aprice + (num-1) * eprice);
			$("#totalPrice").text("总计 : "+comboTotalPrice.toFixed(2)+"元");
		}else{
		}
		tempPrice = num*aprice;
		tempPrice = recalculatePrice(tempPrice, num*1, aprice*1);
		$("#totalPrice").text("总计 : "+tempPrice.toFixed(2)+"元");
	}else if(_this.attr("class") == "Seat Select"){//已选， 再次点击
		//--------------------------避免出现单个座位----不科学---------------------------
		
		//--------------------------避免出现单个座位-------------------------------
		if(_this.attr("data-seattype") == 0){//普通座位
			flag = avoidSingleSeat(_this);
			if(!flag){
				return;
			}
			_this.attr("class", "Seat");
			$("#"+_this.attr("seatno")).remove();
			num = num-1;
		}else{//情侣座
			tempno = _this.attr("data-tempno");
			rowTr = _this.parent();
			var loverSeatNumBefore = getParentNode(rowTr, tempno);//获取当前点击座位前面情侣座个数
			chooseOnLovers(loverSeatNumBefore, _this);
		}
		//活动价格
		if(isActivity == 1){
			var comboTotalPrice = new Number(aprice + (num-1) * eprice);
			$("#totalPrice").text("总计 : "+comboTotalPrice.toFixed(2)+"元");
		}else{
		}
		tempPrice = num*aprice;
		tempPrice = recalculatePrice(tempPrice, num*1, aprice*1);
		$("#totalPrice").text("总计 : "+tempPrice.toFixed(2)+"元");
//			alert(num);
	}else{}
}
$(function(){
	$(".Fr").on("click", function(){
		if(num == 0){
			$(".Cover").attr("style", "");
			$(".Tips").text("亲， 至少选择一张哦");
			setTimeout(function(){
				$(".Cover").attr("style", "display:none");
			}, 2000);
			return;
		}
		if(num > 4){
			$(".Cover").attr("style", "");
			$(".Tips").text("亲， 系统繁忙，刷新页面后再试");
			setTimeout(function(){
				$(".Cover").attr("style", "display:none");
			}, 2000);
			return;
		}
		var boughtTicket = "";
		var ticketsLi = $(".Tick .Tli:first");
		for(var i = 0; i < num; i ++){
			boughtTicket += ticketsLi.attr("id")+",";
			if(i == (num -1)){
				boughtTicket += ticketsLi.text();
			}else{
				boughtTicket += ticketsLi.text()+";";
			}
			ticketsLi = ticketsLi.next();
		}
		var moviePlanId = $("#moviePlanId").val();//场次ID
		var comboId = $("#comboId").val();
		window.location.href = "/movies/moviePay/"+boughtTicket+"/"+moviePlanId+"/"+comboId+"/"+tempPrice;
	});
});
/**
 * 获取当前点击的情侣座前面的座位数
 */
function getParentNode(rowTr, tempno){
	var loverSeatNumBefore = 0;//loverSeatNumBefore:当前点击座位前面情侣座个数
	tds = rowTr.children();
	var len = tds.length;
	var firstNode = tds.first();
	var firstNo = firstNode.attr("data-tempno");
	var i = 0;
	while(i < len){
		if(firstNo == tempno){
			return loverSeatNumBefore;
		}
		if(firstNode.attr("data-seattype") == 1){//是情侣座 则 计数器+1
			loverSeatNumBefore ++;
		}
		firstNode = firstNode.next();
		firstNo = firstNode.attr("data-tempno");
		i++;
	}
	return loverSeatNumBefore;
}
/**
 * 选择的座位是情侣座
 */
function chooseOnLovers(loverSeatNumBefore, nowObj, selected){
//		alert(loverSeatNumBefore % 2 );
	
	
	if(loverSeatNumBefore % 2 == 0){//如果是偶数， 表示应该把该座位后面的座位选上， 或者移除
//			alert(nowObj.next().attr("data-tempno"));
		var nextObj = nowObj.next();
		if(nowObj.attr("class") == "Seat Select"){
			nowObj.attr("class", "Seat Lovers");
			nextObj.attr("class", "Seat Lovers");
			$("#"+nowObj.attr("seatno")).remove();
			$("#"+nextObj.attr("seatno")).remove();
			num = num-2;
		}else{
			nowObj.attr("class", "Seat Select");
			nextObj.attr("class", "Seat Select");
			selected.append('<div class="Tli" id="'+nowObj.attr("seatno")+'">'+nowObj.attr("data-seat")+'</div>');
			selected.append('<div class="Tli" id="'+nextObj.attr("seatno")+'">'+nextObj.attr("data-seat")+'</div>');
			num = num+2;
		}
	}else{
		var prevObj = nowObj.prev();
		if(nowObj.attr("class") == "Seat Select"){
			nowObj.attr("class", "Seat Lovers");
			prevObj.attr("class", "Seat Lovers");
			$("#"+nowObj.attr("seatno")).remove();
			$("#"+prevObj.attr("seatno")).remove();
			num = num-2;
		}else{
			nowObj.attr("class", "Seat Select");
			prevObj.attr("class", "Seat Select");
			selected.append('<div class="Tli" id="'+nowObj.attr("seatno")+'">'+nowObj.attr("data-seat")+'</div>');
			selected.append('<div class="Tli" id="'+prevObj.attr("seatno")+'">'+prevObj.attr("data-seat")+'</div>');
			num = num+2;
		}
	}
}
/**
 * -1:非座位， 0：空座， 1：已售， 2：选中
 */
function getSeatStatus(_this){
	if(_this.hasClass("Seat")){
		if(_this.hasClass("Select")){
			return 2;
		}else if(_this.hasClass("Sold")){
			return 1;
		}else{
			return 0;
		}
	}else{
		return  -1;
	}
}
/**
 *  同一排的座位：单个座位提示
 *  1 左或右挨着已选座位或者边界 OK
 *  2 
 *  3 左或右加1如果挨着自选，则中间隔的已售或者没座
 *  4 1）左右挨着空座，左右隔一个不挨着自选、已售、边界
 *    2）左右不能同时挨着自选 (取消)
 */
function avoidSingleSeat(_this){
	var l1State = getSeatStatus(_this.prev());//左边一个座位
	var l2State = getSeatStatus(_this.prev().prev());//左边两个座位
	var r1State = getSeatStatus(_this.next());
	var r2State = getSeatStatus(_this.next().next());
	var SeatNone = -1;//无座位
	var SeatNormal = 0;//空座
	var SeatSold = 1;//售出
	var SeatSelected = 2;//选中
//        alert(l1State+"--"+l2State+"--"+r1State+"--"+r2State);
	//左或右挨着已选座位或者边界
	if (l1State == SeatSold || l1State == SeatNone
			|| r1State == SeatSold || r1State == SeatNone) {
		//左加1为自选， 中间不是已售、没座、自选
		if (l2State == SeatSelected
				&& l1State == SeatNormal
		) {
			//排除只有几个连续的情况
//            		alert("1中间不能有空位");
			alertTips();
			return false;
		}
		//右加1为自选， 中间不是已售或者没座
		if (r2State == SeatSelected
				&& r1State == SeatNormal
		) {
//                		alert("2中间不能有空位");
			alertTips();
			return false;
		}
		//左边为自选， 左加一为不为已售、无座
		if(l1State == SeatSelected){
			//排除只有两个、三个或者四个座位的情况（但是正常情况也包含进来了）
			if(l2State == SeatNone || l2State == SeatSold || l2State == SeatSelected){
				//判断当前点击的位置有几个连续的可选座位  若大于4， 则提示不能留下空座位
				var countObj = normalSeatBefor(_this, 2);//右边界
//                		alert(countObj[2]);
				if(countObj[0] == 1 && countObj[1] == 2  || countObj[2] >= 4){
//                			alert("1左边为自选， 左加一为不为已售、无座, count > 4");
					alertTips();
					return false;
				}
			}else{
//                		alert("1左边为自选， 左加一为不为已售、无座");
				alertTips();
				return false;
			}
		}
		//右边为自选， 右加一为空座
		if(r1State == SeatSelected){
			if(r2State == SeatNone || r2State == SeatSold || r2State == SeatSelected){
				var countObj = normalSeatBefor(_this, 1);
//                		alert(countObj[2]);
				if(countObj[0] == 1 && countObj[1] == 2 || countObj[2] >= 4){
//                			alert("2右边为自选， 右加一为不为已售、无座, count > 4");
					alertTips();
					return false;
				}
			}else{
//                		alert("2右边为自选， 右加一为不为已售、无座");
				alertTips();
				return false;
			}
		}
	} else {
		//左右不能同时为自选
		if(l1State == SeatSelected && r1State == SeatSelected){
//            		alert("左右不能同时为自选");
			alertTips();
			return false;
		}
		//左右同时为空座， 左或者右加一不为空座
		if(l1State == SeatNormal && r1State == SeatNormal && (l2State != SeatNormal || r2State != SeatNormal)){
//            		alert("左右同时为空座， 左或者右加一不为空座");
			alertTips();
			return false;
		}
		//左边为空座， 左加一不能是自选、已售、无座
		if(l1State == SeatNormal){
			if(l2State != SeatNormal){
				//右边为自选， 右加一不为空（排除只有三个座位的情况）
				if(r1State == SeatSelected && r2State != SeatNormal){
				}else{
//            				alert("左边为空座， 左加一不能是自选、已售、无座");
					alertTips();
					return false;
				}
			}
			//左加一不能是自选、已售、无座（排除只剩三个、四个， 其中自选肯定是不允许的，应单独考虑）
			if(l2State == SeatSelected){
				alertTips();
				return false;
			}
			//左加一是已售、无座， 判断是否是只剩三个、四个座位的情况， 即当前点击座位相邻座位状态为可选和自选的个数， 大于等于4则提示
			if(l2State == SeatNone || l2State == SeatSold){
				var countObj = normalSeatBefor(_this, 1);//当成左边界来处理
				if(countObj[2] >= 3){//左边已经有一个空座位， 所以>=3
					alertTips();
					return false;
				}
			}
		}
		//右边为空座， 右加一不能是自选、已售、无座
		if(r1State == SeatNormal){
			if(r2State != SeatNormal ){
				if(l1State == SeatSelected && l2State != SeatNormal){
				}else{
//            				alert("右边为空座， 右加一不能是自选、已售、无座");
					alertTips();
					return false;
				}
			}
			//右加一不能是自选、已售、无座
			if(r2State == SeatSelected){
				alertTips();
				return false;
			}
			if(r2State == SeatNone || r2State == SeatSold){
				var countObj = normalSeatBefor(_this, 2);//当成右边界来处理
				if(countObj[2] >= 3){
					alertTips();
					return false;
				}
			}
		}
		
	}
	return true;
	
}
function normalSeatBefor(_this, type){//type: 1, 左边界 type: 2, 右边界
	var tempSeat = _this;
	var normalSeat = 0;
	var selectedSeat = 0;
	var preSeat = "";
	var nextSeat = "";
	var flag = true;
	if(type == 2){
		do{
			preSeat = tempSeat.prev();
			if(preSeat.attr("class") == "Seat Select"){
				selectedSeat ++;
			}else if(preSeat.attr("class") == "Seat"){
				normalSeat ++;
			}else{
				flag = false;
			}
			tempSeat = preSeat;
		}while(flag);
	}else{
		do{
			nextSeat = tempSeat.next();
			if(nextSeat.attr("class") == "Seat Select"){
				selectedSeat ++;
			}else if (nextSeat.attr("class") == "Seat"){
				normalSeat ++;
			}else{
				flag = false;
			}
			tempSeat = nextSeat;
		}while(flag);
	}
	return [normalSeat, selectedSeat,(normalSeat+selectedSeat)];
}
function alertTips(){
	$(".Cover").attr("style", "");
	$(".Tips").text("亲， 不要留下单个座位哦");
	setTimeout(function(){
		$(".Cover").attr("style", "display:none");
	}, 1300);
}