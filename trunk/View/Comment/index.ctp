				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#">首页</a>
							</li>
							<li>XX配置</li>
							<li class="active">comments管理</li>
						</ul><!-- .breadcrumb -->

						<!-- div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div --><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								comments
								<small>
									<i class="icon-double-angle-right"></i>
									 查询列表
								</small>
							</h1>
						</div><!-- /.page-header -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive"><input type="button" value="高级查询" id="pro_search"/><input type="button" value="添加" id="add" onclick="window.location.href='/comment/edit';"/>
											<table id="commentList" class="table table-striped table-bordered table-hover">
											<input type='hidden' id='pageSize' value=20>
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th>
														<i class="icon-user bigger-110 hidden-480"></i>
														最初发表的评论ID</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														课件ID</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														评内容</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														是否允许公开（1是，其它否）</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														评分（星级）</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														编号</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														是否允许回复（1是，其它否）</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														回复的评论ID</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														发表时间</th><th>
														<i class="icon-user bigger-110 hidden-480"></i>
														用户编号</th>

														<th>编辑</th>
													</tr>
												</thead>

												<tbody>
												
												</tbody>
													<tfoot>

														<tr>
															<th></th>

															<th>最初发表的评论ID</th>
															<th>课件ID</th>
															<th>评内容</th>
															<th>是否允许公开（1是，其它否）</th>
															<th>评分（星级）</th>
															<th>编号</th>
															<th>是否允许回复（1是，其它否）</th>
															<th>回复的评论ID</th>
															<th>发表时间</th>
															<th>用户编号</th>
															
															<th></th>

														</tr>

													</tfoot>												
											</table>
										</div>
									</div>
								</div>

									</div><!-- /.modal-dialog -->
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
<div id="myModal" class="bootbox modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class='modal-title'>
用户信息高级查询
<button type="button" class="bootbox-close-button close" id="cls" data-dismiss="modal">&times;</button>
</h4>
</div>
<!-- dialog body -->
<div class="modal-body">
<div class='bootbox-body'>
<div class="row">
<form class='bootbox-form form-horizontal' id="search_form">
<div class="col-md-12">
				  <div class="form-group">
				 <label class="col-md-4 control-label" for="name">最初发表的评论ID</label>
				  <div class="col-md-7">
				  <input id="data[Comment][basic_id]" name="data[Comment][basic_id]" type="text" placeholder="请输入最初发表的评论ID" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">课件ID</label>
				  <div class="col-md-7">
				  <input id="data[Comment][book_id]" name="data[Comment][book_id]" type="text" placeholder="请输入课件ID" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">评内容</label>
				  <div class="col-md-7">
				  <input id="data[Comment][comment]" name="data[Comment][comment]" type="text" placeholder="请输入评内容" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">是否允许公开（1是，其它否）</label>
				  <div class="col-md-7">
				  <input id="data[Comment][enabled]" name="data[Comment][enabled]" type="text" placeholder="请输入是否允许公开（1是，其它否）" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">评分（星级）</label>
				  <div class="col-md-7">
				  <input id="data[Comment][grade]" name="data[Comment][grade]" type="text" placeholder="请输入评分（星级）" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">编号</label>
				  <div class="col-md-7">
				  <input id="data[Comment][id]" name="data[Comment][id]" type="text" placeholder="请输入编号" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">是否允许回复（1是，其它否）</label>
				  <div class="col-md-7">
				  <input id="data[Comment][is_open]" name="data[Comment][is_open]" type="text" placeholder="请输入是否允许回复（1是，其它否）" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">回复的评论ID</label>
				  <div class="col-md-7">
				  <input id="data[Comment][parent_id]" name="data[Comment][parent_id]" type="text" placeholder="请输入回复的评论ID" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">发表时间</label>
				  <div class="col-md-7">
				  <input id="data[Comment][publish_time]" name="data[Comment][publish_time]" type="text" placeholder="请输入发表时间" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div><div class="form-group">
				 <label class="col-md-4 control-label" for="name">用户编号</label>
				  <div class="col-md-7">
				  <input id="data[Comment][user_id]" name="data[Comment][user_id]" type="text" placeholder="请输入用户编号" class="form-control input-md">
				  <!--span class="help-block">Here goes your name</span-->
				  </div>
				  </div>

