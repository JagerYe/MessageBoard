<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-24 11:19:17
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberData.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f6c64957b8466_44002321',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7cc7522cc78bbe366343347f4c0b081800c6f360' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/updateMemberData.html',
      1 => 1600939155,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f6c64957b8466_44002321 (Smarty_Internal_Template $_smarty_tpl) {
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

	img {
		width: 100%;
		height: 100%;
		max-width: 150px;
		max-height: 150px;
		;
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
	if (userID < 0) {
		window.location.href = "/MessageBoard/member/getLoginView";
	}

	let updateData = false;
	let updateImg = false;
	let updateErr = false;

	function getCheckNameMessage(value) {
		let checkMessage = $('#nameCheckMessage');
		let input = $('#userName');
		let returnStr = '請輸入姓名\r\n';

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
		let checkMessage = $('#emailCheckMessage');
		let input = $('#userEmail');
		let returnStr = '信箱格式錯誤\r\n';

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
		let checkMessage = $('#phoneCheckMessage');
		let input = $('#userPhone');
		let returnStr = '電話號碼格式錯誤\r\n';

		checkMessage.empty();
		input.removeClass('borderBottomRed');
		if (!value.match(phoneRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckPasswordMessage(value) {
		let checkMessage = $('#passwordCheckMessage');
		let input = $('#userPassword');
		let returnStr = '請輸入密碼\r\n';

		checkMessage.empty();
		input.removeClass('borderBottomRed');
		if (!value.match(passwordRule)) {
			checkMessage.text(returnStr);
			input.addClass('borderBottomRed');
			return returnStr;
		}
		return "";
	}

	function getCheckImage(value) {
		return value && value.type.match(imageTypeRule);
	}

	function checkUpdateOk() {
		if (updateErr) {
			history.go(0);
		}
		if (updateData && updateImg) {
			alert("更新成功");
		} else {
			setTimeout(checkUpdateOk, 10);
		}
		history.go(0);
	}

	$(window).ready(() => {
		$('body').css('display', '<?php echo $_smarty_tpl->tpl_vars['isLogin']->value ? 'inline' : 'none';?>
')

		//格式檢查
		$("#userName").change(function () {
			getCheckNameMessage(this.value);
		});

		$("#userEmail").change(function () {
			getCheckEmailMessage(this.value);
		});

		$("#userPhone").change(function () {
			getCheckPhoneMessage(this.value);
		});

		$("#userPassword").change(function () {
			getCheckPasswordMessage(this.value);
		});

		$("#clearImage").click(() => {
			$("#inputImage").val("");
			$("#userImage").attr('src', `/MessageBoard/member/getUserImg?id=${userID}`);
		});

		$("#inputImage").change(function () {
			if (this.files && getCheckImage(this.files[0])) {
				let reader = new FileReader();
				reader.onload = function (e) {
					$("#userImage").attr('src', e.target.result);
				}
				// reader.readAsDataURL(this);
				reader.readAsDataURL(this.files[0]);
			} else {
				alert("請選擇正確的檔案格式");
				$("#userImage").attr('src', `/MessageBoard/member/getUserImg?id=${userID}`);
			}
		});

		//送出按鈕事件
		$("#btnSub").click(() => {

			//包裝
			let member = {
				"userID": userID,
				"userName": $("#userName").val(),
				"userEmail": $("#userEmail").val(),
				"userPhone": $("#userPhone").val(),
				"userPassword": $("#userPassword").val()
			};


			let errMessage = "";
			errMessage += getCheckNameMessage(member.userName);
			errMessage += getCheckEmailMessage(member.userEmail);;
			errMessage += getCheckPhoneMessage(member.userPhone);;
			errMessage += getCheckPasswordMessage(member.userPassword);;
			if (errMessage.length > 0) {
				alert(errMessage);
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
					updateData = true;
				} else {
					updateErr = true;
					alert("更新失敗，將重新整理頁面");
				}
			});

			if ((img = $("#inputImage").get(0).files[0]) && getCheckImage(img)) {
				let putData = new FormData();
				putData.append("userID", userID);
				putData.append("password", $("#userPassword").val());
				putData.append("img", img);
				$.ajax({
					type: "POST",
					url: "/MessageBoard/member/updateSelfImage",
					data: putData,
					cache: false,
					contentType: false,
					processData: false
				}).then(function (e) {
					if (e === '1') {
						updateImg = true;
					} else {
						updateErr = true;
						alert('圖片上傳失敗');
					}
				});
			} else {
				updateImg = true;
			}

			setTimeout(checkUpdateOk, 10);
		});

	});
<?php echo '</script'; ?>
>

<body>
	<?php if ($_smarty_tpl->tpl_vars['isLogin']->value) {?>
	<?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<div class="blank"></div>
	<main role="main" class="container">
		<div class="card bg-light">
			<article class="card-body mx-auto">
				<h4 class="card-title mt-3 text-center">更新會員資料</h4>

				<form>
					<div id="mainShow">
						<div>
							<img src="/MessageBoard/member/getUserImg?id=<?php echo $_smarty_tpl->tpl_vars['isLogin']->value ? $_smarty_tpl->tpl_vars['userID']->value : -1;?>
" id="userImage"
								onerror="javascript:this.src='/MessageBoard/views/img/gravatar.jpg'">
							<p>更換頭像：</p>
							<input id="inputImage" type="file" accept="image/*">
							<button id="clearImage" type="button">清除圖片</button>
							<br>
						</div>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-user"></i> </span>
							</div>
							<input id="userName" class="form-control" placeholder="請輸入姓名" type="text"
								value="<?php echo $_smarty_tpl->tpl_vars['member']->value['userName'];?>
">
						</div>
						<p class="form-group errMas" id="nameCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							</div>
							<input id="userEmail" class="form-control" placeholder="請輸入Email" type="email"
								value="<?php echo $_smarty_tpl->tpl_vars['member']->value['userEmail'];?>
">
						</div>
						<p class="form-group errMas" id="emailCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
							</div>
							<input id="userPhone" class="form-control" placeholder="請輸入手機號碼" type="text"
								value="<?php echo $_smarty_tpl->tpl_vars['member']->value['userPhone'];?>
">
						</div>
						<p class="form-group errMas" id="phoneCheckMessage"></p>
						<!-- form-group// -->

						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
							<input id="userPassword" class="form-control" placeholder="請輸入密碼" type="password">
						</div>
						<p class="form-group errMas" id="passwordCheckMessage"></p>
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
	<?php }?>
</body>

</html><?php }
}
