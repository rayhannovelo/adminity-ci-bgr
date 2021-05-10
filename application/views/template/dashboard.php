<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo isset($meta_title)?$meta_title:'Carolina | PT. Bhanda Ghara Reksa (Persero)'; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="#">
	<meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
	<meta name="author" content="#">
	<!-- Favicon icon -->
	<link rel="icon" href="<?php echo base_url('assets/img/favicon.png');?>" style="height:50px; width:auto;" type="image/x-icon">
	<!-- Google font-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
	<!-- Required Fremwork -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/bootstrap/css/bootstrap.min.css">
	<!-- sweet alert framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/sweetalert/css/sweetalert.css">
	<!-- themify-icons line icon -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/themify-icons/themify-icons.css">
	<!-- ico font -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/icofont/css/icofont.css">
	<!-- feather Awesome -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/feather/css/feather.css">
	<!-- fontAwesome -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/font-awesome/css/font-awesome.min.css">
	
	<!-- Notification.css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/pages/notification/notification.css">

	<!-- Switch component css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/switchery/css/switchery.min.css">

	<!-- animation nifty modal window effects css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/css/component.css">
	<!-- nestable css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/pages/nestable/nestable.css">
	<!-- Select 2 css -->
	<link rel="stylesheet" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/select2/css/select2.min.css" />
	<!-- Multi Select css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/multiselect/css/multi-select.css" />

	<!-- Data Table Css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/pages/data-table/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

	<!-- Step -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery.steps/css/jquery.steps.css">

	<!-- Style.css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/css/jquery.mCustomScrollbar.css">

	<!-- <link rel="stylesheet" href="https://colorlib.com//polygon/adminty/files/assets/scss/partials/menu/_pcmenu.scss"> -->

	<!-- Migrate CSS -->
	<link href="<?php echo base_url('assets/template/dashboard'); ?>/assets/css/custom.css" rel="stylesheet" />

	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">

	<style type="text/css">
		.note-toolbar.card-header {
			padding: 0px;
		}

		.note-editor.card {
			margin-bottom: 0px;
		}
	</style>

	<script src="https://cdn.tiny.cloud/1/245hfbgitozns15ru2ixxtg28ccz2sdc11gx1a8hizfcqrd8/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
</head>

<body>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  // var OneSignal = window.OneSignal || [];
  // OneSignal.push(function() {
  //   OneSignal.init({
  //     appId: "d84db72c-1710-4333-b49e-d2a3f1b38c72",
  //     notifyButton: {
  //       enable: true,
  //     }
  //   });

  //   OneSignal.on('subscriptionChange', function (isSubscribed) {
	 //    // console.log("The user's subscription state is now:", isSubscribed);

  //   	// alert(userId);
	 //    OneSignal.getUserId(function(userId) {
	 //      	//console.log("OneSignal User ID:", userId);
	 //      	// (Output) OneSignal User ID: 270a35cd-4dda-4b3f-b04e-41d7463a2316
	 //      	if (userId!=null){
		// 		$.ajax({
		// 			url: site_url + '/user/add_player_id',
		// 			type: 'POST',
		// 			dataType: 'json',
		// 			data: {
		// 				player_id: userId
		// 			},
		// 			success: function (data, text) {
		// 			},
		// 			error: function (stat, res, err) {
		// 			}
		// 		});
		// 	}
	 //     });
	 //  });
  // });
