<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-23 08:46:33
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberPassword.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f6aef498ad705_66895082',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '341d838f12dee635cd62fcb3eb43e2348e9f95fb' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberPassword.html',
      1 => 1600843580,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f6aef498ad705_66895082 (Smarty_Internal_Template $_smarty_tpl) {
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

	.borderBottomRed {
		border-bottom: 2px solid red;
	}

	.errMas {
		color: red;
	}
</style>

<?php echo '<script'; ?>
 src="/MessageBoard/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/MessageBoard/views/js/title.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	let userID = '<?php echo $_smarty_tpl->tpl_vars['isLogin']->value ? $_smarty_tpl->tpl_vars['userID']->value : -1;?>
';
	if(userID<0){
		window.location.href = "/MessageBoard/member/getLoginView";
	}

	function getCheckMessage(fun, value) {
		let checkMessage = $(`#${(fun === 'passwordAgain') ? 'password' : fun}CheckMessage`);
		let input = $(`#user${fun.substr(0, 1).toUpperCase() + fun.substr(1, fun.length - 1)}`);
		let returnStr = "";
		let again = false;
		let rule = passwordRule;
		checkMessage.empty();
		input.removeClass('borderBottomRed');
		switch (fun) {
			case 'oldPassword':
				returnStr = '舊密碼輸入錯誤\r\n';
				break;
			case 'password':
				returnStr = '密碼格式錯誤！\r\n';
				break;
			case 'passwordAgain':
				returnStr = '兩次密碼不一致！\r\n';
				again = ($("#userPassword").val() !== value);
				break;
		}

		if (!value.match(rule) || again) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}


	$(window).ready(() => {

		//檢查是否已登入，否者導入登入頁面
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

		$("#userOldPassword").change(function () {
			getCheckMessage('oldPassword', this.value);
		});

		//確認格式
		$("#userPassword").change(function () {
			getCheckMessage('password', this.value);
		});

		//確認一致
		$("#userPasswordAgain").change(function () {
			getCheckMessage('passwordAgain', this.value);
		});

		//送出事件
		$("#btnSub").click(() => {
			let data = {
				"userPassword": $("#userPassword").val(),
				"userPasswordAgain": $("#userPasswordAgain").val(),
				"userOldPassword": $("#userOldPassword").val()
			}

			let errMessage = "";
			errMessage += getCheckMessage('oldPassword', data.userOldPassword);
			errMessage += getCheckMessage('password', data.userPassword);
			errMessage += getCheckMessage('passwordAgain', data.userPasswordAgain);
			if (errMessage.length > 0) {
				alert(errMessage);
				return;
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

	});
<?php echo '</script'; ?>
>

<body>

	<?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<div class="blank"></div>
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
						<p class="form-group errMas" id="oldPasswordCheckMessage"></p>

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
						<p class="form-group errMas" id="passwordCheckMessage"></p>
					</div>

					<div class="form-group">
						<button type="button" id="btnSub" class="btn btn-primary btn-block">更新</button>
						<a href="/MessageBoard/member/getUpdateView" class="btn btn-primary btn-block">變更其他資料</a>
					</div> <!-- form-group// -->
				</form>
			</article>
		</div> <!-- card.// -->

	</main><!-- /.container -->

</body>

</html><?php }
}
