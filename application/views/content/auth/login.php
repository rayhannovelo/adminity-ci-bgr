<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from colorlib.com//polygon/adminty/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Dec 2018 02:48:12 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
	<title>Carolina | PT. Bhanda Ghara Reksa (Persero)</title>
	<!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Carolina">
	<meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
	<meta name="author" content="#">
	<!-- Favicon icon -->
	<link rel="icon" href="<?php echo base_url('assets/img/favicon.png');?>" style="height:50px; width:auto;" type="image/x-icon">
	<!-- Google font-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
	<!-- Required Fremwork -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/bootstrap/css/bootstrap.min.css">
	<!-- themify-icons line icon -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/themify-icons/themify-icons.css">
	<!-- ico font -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/icofont/css/icofont.css">
	<!-- Style.css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/css/style.css">
	<!-- fontAwesome -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/assets/icon/font-awesome/css/font-awesome.min.css">


</head>

<body class="fix-menu">
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

	<section class="login-block" style="background:url(<?php echo base_url('assets/img/login_bg.jpg');?>) no-repeat;">
		<!-- Container-fluid starts -->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Authentication card start -->

					<form class="md-float-material form-material" method="post" id="login-form">

						<div class="auth-box card bg-c-lite-green update-card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<center>
											<img src="<?php echo base_url('assets/img/login_logo.png');?>" style="align:center; height:40px; margin-bottom:10px;"
											 alt="small-logo.png">
											 <h5>Carolina</h5>
										</center>
									</div>
								</div>
								<div class="form-group form-primary">
									<input type="text" name="nik" class="form-control" required="" placeholder="NIK / Username">
									<span class="form-bar"></span>
								</div>
								<div class="form-group form-primary">
									<div class="input-group">
										<input type="password" name="password" id="password" class="form-control" required="" placeholder="Password">
										<span class=" btn btn-inverse" onclick="ocPass('password',this);" id="basic-addon3"><i class="fa fa-eye"></i></span>
									</div>
									<span class="form-bar"></span>
								</div>

								<div class="m-t-25">
									<div class="row">
										<div class="col-md-6" style="margin:0px !important;">
											<input type="text" placeholder="Captcha Words" name="captcha_words" id="captcha_words" autofocus="" class="form-control" maxlength="100" required>
											<label for="" style="font-size:12px;">Masukan captcha</label>
										</div>
										<div class="col-md-6" style="margin:0px !important;">
											<span id="img_captcha"></span>
											<i title="Refresh Captcha" class="icofont icofont-refresh" style="cursor:pointer; font-size:24px;" id="captcha_refresh"></i>
										</div>
									</div>
									<center><label style="color:red;" id="captcha_warn">Captcha words not match, please try again!.</label></center>
								</div>

								<div class="row m-t-25 text-left">
									<div class="col-12">
										<div class="forgot-phone text-right f-right">
											<a target="_blank" href="<?php echo base_url('assets/file/helpdesk.jpeg');?>" class="text-right f-w-600"> Forgot Password?</a>
										</div>
									</div>
								</div>
								<div class="row m-t-30">
									<div class="col-md-12">
										<button type="submit" class="btn btn-grd-inverse btn-md btn-block text-center m-b-20 btn_save">Log in</button>
										<div id="login-msg">
											<?php if ($this->session->flashdata('login-failed')): ?>
											<div class="alert alert-danger icons-alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">                        
													<i class="icofont icofont-close-line-circled"></i>
												</button>
												<p><strong>Login Failed!</strong><code>NIK tidak terdaftar!</code></p>
											</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<hr />
								<div class="row">
									<!-- <div class="col-md-2">
										<img src="<?php echo base_url('assets/img/login_logo.png');?>" style="text-align:center; height:65px; width:auto;"
										 alt="small-logo.png">
									</div> -->
									<div class="col-md-12">
										<p style="margin-top:7px;" class="text-inverse text-center m-b-0">
											<?php echo Date('Y');?> © <strong>Powered By</strong> <a href="#">BGR Access</a>. All rights reserved.
										</p>
									</div>
								</div>
							</div>
						</div>
					</form>
					<!-- end of form -->
				</div>
				<!-- end of col-sm-12 -->
			</div>
			<!-- end of row -->
		</div>
		<!-- end of container-fluid -->
	</section>
	<!-- Warning Section Starts -->
	<!-- Older IE warning message -->
	<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
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
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/popper.js/js/popper.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/bootstrap/js/bootstrap.min.js"></script>
	<!-- jquery slimscroll js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
	<!-- modernizr js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/modernizr/js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/modernizr/js/css-scrollbars.js"></script>
	<!-- i18next.min.js -->
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/i18next/js/i18next.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/assets/js/common-pages.js"></script>

	<script>
		var captchaField = $('#img_captcha');
		var captchaWords = $('#captcha_words');
		var captchaWarn = $('#captcha_warn');
		var recaptcha = $('#captcha_refresh');
		var validate_url = '<?php echo site_url() . "auth/captcha_validate"; ?>';
		$(document).ready(() => {

			captchaWarn.hide();
			loadCaptcha();


			function loadCaptcha() {
				$.ajax({
					async: false,
					url: '<?php echo site_url() . "auth/generate_captcha"; ?>',
					type: 'GET',
					dataType: 'html',
					success: (res) => {
						console.log(res);
						captchaField.html(res);
					}
				});
			}

			recaptcha.click((e) => {
				e.preventDefault();
				loadCaptcha();
			});

			captchaWords.click(() => {
				captchaWarn.hide();
			});

		});
	</script>

	<script>
		var site_url = "<?php echo site_url();?>";
		$('#login-form').submit(function (e) {
			$('#login-msg').html('');
			$('.btn_save').html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading...');
			$('.btn_save').attr('disabled', 1);
			e.preventDefault();

			var login_msg = '';
			var login_alert = '';
			var login_alert_type = '';

			$.ajax({
				url: site_url + '/auth/login',
				type: 'POST',
				data: $('#login-form').serialize(),
				dataType: 'json',
				success: function (data, text) {
					if (data.captcha_wrong){
						$('.btn_save').html('Log in');
						$('.btn_save').removeAttr('disabled');
						captchaWarn.css('color', 'red');
						captchaWarn.html('Captcha tidak sesuai, coba lagi!');
						captchaWarn.show();
					}
					else if (data.login_state) {
						login_alert_type = 'alert-success';
						login_msg = data.login_msg;
						login_alert = '\
                <div class="alert ' + login_alert_type +
							' icons-alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <i class="icofont icofont-close-line-circled"></i>\
                    </button>\
                    <p><strong>Login Success! </strong><code>' +
							login_msg + '</code></p>\
                </div>';
						$('#login-msg').html(login_alert);

						setTimeout(function () {
							document.location.href = site_url + '/dashboard';
						}, 2000);
					} else {
						login_alert_type = 'alert-danger';
						login_msg = data.login_msg;
						login_alert = '\
                <div class="alert ' + login_alert_type +
							' icons-alert">\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                        <i class="icofont icofont-close-line-circled"></i>\
                    </button>\
                    <p><strong>Login Failed! </strong><code>' +
							login_msg + '</code></p>\
                </div>';
						$('#captcha_words').val('');
						$('#login-msg').html(login_alert);
						$('.btn_save').html('Log in');
						$('.btn_save').removeAttr('disabled');
						recaptcha.click();
						captchaWarn.html('');
						captchaWarn.hide();
					}
				},
				error: function (stat, res, err) {
					$('.btn_save').removeAttr('disabled');
					$('#login-msg').html(login_alert);
					recaptcha.click();
					captchaWarn.html('');
					captchaWarn.hide();
				}
			});
		});

function ocPass(id,el){
	if (el.innerHTML=='<i class="fa fa-eye"></i>'){
		$("#"+id).attr('type','text');
		el.innerHTML = '<i class="fa fa-eye-slash"></i>';
	}else{
		$("#"+id).attr('type','password');
		el.innerHTML = '<i class="fa fa-eye"></i>';
	}
}
	</script>
</body>


<!-- Mirrored from colorlib.com//polygon/adminty/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Dec 2018 02:48:12 GMT -->

</html>
