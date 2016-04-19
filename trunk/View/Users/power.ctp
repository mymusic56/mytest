
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>控制台 - Bootstrap后台管理系统模版Ace下载</title>
		<meta name="keywords" content="Bootstrap模版,Bootstrap模版下载,Bootstrap教程,Bootstrap中文" />
		<meta name="description" content="站长素材提供Bootstrap模版,Bootstrap教程,Bootstrap中文翻译等相关Bootstrap插件下载" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		<link href="/assets/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/assets/assets/css/font-awesome.min.css" />
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
		<link rel="stylesheet" href="/assets/assets/css/ace.min.css" />
		<link rel="stylesheet" href="/assets/assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/assets/assets/css/ace-skins.min.css" />
		<script src="/assets/assets/js/ace-extra.min.js"></script>
	</head>

	<body>
	
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							兰朵科技有限公司日常办公系统
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>
							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-ok"></i>
									还有4个任务完成
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">软件更新</span>
											<span class="pull-right">65%</span>
										</div>

										<div class="progress progress-mini ">
											<div style="width:65%" class="progress-bar "></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">硬件更新</span>
											<span class="pull-right">35%</span>
										</div>
										<div class="progress progress-mini ">
											<div style="width:35%" class="progress-bar progress-bar-danger"></div>
										</div>
									</a>
								</li>
								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">单元测试</span>
											<span class="pull-right">15%</span>
										</div>
										<div class="progress progress-mini ">
											<div style="width:15%" class="progress-bar progress-bar-warning"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">错误修复</span>
											<span class="pull-right">90%</span>
										</div>

										<div class="progress progress-mini progress-striped active">
											<div style="width:90%" class="progress-bar progress-bar-success"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										查看任务详情
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-warning-sign"></i>
									8条通知
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												新闻评论
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary icon-user"></i>
										切换为编辑登录..
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success icon-shopping-cart"></i>
												新订单
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-info icon-twitter"></i>
												粉丝
											</span>
											<span class="pull-right badge badge-info">+11</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										查看所有通知
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-envelope-alt"></i>
									5条消息
								</li>

								<li>
									<a href="#">
										<img src="/assets/assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Alex:</span>
												不知道写啥 ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>1分钟以前</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#">
										<img src="/assets/assets/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Susan:</span>
												不知道翻译...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>20分钟以前</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="#">
										<img src="/assets/assets/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue">Bob:</span>
												到底是不是英文 ...
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>下午3:15</span>
											</span>
										</span>
									</a>
								</li>

								<li>
									<a href="inbox.html">
										查看所有消息
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/assets/assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small>
									Jason
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										设置
									</a>
								</li>

								<li>
									<a href="#">
										<i class="icon-user"></i>
										个人资料
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="#">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>

					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>

							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>

							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>

							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div>

						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div><!-- #sidebar-shortcuts -->

					<ul class="nav nav-list">
						<li class="active">
							<a href="index.html">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> 任务概览 </span>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-text-width"></i>
								<span class="menu-text"> 流程管理 </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								<li>
									<a href="typography.html">
										<i class="icon-double-angle-right"></i>
										发起流程
									</a>
								</li>

								<li>
									<a href="elements.html">
										<i class="icon-double-angle-right"></i>
										等我处理的任务
									</a>
								</li>
							
								<li>
									<a href="elements.html">
										<i class="icon-double-angle-right"></i>
										已经处理过的任务
									</a>
								</li>

								<li>
									<a href="elements.html">
										<i class="icon-double-angle-right"></i>
										制定新的流程
									</a>
								</li>

							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text"> 公司资产 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="elements.html">
										<i class="icon-double-angle-right"></i>
										固定资产管理
									</a>
								</li>

								<li>
									<a href="buttons.html">
										<i class="icon-double-angle-right"></i>
										借出统计
									</a>
								</li>

								<li>
									<a href="treeview.html">
										<i class="icon-double-angle-right"></i>
										入库统计
									</a>
								</li>

								<li>
									<a href="nestable-list.html">
										<i class="icon-double-angle-right"></i>
										资产折旧率
									</a>
								</li>

								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>

										废旧资产管理
										<b class="arrow icon-angle-down"></b>
									</a>

									<ul class="submenu">
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												待处理废旧资产
											</a>
										</li>

										<li>
											<a href="#" class="dropdown-toggle">
												<i class="icon-pencil"></i>

												已处理废旧资产
												<b class="arrow icon-angle-down"></b>
											</a>

											<ul class="submenu">
												<li>
													<a href="#">
														<i class="icon-plus"></i>
														已卖出资产
													</a>
												</li>

												<li>
													<a href="#">
														<i class="icon-eye-open"></i>
														已回收处理
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> 系统配置 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="s_user.html" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>
										用户管理
									</a>
								</li>
								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-double-angle-right"></i>
										权限管理
									<b class="arrow icon-angle-down"></b>
									</a>
									<ul class="submenu">
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												权限分配处理
											</a>
										</li>
										<li>
											<a href="#">
												<i class="icon-leaf"></i>
												系统模块管理
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-edit"></i>
								<span class="menu-text"> 表单 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="form-elements.html">
										<i class="icon-double-angle-right"></i>
										表单组件
									</a>
								</li>

								<li>
									<a href="form-wizard.html">
										<i class="icon-double-angle-right"></i>
										向导提示 &amp; 验证
									</a>
								</li>

								<li>
									<a href="wysiwyg.html">
										<i class="icon-double-angle-right"></i>
										编辑器
									</a>
								</li>

								<li>
									<a href="dropzone.html">
										<i class="icon-double-angle-right"></i>
										文件上传
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="widgets.html">
								<i class="icon-list-alt"></i>
								<span class="menu-text"> 插件 </span>
							</a>
						</li>

						<li>
							<a href="calendar.html">
								<i class="icon-calendar"></i>

								<span class="menu-text">
									日历
									<span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">
										<i class="icon-warning-sign red bigger-130"></i>
									</span>
								</span>
							</a>
						</li>

						<li>
							<a href="gallery.html">
								<i class="icon-picture"></i>
								<span class="menu-text"> 相册 </span>
							</a>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-tag"></i>
								<span class="menu-text"> 更多页面 </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="profile.html">
										<i class="icon-double-angle-right"></i>
										用户信息
									</a>
								</li>

								<li>
									<a href="inbox.html">
										<i class="icon-double-angle-right"></i>
										收件箱
									</a>
								</li>

								<li>
									<a href="pricing.html">
										<i class="icon-double-angle-right"></i>
										售价单
									</a>
								</li>

								<li>
									<a href="invoice.html">
										<i class="icon-double-angle-right"></i>
										购物车
									</a>
								</li>

								<li>
									<a href="timeline.html">
										<i class="icon-double-angle-right"></i>
										时间轴
									</a>
								</li>

								<li>
									<a href="login.html">
										<i class="icon-double-angle-right"></i>
										登录 &amp; 注册
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-file-alt"></i>

								<span class="menu-text">
									其他页面
									<span class="badge badge-primary ">5</span>
								</span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<li>
									<a href="faq.html">
										<i class="icon-double-angle-right"></i>
										帮助
									</a>
								</li>

								<li>
									<a href="error-404.html">
										<i class="icon-double-angle-right"></i>
										404错误页面
									</a>
								</li>

								<li>
									<a href="error-500.html">
										<i class="icon-double-angle-right"></i>
										500错误页面
									</a>
								</li>

								<li>
									<a href="grid.html">
										<i class="icon-double-angle-right"></i>
										网格
									</a>
								</li>

								<li>
									<a href="blank.html">
										<i class="icon-double-angle-right"></i>
										空白页面
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

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
							<li class="active">控制台</li>
						</ul><!-- .breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								控制台
								<small>
									<i class="icon-double-angle-right"></i>
									 查看
								</small>
							</h1>
						</div>

						<div class="row">
							<div class="col-xs-12">
										<div class="tabbable">
											<ul class="nav nav-tabs" id="myTab">
												<li class="active">
													<a data-toggle="tab" href="#home">
														<i class="green icon-home bigger-110"></i>
														权限分配
													</a>
												</li>

												<li>
													<a data-toggle="tab" href="#profile">
														角色管理
														<span class="badge badge-danger">4</span>
													</a>
												</li>

											</ul>

											<div class="tab-content">
												<div id="home" class="tab-pane in active">
												<div class="row">
													<div class="col-xs-3">
											
											          <li class="dd-item" data-id="3">
															<div class="dd-handle">
																角色显示区域
																<a data-rel="tooltip" data-placement="left" title="Change Event Date" href="#" class="tooltip-info pull-right no-hover-underline">
																	<i class="bigger-120 icon-calendar"></i>
																</a>
															</div>
														</li>
											
											   <div data-toggle="buttons" class="btn-group">
												<label class="btn btn-sm" id="forbid">
													权限限制
												</label>
												<label class="btn btn-sm" id="open">
													显示权限
												</label>
											  </div>
											
											
											
											<div id="forope">
											   <ol class="dd-list">	
												
											   </ol>
											</div>
											
											
											
											
												
                                               <div class="space-2"></div>

													<div class="table-responsive">
											
													</div>
													</div>
													<div class="col-xs-5 ">
													<div class="dd">
													<ol class="dd-list">
													<?php foreach($result as $re){
														$fan = explode("/", $re['des']['url']);
														
													       if(count($fan)>=2){
													?>
												<li class="dd-item" data-id="1">
												<div class="dd2-content">
													<label class="block">
														<input name="form-field-checkbox" type="checkbox" class="ace ace-checkbox-2" value="<?php 
														echo $re['des']['url'];
														?>"/>
														<span class="lbl"> <?php echo $re['des']['description'];?></span>
																<a data-rel="tooltip" data-placement="left" title="Change Event Date" href="#" class="tooltip-info pull-right no-hover-underline">
																	<i class="bigger-120 icon-list"></i>
																</a>
													</label>
												</div>
												</li>
                                           <?php  }}?>
												
											</ol>
											</div>
													</div>
													<div class="col-xs-4"">
											<div data-toggle="buttons" class="btn-group">
												<label class="btn btn-sm" id="power">
													权限开放
												</label>
											</div>
													</div>
												</div>
												</div>
												<div id="profile" class="tab-pane">
													<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
													
													 <div class="input-group">
													   <ol class="dd-list">
													      <?php foreach($groups as $group){
													    ?>
													     <li class="dd-item" data-id="3">
													     <div class="dd-handle">
													        <?php echo $group['groups']['name']?>
														<i class="bigger-120 icon-calendar"></i>
													     </div>
												     </li>
													      <?php }?>
													 </ol>
												</div>
												
												
												<div data-toggle="buttons" class="btn-group">
												<label class="btn btn-sm" id="administrator">
													设置超级管理员
												</label>
												<label class="btn btn-sm" id="disable">
													用户组禁用
												</label>
												<label class="btn btn-sm" id="enable">
													用户组启用
												</label>
												</label>
												<label class="btn btn-sm" id="groupdelete">
													用户组删除
												</label>
											  </div>
												
													</p>
												</div>

											</div>
										</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; 选择皮肤</span>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl">切换到左边</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">
								切换窄屏
								<b></b>
							</label>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div>

		<script src="/assets/assets/js/jquery-2.0.3.min.js"></script>

		

		<script type="text/javascript">
			window.jQuery || document.write("<script src='/assets/assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
		</script>

		

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/assets/assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="/assets/assets/js/bootstrap.min.js"></script>
		<script src="/assets/assets/js/typeahead-bs2.min.js"></script>

		
		<script src="/assets/assets/js/jquery.nestable.min.js"></script>

		<script src="/assets/assets/js/ace-elements.min.js"></script>
		<script src="/assets/assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">

		$(function(){     //角色选取
			$(".tab-pane .dd-list  .dd-handle").on("click",function(){
               var role =  $(this).text();
                $(".col-xs-3 .dd-handle").html(role);
				});
			});

		$(function(){   //超级权限
            $("#administrator").on("click",function(){
            	 var role = $(".col-xs-3 .dd-handle").text();

            	 $.ajax({
 		            type:'POST',
 		            dataType:'json',
 		            url:'../user/administrator',
 		            data: {role:role},
 		            success: function(result) {
 	 		            alert(result);
 		            }
            	 });
                });
			}); 

		$(function(){  //用户组权限禁用
            $("#disable").on("click",function(){
            	 var role = $(".col-xs-3 .dd-handle").text();

            	 $.ajax({
 		            type:'POST',
 		            dataType:'json',
 		            url:'../user/disable',
 		            data: {role:role},
 		            success: function(result) {
 	 		            alert(result);
 		            }
            	 });
                });
			}); 

		
		$(function(){  //用户组权限启用
            $("#enable").on("click",function(){
            	 var role = $(".col-xs-3 .dd-handle").text();

            	 $.ajax({
 		            type:'POST',
 		            dataType:'json',
 		            url:'../user/enable',
 		            data: {role:role},
 		            success: function(result) {
 	 		            alert(result);
 		            }
            	 });
                });
			}); 

		$(function(){  //用户组删除
            $("#groupdelete").on("click",function(){
            	 var role = $(".col-xs-3 .dd-handle").text();

            	 $.ajax({
 		            type:'POST',
 		            dataType:'json',
 		            url:'../user/groupdelete',
 		            data: {role:role},
 		            success: function(result) {
 	 		            alert(result);
 		            }
            	 });
                });
			}); 
		

		$(function(){    //权限显示
            $("#open").on("click",function(){
           	 var role = $(".col-xs-3 .dd-handle").text();
          
           	 $.ajax({
		            type:'POST',
		            dataType:'json',
		            url:'../user/show',
		            data: {role:role},
		            success: function(result) {
		            	 if(result.length == 12){
		 		        	  alert(result);
		 		        	  return;
			 		       }
			 		       if(result.length == 15){
                              alert(result);
                              return;
				 		   }
	 		         var wr = "  ";
	 		         for(var i = 0 ; i <= result.length - 1 ; i++){    
	 		         var w = ' <li class="dd-item" data-id="1"> '+
							 ' <div class="dd2-content"> '+
							 ' <label class="block"> '+
							 ' <input name="form-field-checkbox" type="checkbox" class="ace ace-checkbox-2" value="'+result[i].des.url+'"/> '+
							 ' <span class="lbl"> '+result[i].des.description +' </span> '+
							 ' <a data-rel="tooltip" data-placement="left" title="Change Event Date" href="#" class="tooltip-info pull-right no-hover-underline"> ' +
							 ' <i class="bigger-120 icon-list"></i> '+
							 '	</a> '+
							 ' </label> ' +
							 ' </div> ' +
							 ' </li> '
							 wr += w+" ";
		 		            }

	 		           $("#forope .dd-list").html(wr);  
		            }
           	 });
                });
            });


         $(function(){    //权限开放
             $("#power").on("click",function(){
            	 var chk_value =[]; 
            	 var role = $(".col-xs-3 .dd-handle").text();
            	 
            
                 var allow = $(".col-xs-5 input:checkbox[name='form-field-checkbox']:checked").next().text(); //选择复选框的值
                 
            	  $('.col-xs-5 input[name="form-field-checkbox"]:checked').each(function(){
            	   chk_value.push($(this).val());
            	   });	
                
            	 $.ajax({
 		            type:'POST',
 		            dataType:'json',
 		            url:'../user/power',
 		            data: {allow:allow,url:chk_value,role:role},
 		            success: function(result) {
 	 		            alert(result);
 		            }
            	 });
                 });
             });


         $(function(){   //权限禁止
             $("#forbid").on("click",function(){
            	 var chk_value =[]; 
                 var forbid = $("#forope input:checkbox[name='form-field-checkbox']:checked").next().text(); //选择复选框的值
                 var role = $(".col-xs-3 .dd-handle").text();//选取角色
            	  $('#forope .dd-list input[name="form-field-checkbox"]:checked').each(function(){
            	   chk_value.push($(this).val());
            	   });	
                
            	 $.ajax({
 		            type:'POST',
 		            dataType:'json',
 		            url:'../user/forbid',
 		            data:{forbid:forbid,url:chk_value,role:role},
 		            success: function(result) {
 	 		            alert(result);
 		            }
            	 });
                 });
             });




		
			jQuery(function($) {
				$('.dd').nestable();
				$(".dd-handle").on("click",function(){
					$(".btn-yellow.no-hover").each(function(){
						$(this).removeClass("btn-yellow no-hover");
					});
					$(this).addClass("btn-yellow no-hover");
				});
				$(".dd2-content .ace-checkbox-2").on("click",function(){
					if($(this).is(":checked"))
					{
						$(this).parents(".dd2-content").addClass("btn-success");
					}
					else
					{
						$(this).parents(".dd2-content").removeClass("btn-success");
					}
				});
			});
		</script>
</body>
</html>