</script>


	<script>
		var site_url = '<?php echo site_url(); ?>';
		var base_url = '<?php echo base_url(); ?>';
		var domain_url='http://<?php echo $_SERVER['HTTP_HOST'];?>';
	</script>
	<!-- Required Jquery -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery/js/jquery.min.js"></script>
	<!-- notification js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/js/bootstrap-growl.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/notification/notification.js"></script>

	<!-- Pre-loader start -->
	<div class="theme-loader">
		<div class="ball-scale">
			<!-- <div class='contain'>
				<img class="ring" style="height:100px; width:auto;" src="<?php echo base_url('assets/img/login_logo.png');?>">
			</div> -->
			<div class='contain'>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>

		</div>
	</div>
	<!-- Pre-loader end -->


	<div id="pcoded" class="pcoded">
		<div class="pcoded-overlay-box"></div>
		<div class="pcoded-container navbar-wrapper">

			<nav class="navbar header-navbar pcoded-header">
				<div class="navbar-wrapper">

					<div class="navbar-logo">
						<a class="mobile-menu" id="mobile-collapse" href="#!">
							<i class="feather icon-menu"></i>
						</a>
						<a href="<?php echo base_url();?>" style="padding-bottom: 5px;">
							<img class="img-fluid" src="<?php echo base_url('assets/img/login_logo.png');?>" style="height:25px;" alt="Theme-Logo" />
						</a>
						<a class="mobile-options">
							<i class="feather icon-more-horizontal"></i>
						</a>
					</div>

					<div class="navbar-container container-fluid">
						<ul class="nav-left">
							<!-- <li class="header-search">
								<div class="main-search morphsearch-search">
									<div class="input-group">
										<span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
										<input type="text" class="form-control">
										<span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
									</div>
								</div>
							</li> -->
							<li>
								<a href="#!" onclick="javascript:toggleFullScreen()">
									<i class="feather icon-maximize full-screen"></i>
								</a>
							</li>
						</ul>
						<ul class="nav-right">

							<li class="header-notification">
								<div class="dropdown-primary dropdown">
									<div class="dropdown-toggle" data-toggle="dropdown">
									<i class="feather icon-bell"></i>
									<span class="badge bg-c-pink"><?php echo $_count_notif; ?></span>
									</div>
									<ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
									</ul>
								</div>
							</li>		
							<script>
								getNotif();
								function getNotif(){
									$.ajax({
										url: site_url + '/notifikasi/get',
										type: 'POST',
										dataType: 'json',
										data: {limit:3,status:0},
										async: true,
										success: function (data, text) {
											var notifHtml = '<li><h6>Notifications</h6></li>';
											var count_notif = 0;
											for (var i = 0; i < data.length; i++) {
												count_notif++;
												notifHtml+='<li><a href="'+ site_url + 'notifikasi/link_notif/'+data[i].id+'" class="p-0"><div class="media"><div class="media-body"><h5 class="notification-user">'+data[i].title+'</h5><p class="notification-msg">'+data[i].detail+'</p><span class="notification-time">'+data[i].created_at+'</span></div></div></a></li>';
											}
											// target="_blank"
											if (count_notif>0){
												notifHtml+= '<li><a href="'+ site_url + 'notifikasi" class="p-0"><h6 class="text-center">Lihat Semua</h6></a></li>';
											}else{
												notifHtml+= '<li><h6 class="text-center">Tidak ada notifikasi baru</h6></li>';
											}
											$(".notification-view").html(notifHtml);
										},
										error: function (stat, res, err) {
											alert(err);
										}
									});

								}
								</script>


							<li class="user-profile header-notification">
								<div class="dropdown-primary dropdown">
									<div class="dropdown-toggle" data-toggle="dropdown">
										<!--
										<img src="<?php echo base_url(file_exists('upload/profil/'.$this->session->userdata("foto"))?'upload/profil/'.$this->session->userdata("foto"):'assets/img/profile.png');?>" class="img-radius img-profile" alt="User-Profile-Image">
										-->
										<img src="<?php echo base_url((! is_null($this->session->userdata("foto")) AND $this->session->userdata("foto") != '') ?'upload/profil/'.$this->session->userdata("foto"):'assets/img/profile.png');?>" class="img-radius img-profile" alt="User-Profile-Image">
										<span>
											<?php echo $this->session->userdata('name');?></span>
										<i class="feather icon-chevron-down"></i>
									</div>
									<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
										<li>
											<a href="<?php echo site_url('user/profile');?>">
												<i class="feather icon-user"></i> Profile
											</a>
										</li>
										<li id="dash_logout">
											<a href="javascript:void(0)" >
												<i class="feather icon-log-out"></i> Logout
											</a>
										</li>
									</ul>

								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">
					<nav class="pcoded-navbar">
						<div class="pcoded-inner-navbar main-menu" id="dash-menu">
							<script>
								var menuDash = $('#dash-menu');
								var listMenu = '';
								var child_active = null;
								var parent_active = null;
								getMenu();
								// Data
								function getMenu() {
									$.ajax({
										url: site_url + '/menu/get',
										type: 'GET',
										dataType: 'json',
										data: {
											id_role: '<?php echo $this->session->userdata("id_usr_role");?>'
										},
										async: false,
										success: function (data, text) {
											//console.log(data);

											listMenu = '';
											if(data.length>0)
											{
												renderMenu(data, 0);
												menuDash.html(listMenu);
												listMenu += '</div>\
												</nav>';
												$('#' + child_active).closest('.pcoded-hasmenu').attr('class', 'pcoded-hasmenu pcoded-trigger');
												
												parent_active=$('#' + child_active).closest('.pcoded-hasmenu').attr('id');

												//parent_active=$('#' + parent_active).closest('.pcoded-item').attr('id');
												//$('#' + parent_active).children('.pcoded-hasmenu').attr('class', 'pcoded-hasmenu pcoded-trigger');
											}
											else{
												menuDash.html(listMenu);
												listMenu += '</div>\
												</nav>';
											}
											

										},
										error: function (stat, res, err) {
											alert(err);
										}
									});
								}

								function renderMenu(menus, parentID) {
									for (var i = 0; i < menus.length; i++) {
										if (menus[i].parent == parentID) {
											if (menus[i].is_head_section == 1) {
												listMenu += '<div class="pcoded-navigatio-lavel">' + menus[i].label + '</div>';
												listMenu += '<ul id="pc' + menus[i].id_menu + '" class="pcoded-item pcoded-left-item">';
												if (menus[i].count_child > 0) {
													renderMenu(menus, menus[i].id_menu);
												}
												listMenu += '</ul>';

											} else {

												var child_open = "";
												var curr_url = window.location.pathname;
												var curr_menu = (site_url + '' + menus[i].link).replace(domain_url, '');
												if (curr_menu == curr_url) {
													child_open = "active";
													child_active = menus[i].id_menu;
												}

												if (menus[i].count_child > 0) {

													if (menus[i].parent_head_section == 1 || menus[i].parent == 0) {
														//listMenu += '<ul id="pc' + menus[i].id_menu + '" class="pcoded-item pcoded-left-item">';
													}
													
													listMenu +=
														'<li id="p' + menus[i].id_menu + '" class="pcoded-hasmenu" >\
														<a href="javascript:void(0)">\
															<span class="pcoded-micon"><i class="' +
																	menus[i].icon +
																	'"></i></span>\
															<span class="pcoded-mtext">' + menus[i].label +
																	'</span>\
														</a>\
														<ul class="pcoded-submenu">';
													renderMenu(menus, menus[i].id_menu);
													listMenu += '</ul></li>';

													if (menus[i].parent_head_section == 1 || menus[i].parent == 0) {
														//listMenu += '</ul>';
													}

												} else {
													if (menus[i].parent_head_section == 1 || menus[i].parent == 0) {
														//listMenu += '<ul class="pcoded-item pcoded-left-item">';
													}
													listMenu += '\
														<li id="' + menus[i].id_menu + '" class="' +
																	child_open + '">\
															<a href="' + (menus[i].link.toLowerCase().indexOf("http") >= 0?'':site_url) + '' + menus[i].link +
																	'">\
															<span class="pcoded-micon"><i class="' + menus[i].icon +
																	'"></i></span>\
															<span class="pcoded-mtext" >' + menus[i].label +
																	'</span>\
															</a>\
														</li>';
													if (menus[i].parent_head_section == 1 || menus[i].parent == 0) {
														//listMenu += '</ul>';
													}
												}
											}
										}
									}
									return listMenu;
								}
							</script>
					</nav>
				</div>


				<div class="pcoded-content">
					<div class="pcoded-inner-content">
						<!-- Main-body start -->
						<div class="main-body">
							<div class="page-wrapper">
								<!-- Page-header start -->
								<div class="card borderless-card">
									<div class="card-block info-breadcrumb">
										<div class="breadcrumb-header">
											<h5><?php echo isset($page_head_title)?$page_head_title:'';?></h5>
											<span><?php echo isset($page_head_desc)?$page_head_desc:'';?></span>
										</div>
										<div class="page-header-breadcrumb">
											<ul class="breadcrumb-title">

											<?php
												if(isset($breadcrumb_map))
												{
													foreach($breadcrumb_map as $map)
														{
															echo '<li class="breadcrumb-item">';
															if($map['link']!=null){
																echo '<a href="'.$map['link'].'" >';
															}else{
																echo '<a>';
															}
															echo $map['icon'].' '.$map['title'];
															echo '</a>
															</li>';
														}
												}
											?>
											</ul>
										</div>
									</div>
								</div>
								<!-- Page-header end -->
								<div class="page-body">
									<?php echo $_contents;?>
								</div>
							</div>
						</div>

						<!-- <div id="styleSelector">

						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>


	<!-- Warning Section Starts -->
	<!-- Older IE warning message -->
	<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="<?php echo base_url('assets/template/dashboard');?>/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="<?php echo base_url('assets/template/dashboard');?>/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="<?php echo base_url('assets/template/dashboard');?>/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="<?php echo base_url('assets/template/dashboard');?>/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="<?php echo base_url('assets/template/dashboard');?>/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
	<!-- Warning Section Ends -->


	<!-- Required Jquery -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/popper.js/js/popper.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery/js/jquery.blockUI.js"></script>

	<!-- jquery slimscroll js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

	<!-- modernizr js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/modernizr/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/modernizr/js/css-scrollbars.js"></script>


	<!-- sweet alert js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/sweetalert/js/sweetalert.min.js"></script>

	<!-- sweet alert modal.js intialize js -->
	<!-- modalEffects js nifty modal window effects -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/js/modalEffects.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/js/classie.js"></script>

	<!-- data-table js -->
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/data-table/js/jszip.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/data-table/js/pdfmake.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/data-table/js/vfs_fonts.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<!-- Validation js -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

	<!-- Currency js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/j-pro/js/jquery.ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/j-pro/js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/j-pro/js/jquery-cloneya.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/j-pro/js/autoNumeric.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/j-pro/js/jquery.stepper.min.js"></script>

	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery.cookie/js/jquery.cookie.js" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery.steps/js/jquery.steps.js" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/form-validation/validate.js"></script>

	<!-- Select 2 js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/select2/js/select2.full.min.js"></script>
	<!-- Multiselect js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>

	<!-- nestable js -->
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/nestable/jquery.nestable.js"></script>

	<!-- Switch component js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/switchery/js/switchery.min.js"></script>

	<!-- <script>
 	 var CKEDITOR_BASEPATH = '<?php echo base_url('assets/template/dashboard/assets/pages/ckeditor/');?>';
	</script> -->
	<script src="//cdn.ckeditor.com/4.4.0/standard/ckeditor.js"></script>
