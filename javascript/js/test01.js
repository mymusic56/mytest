var ajax_request = {
		type : '',
		url : '',
		data : '',
		callback:'',
		asyn:false,
		
		myAajax : function (){
		    var  xhr ='';
		    if(window.XMLHttpRequest){
		        xhr = new XMLHttpRequest();
		    }else{
		        xhr =new ActiveXObject(' Microsoft . XMLHTTP')
		    }
		    xhr.onreadystatechange =function() {
		    	if (xhr.readyState === 4 && this.callback) {
		            //回调
		            console.log('success');
		        }
		    };
			if(this.type.toLowerCase() == 'get'){
				this.url += "?"+this.data;
			}
		    
		    xhr.open(this.type, this.url, this.asyn);

		    console.log(this.data);
		    
		    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		    xhr.send(this.data);
		}
};