var validation = {
    ajaxLoader: '<img src="http://www.51yilife.com/img/ajax-loader.gif" alt="" />',
    imgWarning: '<img src="http://r.51yilife.com/wap/images/th.png" alt="" />',
	isEmpty:function(str){
		if(null == str || typeof(str) == "undefined" || "" == str){
			return true;
		}
        return str.replace(/(^\s*)|(\s*$)/g, "").length == 0;
	},
	//返回字节数长度
	getLength:function(str){
		if(this.isEmpty(str)){
			return 0;
		}
		return str.replace(/[^\x00-\xff]/g,"**").length;
	},
	isUsername:function(fld) {
		var illegalChars = /\W/; // allow letters, numbers and underscores
		if (fld.length < 5 || fld.length > 15) {
			return false;
		} else if (illegalChars.test(fld)) {
			return false;
		}
		return /^[A-Za-z][A-Za-z0-9_]+$/.test(fld);
	},
	isMobile:function(str) {
		/*return /^1[0-9]{10}$/.test(str);*/
        return /^1[3,4,5,7,8]{1}[0-9]{1}[0-9]{8}$/.test(str);
	},
	isEmail:function(str){
		return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(str);
	},
	isInteger:function(str){
		return /^\d+$/.test(str);
	},
	isDouble:function(str){
		return /^(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/.test(str);
	},
	isNumber:function(str){
		return /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/.test(str);
	},
	isOnlyLetter:function(str){
		return /^[A-Za-z]+$/.test(str);
	},
	isOnlyLetterNumber:function(str){
		return /^[0-9a-zA-Z]+$/.test(str);
	},
	isFirstLetterOnlyLetterNumber:function(str){
		return /^[a-zA-Z][0-9a-zA-Z]*$/.test(str);	
	},
	isOnlyLetterNumberUnderline:function(str){
		return /^[0-9a-z][\w-.]*[0-9a-z]$/.test(str);
	},
	isFirstLetterOnlyLetterNumberUnderline:function(str){
		return /^[a-zA-Z][a-zA-Z0-9_]*$/.test(str);
	},
	isOnlyChinese:function(str){
		return /^[\u4e00-\u9fa5]+$/.test(str);
	},
	isUrl:function(str){
		return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/.test(str);
	},
	isIdCardNo:function(str){
		return /^((11|12|13|14|15|21|22|23|31|32|33|34|35|36|37|41|42|43|44|45|46|50|51|52|53|54|61|62|63|64|65|71|81|82|91)\d{4})((((19|20)(([02468][048])|([13579][26]))0229))|((20[0-9][0-9])|(19[0-9][0-9]))((((0[1-9])|(1[0-2]))((0[1-9])|(1\d)|(2[0-8])))|((((0[1,3-9])|(1[0-2]))(29|30))|(((0[13578])|(1[02]))31))))((\d{3}(x|X))|(\d{4}))$/.test(str);
	},
	isPhone:function(str){
		return /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/.test(str);
	},
	isZip:function(str){
		return /^[1-9][0-9]{5}$/.test(str);
	},
	isTelecomPhone:function(str){
		return /^(133|153|180|181|189)\d{8}$/.test(str);
	},
	isPhoneNum:function(str){
		return /^(13|14|15|18)\d{9}$/.test(str);
	},
    isCode:function(str) {
        return /^\d{10}$/.test(str);
    },
    today: function() {
        var date = new Date();
        var year = date.getFullYear(),
            month = date.getMonth() + 1,
            day = date.getDate();

        if (month < 10) { month = '0' + month; }
        if (day < 10) { day = '0' + day; }

        return year + '-' + month + '-' + day;
    },
    addCommas: function(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    },
    //##### start add by zk 检测手机号码是什么运营商
    checkMobileType: function(mobile) {

        if(/^(134|135|136|137|138|139|147|150|151|152|157|158|159|178|182|183|184|187|188)\d{8}$/.test(mobile)){
            return 'move';
        }else if(/^(130|131|132|155|156|185|186)\d{8}$/.test(mobile)){
            return 'unicom';
        }else if(/^(133|153|177|180|189)\d{8}$/.test(mobile)){
            return 'telecom';
        }

    }
    //##### end
};