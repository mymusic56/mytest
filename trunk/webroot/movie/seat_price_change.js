var whiteList = $("#whiteList").val();
var vipPrice = 5;
function recalculatePrice(tempPrice, ticketNum, price){
	if(ticketNum == 0){
		return 0;
	}
	if(whiteList == "1" && price <= 45){
		if(ticketNum <= 2){
			tempPrice = vipPrice;
		}else{
			tempPrice = 5+(ticketNum-2)*price;
		}
	}
	return tempPrice;
}