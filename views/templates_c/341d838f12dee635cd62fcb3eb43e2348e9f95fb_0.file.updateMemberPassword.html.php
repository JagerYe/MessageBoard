<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-21 12:07:10
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberPassword.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f687b4e77ab55_20448016',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '341d838f12dee635cd62fcb3eb43e2348e9f95fb' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberPassword.html',
      1 => 1600682821,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f687b4e77ab55_20448016 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="/MessageBoard/views/img/logo.png">

	<title>留言板</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
		integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Custom styles for this template -->
	<link href="/MessageBoard/views/css/starter-template.css" rel="stylesheet">

	<!-- Bootstrap -->
	<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
		crossorigin="anonymous"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
		integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
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
	body {
		padding: 0;
	}

	article {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		height: 50%;
	}
</style>
<?php echo '<script'; ?>
 src="/MessageBoard/views/js/viewModels/memberViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/MessageBoard/views/js/viewModels/showViewModel.js"><?php echo '</script'; ?>
>
<!-- <?php echo '<script'; ?>
 src="/MessageBoard/views/js/title.js"><?php echo '</script'; ?>
> -->
<?php echo '<script'; ?>
 src="/MessageBoard/views/js/rule.js"><?php echo '</script'; ?>
>
<!-- <?php echo '<script'; ?>
>

	let functionType = false;

	//更新其他資料
	function showUpdateDate() {
		$("#mainShow").html(getMemberUpdateDateView());

		$.ajax({
			type: "POST",
			url: "/MessageBoard/member/getMemberSelfData"
		}).then(function (e) {
			let jsonObj;
			try {
				jsonObj = JSON.parse(e);
			} catch (err) {
				alert("資料取得錯誤");
			}

			$("#userName").val(jsonObj.userName);
			$("#userEmail").val(jsonObj.userEmail);
			$("#userPhone").val(jsonObj.userPhone);
		});

		$("#btnChangeTypr").text("變更密碼");

		$("#btnSub").click(() => {

			let member = {
				"userName": $("#userName").val(),
				"userEmail": $("#userEmail").val(),
				"userPhone": $("#userPhone").val(),
				"userPassword": $("#userPassword").val()
			};

			if (!member.userEmail.match(nameRule)) {
				alert("名字空白！");
				return;
			}
			if (!member.userEmail.match(emailRule)) {
				alert("Email格式錯誤");
				return;
			}
			if (!member.userPhone.match(phoneRule)) {
				alert("電話格式錯誤");
				return;
			}
			let subData = {
				member: JSON.stringify(member)
			}
			$.ajax({
				type: "PUT",
				url: "/MessageBoard/member/update",
				data: subData
			}).then(function (e) {
				if (e === "1") {
					alert("更新成功");
					history.go(0);
				} else {
					alert("更新失敗");
				}
			});

		});

	}

	//變更密碼
	function showUpdatePassword() {
		$("#mainShow").html(getMemberUpdatePasswordView());

		$("#userPassword").change(function () {
			$("#passwordCheckMessage").empty();
			if (!this.value.match(passwordRule)) {
				$("#passwordCheckMessage").text("密碼格式錯誤！");
			}
		});

		$("#userPasswordAgain").change(function () {
			$("#passwordCheckMessage").empty();
			if ($("#userPassword").val() != this.value) {
				$("#passwordCheckMessage").text("兩次密碼不一致！");
			}
		});

		$("#btnChangeTypr").text("變更其他資料");

		$("#btnSub").click(() => {
			if (!($("#userPassword").val()).match(passwordRule)) {
				alert("密碼格式錯誤！");
				return;
			}
			if ($("#userPassword").val() != $("#userPasswordAgain").val()) {
				alert("兩次密碼不一致！");
				return;
			}

			let data = {
				"userPassword": $("#userPassword").val(),
				"userPasswordAgain": $("#userPasswordAgain").val(),
				"userOldPassword": $("#userOldPassword").val()
			}
			$.ajax({
				type: "PUT",
				url: "/MessageBoard/member/updateSelfPassword",
				data: { 0: JSON.stringify(data) }
			}).then(function (e) {
				if (e == 1) {
					alert("更新成功，請再重新登入");
					window.location.href = "/MessageBoard/member/getLoginView";
				} else {
					alert("更新失敗");
				}
			});
		});
	}

	//切換功能
	function changeFuntion() {

		if (functionType) {
			showUpdatePassword();
		} else {
			showUpdateDate();
		}
	}

	$(window).ready(() => {
		$("body").css("display", "none");
		$.ajax({
			type: 'GET',
			url: '/MessageBoard/member/getSessionUserID'
		}).then(function (e) {
			if (e === 'false') {
				window.location.href = "/MessageBoard/member/getLoginView";
			}
			$("body").css("display", "inline");
		});

		changeFuntion();

		$("#btnChangeTypr").click(() => {
			$("#mainShow").empty();
			$("#btnSub").off('click');
			functionType = !functionType;
			changeFuntion();
		});
	});
<?php echo '</script'; ?>
> -->

<body>

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
					data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/MessageBoard/index">留言板</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li id="showUserName"></li>
					<li><a href="/MessageBoard/member/getLoginView" id="showLogin">登入</a></li>
					<li id="showRegistered"><a href="/MessageBoard/member/getCreateView">註冊</a></li>
				</ul>
			</div>
		</div>

	</nav>

	<main role="main" class="container">
		<div class="card bg-light">
			<article class="card-body mx-auto">
				<h4 class="card-title mt-3 text-center">更新會員資料</h4>

				<form>
					<div id="mainShow">
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input id="userOldPassword" class="form-control" placeholder="請輸入舊密碼" type="password">
						</div> <!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input id="userPassword" class="form-control" placeholder="請輸入密碼" type="password">
						</div> <!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input id="userPasswordAgain" class="form-control" placeholder="請輸入密碼" type="password">
						</div> <!-- form-group// -->
						<p class="form-group" id="passwordCheckMessage"></p>
					</div>

					<div class="form-group">
						<button type="button" id="btnSub" class="btn btn-primary btn-block"> 更新
						</button>
						<button type="button" id="btnChangeTypr" class="btn btn-primary btn-block"></button>
					</div> <!-- form-group// -->
				</form>
			</article>
		</div> <!-- card.// -->

	</main><!-- /.container -->

</body>

</html><?php }
}
