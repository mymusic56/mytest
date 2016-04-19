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
								comments管理
								<small>
									<i class="icon-double-angle-right"></i>
									 <?=isset($comment['Comment']['id']) ? '编辑':'添加' ?>comments
								</small>
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
											<h4 class="lighter">
											<div class="row-fluid wizard-actions" style="float:left">
									<i class="icon-hand-right icon-animated-hand-pointer blue"></i>
									<span class="pink"> 请输入comments的真实信息 </span>
									</div>
									<div class="row-fluid wizard-actions">
										<button class="btn btn-success btn-prev">
											<i class="icon-arrow-left"></i>
											返回
										</button>
									</div>
								</h4>
								<div class="hr hr-18 hr-double dotted"></div>
											<form class="form-horizontal" id="sample-form" action='/comment/save' method=POST>

																<div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">最初发表的评论ID</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][basic_id]' placeholder='最初发表的评论ID' value="<?=isset($comment['basic_id']) ? $comment['basic_id'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">课件ID</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][book_id]' placeholder='课件ID' value="<?=isset($comment['book_id']) ? $comment['book_id'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">评内容</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][comment]' placeholder='评内容' value="<?=isset($comment['comment']) ? $comment['comment'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">是否允许公开（1是，其它否）</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][enabled]' placeholder='是否允许公开（1是，其它否）' value="<?=isset($comment['enabled']) ? $comment['enabled'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">评分（星级）</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][grade]' placeholder='评分（星级）' value="<?=isset($comment['grade']) ? $comment['grade'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">编号</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][id]' placeholder='编号' value="<?=isset($comment['id']) ? $comment['id'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">是否允许回复（1是，其它否）</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][is_open]' placeholder='是否允许回复（1是，其它否）' value="<?=isset($comment['is_open']) ? $comment['is_open'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">回复的评论ID</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][parent_id]' placeholder='回复的评论ID' value="<?=isset($comment['parent_id']) ? $comment['parent_id'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">发表时间</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][publish_time]' placeholder='发表时间' value="<?=isset($comment['publish_time']) ? $comment['publish_time'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div><div class="form-group">
																	<label for="inputError" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right grey">用户编号</label>

																	<div class="col-xs-12 col-sm-5">
																		<span class="block input-icon input-icon-right">
																			<input type="text" id="inputError" name='data[Comment][user_id]' placeholder='用户编号' value="<?=isset($comment['user_id']) ? $comment['user_id'] : ''?>" class="width-100" />
																			<i class="icon-phone orange"></i>
																		</span>
																	</div>
																	<div class="help-block col-xs-12 col-sm-reset inline"></div>
																</div>

																
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												保存
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="icon-undo bigger-110"></i>
												重置
											</button>
										</div>
									</div>

															</form>
															</div>
															</div>

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

					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
