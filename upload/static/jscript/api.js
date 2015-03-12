
var CoreAPI = {
	param: '',
		
	init: function(params){
		this.param = params;
	},
	login: function(){
		var html = '';
		
		html += '<div style="background:#fff; border:1px #dfdfdf solid; position:absolute; min-height:300px; min-width:500px; top:100px; left:400px;">';
		html += '<div style="padding:10px;">';		
		html += '<iframe src="' + this.param.url + 'apps/frame/' + this.param.id + '/" style="width:490px; height:290px;" />';		
		html += '</div>';
		html += '</div>';
		
		document.getElementById('coreapi').innerHTML = html;
	}	
};	
