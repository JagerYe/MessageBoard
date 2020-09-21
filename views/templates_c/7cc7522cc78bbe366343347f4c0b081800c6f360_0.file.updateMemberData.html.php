<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-21 12:06:36
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberData.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f687b2c853486_13596632',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7cc7522cc78bbe366343347f4c0b081800c6f360' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberData.html',
      1 => 1600682792,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f687b2c853486_13596632 (Smarty_Internal_Template $_smarty_tpl) {
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
 src="/MessageBoard/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

	//更新其他資料
	function showUpdateDate() {


	}

	$(window).ready(() => {
		$("body").css("display", "none");

		//確認是否登入
		$.ajax({
			type: 'GET',
			url: '/MessageBoard/member/getSessionUserID'
		}).then(function (e) {
			if (e === 'false') {
				window.location.href = "/MessageBoard/member/getLoginView";
			}
			$("body").css("display", "inline");
		});

		//格式檢查
		$("#userName").change(function () {
			let namaCheckMessage = $('#namaCheckMessage');
			namaCheckMessage.empty();
			if (!this.value.match(nameRule)) {
				namaCheckMessage.text('名字請勿留白');
			}
		});

		$("#userEmail").change(function () {
			let namaCheckMessage = $('#emailCheckMessage');
			namaCheckMessage.empty();
			if (!this.value.match(nameRule)) {
				namaCheckMessage.text('信箱格式錯誤');
			}
		});

		$("#userPhone").change(function () {
			let namaCheckMessage = $('#phoneCheckMessage');
			namaCheckMessage.empty();
			if (!this.value.match(nameRule)) {
				namaCheckMessage.text('電話號碼格式錯誤');
			}
		});

		//送出按鈕事件
		$("#btnSub").click(() => {

			//包裝
			let member = {
				"userName": $("#userName").val(),
				"userEmail": $("#userEmail").val(),
				"userPhone": $("#userPhone").val(),
				"userPassword": $("#userPassword").val()
			};

			//檢查
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

			//送出
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

	});
<?php echo '</script'; ?>
>

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
					<li id="showUserName"><a href="#"><?php echo $_smarty_tpl->tpl_vars['member']->value['userName'];?>
</a></li>
					<li><a href="/MessageBoard/member/getLoginView" id="showLogin">登出</a></li>
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
								<span class="input-group-text"> <i class="fa fa-user"></i> </span>
							</div>
							<input id="userName" class="form-control" placeholder="請輸入姓名" type="text"
								value="<?php echo $_smarty_tpl->tpl_vars['member']->value['userName'];?>
">
						</div>
						<p class="form-group" id="namaCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							</div>
							<input id="userEmail" class="form-control" placeholder="請輸入Email" type="email"
								value="<?php echo $_smarty_tpl->tpl_vars['member']->value['userEmail'];?>
">
						</div>
						<p class="form-group" id="emailCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
							</div>
							<input id="userPhone" class="form-control" placeholder="請輸入手機號碼" type="text"
								value="<?php echo $_smarty_tpl->tpl_vars['member']->value['userPhone'];?>
">
						</div>
						<p class="form-group" id="phoneCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input id="userPassword" class="form-control" placeholder="請輸入密碼" type="password">
						</div>
						<p class="form-group" id="idCheckMessage"></p>
						<!-- form-group// -->

					</div>

					<div class="form-group">
						<button type="button" id="btnSub" class="btn btn-primary btn-block">更新</button>
						<a class="btn btn-primary btn-block" href="/MessageBoard/member/getUpdatePasswordView">變更密碼</a>
					</div> <!-- form-group// -->
				</form>
			</article>
		</div> <!-- card.// -->

	</main><!-- /.container -->

</body>

</html><?php }
}
