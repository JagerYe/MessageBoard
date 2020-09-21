<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-21 11:20:33
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f687061097fc5_90035056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46c39e5052d590cbcdf32a34e73545a98dde8eff' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/login.html',
      1 => 1600678496,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f687061097fc5_90035056 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Thoughts, reviews and ideas since 1999." />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="/MessageBoard/views/img/logo.png">

	<title>留言板</title>

	<link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/sign-in/">

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
		integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link href="/MessageBoard/views/css/signin.css" rel="stylesheet">
	<!-- Custom styles for this template -->

	<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
		integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
		crossorigin="anonymous"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
		integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
		crossorigin="anonymous"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
		integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
		crossorigin="anonymous"><?php echo '</script'; ?>
>

	<!-- ajax -->
	<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"><?php echo '</script'; ?>
>
</head>
<style>
	form {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		height: 50%;
	}
</style>
<?php echo '<script'; ?>
>
	//檢查是否要登出
	function checkIsLogOut() {
		$("body").css("display", "none");
		$.ajax({
			type: "GET",
			url: "/MessageBoard/member/getSessionUserName"
		}).then(function (e) {
			if (e === 'false') {
				$("body").css("display", "inline");
			} else {
				$.ajax({
					type: "GET",
					url: "/MessageBoard/member/logout"
				}).then(() => {
					window.location.href = "/MessageBoard/index";
				});
			}
		});
	}

	$(window).ready(() => {
		checkIsLogOut();
		//登入按鈕事件
		$("#login").click(() => {
			let data = {
				0: $("#userAccount").val(),
				1: $("#userPassword").val()
			};
			$.ajax({
				type: "POST",
				url: "/MessageBoard/member/login",
				data: data
			}).then(function (e) {
				if (e === '1') {
					window.location.href = "/MessageBoard/index";
					return;
				}
				alert("帳密錯誤");
			});
		});
	});
<?php echo '</script'; ?>
>

<body class="text-center">
	<form class="form-signin" method="post">
		<a href="/MessageBoard/index"><img class="mb-4" src="/MessageBoard/views/img/logo.png"
				alt="回首頁" style="background-color: black;"></a>
		<h1 class="h3 mb-3 font-weight-normal">會員登入</h1>
		<label for="userAccount" class="sr-only">帳號</label>
		<input type="text" id="userAccount" name="userAccount" class="form-control" placeholder="帳號" required autofocus>
		<label for="userPassword" class="sr-only">密碼</label>
		<input type="password" id="userPassword" name="userPassword" class="form-control" placeholder="密碼" required>

		<a href="/MessageBoard/member/getCreateView" class="btn btn-lg btn-primary btn-block">註冊</a>
		<button class="btn btn-lg btn-primary btn-block" id="login" type="button">登入</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
	</form>

</body>

</html><?php }
}