<!-- <script src="<?php echo base_url('assets/template/dashboard/assets/pages/ckeditor/ckeditor-custom.js');?>"></script> -->

	<!-- Morris component js -->
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/raphael/js/raphael.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/bower_components/morris.js/js/morris.js" ></script>


	<!-- i18next.min.js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/i18next/js/i18next.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/js/pcoded.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/js/vartical-layout.min.js"></script>
	<script src="<?php echo base_url('assets/template/dashboard');?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

	<!-- currency -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/j-pro/js/custom/currency-form.js"></script>

	<!-- Custom js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/js/script.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/pages/advance-elements/swithces.js"></script> -->

	<!-- Global site tag (gtag.js) - Google Analytics
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'UA-23581568-13');

	</script> -->

	<!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>

	<script>
		$('#dash_logout').click(function () {
			$.ajax({
				url: site_url + '/auth/logout',
				type: 'POST',
				dataType: 'json',
				data: {
					login_token: '<?php echo $this->session->userdata("login_token"); ?>'
				},
				success: function (data, text) {
					document.location.href = '<?php echo base_url();?>';
				},
				error: function (stat, res, err) {
					alert(err);
				}
			});
		});
	</script>

	
	<script>
	$('document').ready(function(){
		var theme='theme3';
		$('.navbar-logo').attr('logo-theme',theme);
		$('.header-navbar').attr('header-theme',theme);
		$('.pcoded-navbar').attr('navbar-theme','themelight1');
		$(".is_select2").select2(); 
		$(".is_select2_tags").select2({
           tags: true
        });
		$(".is_select2_modal").select2({
           dropdownParent: $(".modal_biaya")
        });
        $(".is_select2_modal_tags").select2({
           dropdownParent: $(".modal_biaya"),
           tags: true
        });
        $(".is_select2_modal_1").select2({
           dropdownParent: $(".modal_biaya_1")
        });
        $(".is_select2_modal_2").select2({
           dropdownParent: $(".modal_biaya_2")
        });
        $(".is_select2_modal_2_tags").select2({
           dropdownParent: $(".modal_biaya_2"),
           tags: true
        });
        $(".is_select2_modal_readonly").select2({
           dropdownParent: $(".modal_biaya"),
           disabled: true
        });
        $(".is_select2_modal1").select2({
           dropdownParent: $(".modal_subbiaya")
        });
        $(".is_select2_modal2").select2({
           dropdownParent: $(".modal_tagihan")
        });
        $(".is_select2_modal3").select2({
           dropdownParent: $(".modal_opsi_pajak")
        });
        $(".js-example-responsive").select2({
	        placeholder: "Bisa pilih lebih dari satu"
	    });

	    $(".is_select2_non_usaha").select2({
           dropdownParent: $(".modal_non_usaha")
        });

        $('.select2-iops').select2({
		    ajax: {
		        url: '<?php echo site_url('APISelect2/io_ps') ?>',
		        type: "POST",
		        dataType: 'JSON',
		        delay: 250,
		        data: function(params) {
		            return {
		                search: params.term, // search term
		            };
		        },
		        processResults: function(response) {
		            return {
		                results: response
		            };
		        },
		        cache: true
		    },
	  	});

	  	$('.select2-iops-real').select2({
		    ajax: {
		        url: '<?php echo site_url('APISelect2/io_ps_real') ?>',
		        type: "POST",
		        dataType: 'JSON',
		        delay: 250,
		        data: function(params) {
		            return {
		                search: params.term, // search term
		            };
		        },
		        processResults: function(response) {
		            return {
		                results: response
		            };
		        },
		        cache: true
		    },
			minimumInputLength: 1
	  	});

	  	$('.select2-customers').select2({
		    ajax: {
		        url: '<?php echo site_url('APISelect2/customers') ?>',
		        type: "POST",
		        dataType: 'JSON',
		        delay: 250,
		        data: function(params) {
		            return {
		                search: params.term, // search term
		            };
		        },
		        processResults: function(response) {
		            return {
		                results: response
		            };
		        },
		        cache: true
		    },
	  	});
	});
	</script>
</body>
</html>