</div>
</form>
</div>
</div>
</div>
<!-- dialog buttons -->
<div class="modal-footer"><button type="button" id="bt_close" class="btn btn-sm">OK</button></div>
</div>
</div>
</div>		
<style>.datepicker{z-index: 99999 !important}</style>
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/assets/js/bootstrap.min.js"></script>
		<script src="/assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="/assets/js/jquery.dataTables.min.js"></script>
		<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>

		<!-- page specific plugin scripts -->
		<script src="/assets/js/bootbox.min.js"></script>
		<!-- ace scripts -->

		<script src="/assets/js/ace-elements.min.js"></script>
		<script src="/assets/js/ace.min.js"></script>

		<script src="/assets/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="/assets/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="/assets/js/date-time/moment.min.js"></script>
		<script src="/assets/js/date-time/daterangepicker.min.js"></script>
		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
			$('#ample-table-2 tfoot th').each( function () {

					var title = $('#ample-table-2 thead th').eq( $(this).index() ).text();

					$(this).html( '<input type="text" placeholder="Search '+title+'" />' );

				} );				
			var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,
				  { "bSortable": false }
				] } );
				
			$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				$("#pro_search").on(ace.click_event, function() {
$("#myModal").modal({ // wire up the actual modal functionality and show the dialog
"backdrop" : "static",
"keyboard" : true,
"show" : true // ensure the modal is shown immediately
});			
				});
				$("#pro_search1").on(ace.click_event, function() {

					bootbox.dialog({
					title: "高级查询",
					message: '<div class="row">  ' +
				  '<div class="col-md-12"> ' +
				  '<form class="form-horizontal"> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">最初发表的评论ID</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="最初发表的评论ID" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">课件ID</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="课件ID" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">评内容</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="评内容" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">是否允许公开（1是，其它否）</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="是否允许公开（1是，其它否）" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">评分（星级）</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="评分（星级）" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">编号</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="编号" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">是否允许回复（1是，其它否）</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="是否允许回复（1是，其它否）" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">回复的评论ID</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="回复的评论ID" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">发表时间</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="发表时间" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +
				  '<div class="form-group"> ' +
				  '<label class="col-md-4 control-label" for="name">用户编号</label> ' +
				  '<div class="col-md-7"> ' +
				  '<input id="name" name="name" type="text" placeholder="用户编号" class="form-control input-md"> ' +
				  /*'<span class="help-block">Here goes your name</span> */'</div> ' +
				  '</div> ' +


				  '</form> </div>  </div>',
						buttons: 			
						{
							"click" :
							{
								"label" : "查询",
								"className" : "btn-sm btn-primary",
								"callback": function() {
									alert("保存按钮信息");
								}
							}, 
							"button" :
							{
								"label" : "取消",
								"className" : "btn-sm"
							}
						}
					});
				});

$("#myModal").on("show", function() { // wire up the OK button to dismiss the modal when shown
});
$("#myModal #bt_close").on("click", function(e) {
$("#myModal").modal('hide'); // dismiss the dialog
search(1);
});
 


$("#myModal").on("hide", function() { // remove the event listeners when the dialog is dismissed
$("#myModal a.btn").off("click");
});
$("#myModal").on("hidden", function() { // remove the actual elements from the DOM when fully hidden
$("#myModal").remove();
});
/*
$("#datepicker").datepicker({
        showOtherMonths: true,
    });
	*/
$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				});
function search(page)
{
var data = {};
$("#search_form").find(".form-group").each(function(){
var field = $(this);
var finput = field.find("input");
data[finput.attr('name')] = field.val();
});
var pageSize = $('#pageSize').val();
        $.ajax({
            type: 'POST',
            url: '/comment/search/'+pageSize+'/'+page,
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result.error != '') {
                } else {

		if(result.data.length > 0)
		{
		var rows = "";
		for(var i = 0;i < result.data.length;i++)
		{
			rows += "<tr>";
			rows += "<td class=\"center\">";
			rows += "<label>";
			rows += "<input type=\"checkbox\" id='' class=\"ace\" />";
			rows += "<span class=\"lbl\"></span>";
			rows += "</label>";
			rows += "</td>";

			for(var j = 0;j < result.data[i].length;j++)
			{
				rows += "<td>";
				rows += "<a href=\"/comment/edit/"+result.data[i][j].id+"\">"+result.data[i][j].id+"</a>";
				rows += "</td>";
			}
			rows += "<td>";
			rows += "<div class=\"visible-md visible-lg hidden-sm hidden-xs action-buttons\">";
			rows += "<a class=\"blue\" href=\"#\">";
			rows += "<i class=\"icon-zoom-in bigger-130\"></i>";
			rows += "</a>";
			rows += "<a class=\"green\" href=\"#\">";
			rows += "<i class=\"icon-pencil bigger-130\"></i>";
			rows += "</a>";

			rows += "<a class=\"red\" href=\"#\">";
			rows += "<i class=\"icon-trash bigger-130\"></i>";
			rows += "</a>";
			rows += "</div>";

			rows += "<div class=\"visible-xs visible-sm hidden-md hidden-lg\">";
			rows += "<div class=\"inline position-relative\">";
			rows += "<button class=\"btn btn-minier btn-yellow dropdown-toggle\" data-toggle=\"dropdown\">";
			rows += "<i class=\"icon-caret-down icon-only bigger-120\"></i>";
			rows += "</button>";

			rows += "<ul class=\"dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close\">";
			rows += "<li>";
			rows += "<a href=\"#\" class=\"tooltip-info\" data-rel=\"tooltip\" title=\"View\">";
			rows += "<span class=\"blue\">";
			rows += "<i class=\"icon-zoom-in bigger-120\"></i>";
			rows += "</span>";
			rows += "</a>";
			rows += "</li>";

			rows += "<li>";
			rows += "<a href=\"#\" class=\"tooltip-success\" data-rel=\"tooltip\" title=\"Edit\">";
			rows += "<span class=\"green\">";
			rows += "<i class=\"icon-edit bigger-120\"></i>";
			rows += "</span>";
			rows += "</a>";
			rows += "</li>";

			rows += "<li>";
			rows += "<a href=\"#\" class=\"tooltip-error\" data-rel=\"tooltip\" title=\"Delete\">";
			rows += "<span class=\"red\">";
			rows += "<i class=\"icon-trash bigger-120\"></i>";
			rows += "</span>";
			rows += "</a>";
			rows += "</li>";
			rows += "</ul>";
			rows += "</div>";
			rows += "</div>";
			rows += "</td>";
			rows += "</tr>";
		}
		$("#commentList").find("tbody").html(rows);
		}

                }
            }, error: function(a, b, c) {
                alert(a.responseText);
            }
        });

}
		</script>
				</div><!-- /.main-content -->
