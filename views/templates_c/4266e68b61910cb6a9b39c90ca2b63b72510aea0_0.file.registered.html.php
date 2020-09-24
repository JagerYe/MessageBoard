<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-24 11:19:48
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/registered.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f6c64b4a05e44_71461067',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4266e68b61910cb6a9b39c90ca2b63b72510aea0' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/registered.html',
      1 => 1600938785,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6c64b4a05e44_71461067 (Smarty_Internal_Template $_smarty_tpl) {
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
	article {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		height: 50%;
	}

	body {
		padding: 0;
	}

	.borderBottomRed {
		border-bottom: 2px solid red;
	}

	.errMas {
		color: red;
	}
</style>
<?php echo '<script'; ?>
>
	//防止重新導入這，倒入這就直接回首頁
	$("body").css("display", "none");
	$.ajax({
		type: "GET",
		url: "/MessageBoard/member/getSessionUserName"
	}).then(function (e) {
		if (e !== '"false"') {
			$("body").css("display", "inline");
		} else {
			window.location.href = "/MessageBoard/index";
		}
	});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/MessageBoard/views/js/rule.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

	function getCheckNameMessage(value) {
		let checkMessage = $("#nameCheckMessage");
		let input = $("#userName");
		let returnStr = "請輸入姓名\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		if (value.trim().length <= 0) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckEmailMessage(value) {
		let checkMessage = $("#emailCheckMessage");
		let input = $("#userEmail");
		let returnStr = "信箱格式錯誤\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		if (!value.match(emailRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckPhoneMessage(value) {
		let checkMessage = $("#phoneCheckMessage");
		let input = $("#userPhone");
		let returnStr = "電話號碼格式錯誤\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		if (!value.match(phoneRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckAccountMessage(value) {
		let checkMessage = $("#accountCheckMessage");
		let input = $("#userAccount");
		let returnStr = "帳號格式錯誤\r\n";

		checkMessage.empty();
		input.removeClass('borderBottomRed');

		$.ajax({
			type: "GET",
			url: `/MessageBoard/member/checkMemberExist?id=${value}`
		}).then(function (e) {
			if (e === '1') {
				checkMessage.append("<br>此帳號有人使用<br>");
			}
		});

		if (!value.match(accountRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckPasswordMessage(again = false) {
		let checkMessage = $("#passwordCheckMessage");
		let input1 = $("#userPassword");
		let input2 = $("#passwordAgain");
		let returnStr = "";

		checkMessage.empty();
		input1.removeClass('borderBottomRed');
		input2.removeClass('borderBottomRed');

		if (!(input1.val()).match(passwordRule)) {
			input1.addClass('borderBottomRed');
			returnStr += '密碼格式錯誤！\r\n';
		}

		if (again && (input1.val() !== input2.val())) {
			input1.addClass('borderBottomRed');
			input2.addClass('borderBottomRed');
			returnStr += '兩次密碼不一致！\r\n';
		}
		checkMessage.text(returnStr);

		return returnStr;
	}

	$(window).ready(() => {

		//確認密碼是否一致
		$("#passwordAgain").change(function () {
			getCheckPasswordMessage(true);
		});

		//確認密碼格式
		$("#userPassword").change(function () {
			getCheckPasswordMessage();
		});

		//檢驗帳號
		$("#userAccount").change(function () {
			getCheckAccountMessage(this.value);
		});

		//檢測信箱
		$("#userEmail").change(function () {
			getCheckEmailMessage(this.value);
		});

		//檢查名字
		$("#userName").change(function () {
			getCheckNameMessage(this.value);
		});

		//檢查電話
		$("#userPhone").change(function () {
			getCheckPhoneMessage(this.value);
		});

		$("#btnSub").click(() => {

			let member = {
				"userAccount": $("#userAccount").val(),
				"userName": $("#userName").val(),
				"userEmail": $("#userEmail").val(),
				"userPhone": $("#userPhone").val(),
				"userPassword": $("#userPassword").val()
			};

			let errMessage = "";
			errMessage += getCheckNameMessage(member.userName);
			errMessage += getCheckEmailMessage(member.userEmail);
			errMessage += getCheckPhoneMessage(member.userPhone);
			errMessage += getCheckAccountMessage(member.userAccount);
			errMessage += getCheckPasswordMessage(true);
			if (errMessage.length > 0) {
				alert(errMessage);
				return;
			}

			let subData = {
				member: JSON.stringify(member)
			}
			$.ajax({
				type: "POST",
				url: "/MessageBoard/member/insertByObj",
				data: subData
			}).then(function (e) {
				if (e === '1') {
					alert("註冊成功，請登入");
					window.location.href = "/MessageBoard/member/getLoginView";
				} else {
					alert("註冊失敗");
				}
			});

		});
	});

<?php echo '</script'; ?>
>

<body>

	<main role="main" class="container">
		<div class="panel panel-default">
			<article class="panel-body mx-auto pagination-centered">

				<h4 class="panel-title mt-3 text-center">註冊</h4>

				<form>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-user"></i> </span>
						</div>
						<input id="userName" class="form-control" placeholder="請輸入姓名" type="text">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="nameCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
						</div>
						<input id="userEmail" class="form-control" placeholder="請輸入Email" type="email">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="emailCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
						</div>
						<input id="userPhone" class="form-control" placeholder="請輸入手機號碼" type="text">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="phoneCheckMessage"></p>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-user"></i> </span>
						</div>
						<input id="userAccount" class="form-control" placeholder="請輸入帳號" type="text">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="accountCheckMessage"></p>

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
						<input id="passwordAgain" class="form-control" placeholder="請在輸入一次密碼" type="password">
					</div> <!-- form-group// -->
					<p class="form-group errMas" id="passwordCheckMessage"></p>

					<div class="form-group">
						<button type="button" id="btnSub" class="btn btn-primary btn-block"> Create Account
						</button>
					</div> <!-- form-group// -->

					<p class="text-center">Have an account? <a href="/MessageBoard/member/getLoginView">Log
							In</a> </p>
				</form>

			</article>
		</div> <!-- panel.// -->

	</main><!-- /.container -->

</body>

</html><?php }
}
