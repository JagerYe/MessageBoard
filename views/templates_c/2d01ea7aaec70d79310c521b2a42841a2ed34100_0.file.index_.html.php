<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-22 12:00:18
  from '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/index_.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f69cb32b1f437_53398714',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d01ea7aaec70d79310c521b2a42841a2ed34100' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/MessageBoard/views/pageFront/index_.html',
      1 => 1600768817,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./navigationBar.html' => 1,
  ),
),false)) {
function content_5f69cb32b1f437_53398714 (Smarty_Internal_Template $_smarty_tpl) {
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

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
		integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

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


	<!-- ajax -->
	<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"><?php echo '</script'; ?>
>

	<?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
		integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
		crossorigin="anonymous"><?php echo '</script'; ?>
>
</head>
<style>
	.oneMessage {
		margin: 5px;
	}

	.row {
		padding: 10px;
	}

	.newMessage {
		width: 100%;
	}

	.messageFontSize{
		/* font-size: 20px; */
		padding: 0;
		line-height: 25px;
	}

	textarea {
		resize: none;
		/* 鎖住使用者高度控制 */
		width: 100%;
		height: 100%;
	}

	.mainMessage {
		margin-bottom: 20px;
		padding: 10px;
		background-color: rgba(66, 124, 231, 0.1);
		width: 100%;
	}

	.mainMessage button {
		margin: 3px;
	}

	.time {
		font-size: 5px;
	}

	/*文字自動換行*/
	pre {
		overflow-x: auto;
		white-space: pre-wrap;
		word-wrap: break-word;

		/* 去除 bootstrap 3 預設樣式 */
		border: 0;
		background-color: transparent;
	}

	body {
		padding: 0;
	}

	button {
		padding: 0;
	}
</style>

<?php echo '<script'; ?>
 src="/MessageBoard/views/js/viewModels/messageViewModel.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

	let userID = "<?php echo $_smarty_tpl->tpl_vars['userID']->value;?>
";
	let userName = "<?php echo $_smarty_tpl->tpl_vars['userName']->value;?>
";
	let updateMessageID = 0;
	let updateBoardID = 0;
	let updateModalWidth = 0;

	//設定textarea模式
	function setTextareaMode() {
		$("textarea").on('input', function () {
			$(this).height("");
			$(this).height(this.scrollHeight);
		});
	}

	//設定與現在的時間差
	function getTiemDifference(date) {
		let time = (new Date(new Date() - new Date(date))).getTime();
		let count = 0;
		time /= 1000;//秒

		if (time < 1) {
			return "剛剛";
		}

		if (time < 60) {
			return Math.floor(time) + "秒前";
		}

		time /= 60;//分
		if (time < 60) {
			return Math.floor(time) + "分前";
		}

		time /= 60;//小時
		if (time < 24) {
			return Math.floor(time) + "小時前";
		}

		time /= 24;//天
		if (time < 7) {
			return Math.floor(time) + "天前";
		}

		time /= 7;//週
		if (time < 7) {
			return Math.floor(time) + "週前";
		}

		time /= 4;//月
		if (time < 4) {
			return Math.floor(time) + "月前";
		}

		time /= 12;//年
		return Math.floor(time) + "月前";
	}

	$(window).ready(() => {
		subMainListeners();
		updateMessageView();
		setUpdateModal();
	});

	//初始化監聽器
	function subMainListeners() {

		//新增主留言
		$("#subMain").click(() => {

			let board = { authority: 0 };
			let message = { message: $("#mainMessage").val() };
			let data = {
				'userID': userID,
				'board': board,
				'message': message
			};
			$.ajax({
				type: "POST",
				url: "/MessageBoard/message/addMainMessage",
				data: { 0: JSON.stringify(data) }
			}).then(function (e) {
				jsonArr = JSON.parse(e);
				let boardID = jsonArr.boardID;
				let messageID = jsonArr.messageID;

				if (boardID >= 1) {
					$("#massageShow").prepend(getNewMainMessageView(
						userID,
						boardID,
						userName,
						message.message,
						getTiemDifference(new Date()),
						messageID,
						true
					));
					$(`#messageText${messageID}`).text(message.message);
					addMessageInputGrid(boardID);
					addDeleteAndUpdateListener(messageID, boardID, true);
					$("#mainMessage").val("").trigger('input');

				}
			});
		});
	}

	//更新所有主留言板
	function updateMessageView() {
		$("#massageShow").empty();
		$.ajax({
			type: "GET",
			url: "/MessageBoard/message/getPublicBoard"
		}).then(function (e) {
			let jsonArr = JSON.parse(e);
			for (let jsonObj of jsonArr) {
				getBoardMessages(jsonObj._boardID);
			}
			// alert($('body').height());
			alert(clientHeight);
		});
	}

	//初始化Modal
	function setUpdateModal() {

		//修改送出
		$("#updateSubBtn").click(() => {

			let data = {
				"messageID": updateMessageID,
				"message": $("#updateMessageText").val()
			};

			$.ajax({
				type: "PUT",
				url: "/MessageBoard/message/updateMessage",
				data: { 0: JSON.stringify(data) }
			}).then(function (e) {
				try {
					let jsonObj = JSON.parse(e);
					getBoardMessages(updateBoardID, true);
					$("#updateCloseBtn").trigger("click");
				} catch (err) {
					alert("更新失敗");
				}
			});
		});

		//修改取消
		$("#updateMessageModal").on('hide.bs.modal', function () {
			let updateMessageText = $("#updateMessageText");
			updateMessageID = 0;
			updateBoardID = 0;
			updateModalWidth = updateMessageText.width();
			updateMessageText.val("");
		});

	}

	//更新單一留言板
	function getBoardMessages(boardID, isUpdate = false) {

		$.ajax({
			type: "GET",
			url: `/MessageBoard/message/getBoardMessages?id=${boardID}`
		}).then(function (e) {
			let jsonMessageArr = JSON.parse(e);
			for (let key in jsonMessageArr) {
				let isMyself = (jsonMessageArr[key]._userID == userID);
				let timeStr = getTiemDifference(jsonMessageArr[key]._changeDate);
				let isBoard = (key == 0);
				if (isBoard) {
					if (isUpdate) {
						$(`#mainMessageShow${jsonMessageArr[key]._messageID}`).empty().append(
							getMainMessageView(
								jsonMessageArr[key]._userID,
								boardID,
								jsonMessageArr[key]._userName,
								jsonMessageArr[key]._message,
								timeStr,
								jsonMessageArr[key]._messageID,
								isMyself)
						);
					} else {
						$("#massageShow").append(getNewMainMessageView(
							jsonMessageArr[key]._userID,
							boardID,
							jsonMessageArr[key]._userName,
							jsonMessageArr[key]._message,
							timeStr,
							jsonMessageArr[key]._messageID,
							isMyself));
					}


				} else {
					$(`#boardMessage${boardID}`).append(getMessageView(
						jsonMessageArr[key]._userID,
						jsonMessageArr[key]._userName,
						jsonMessageArr[key]._message,
						timeStr,
						jsonMessageArr[key]._messageID,
						isMyself));
				}

				$(`#messageText${jsonMessageArr[key]._messageID}`).text(jsonMessageArr[key]._message);

				//如果是自己的就可以修改及刪除
				if (isMyself) {
					addDeleteAndUpdateListener(jsonMessageArr[key]._messageID, boardID, isBoard);
				}

			}

			//新增輸入面板
			if ('<?php echo $_smarty_tpl->tpl_vars['isLogin']->value;?>
' === '1') {
				addMessageInputGrid(boardID);
			}
		});

	}

	function addMessageInputGrid(boardID) {
		$(`#messageInputGrid${boardID}`).append(getInputGridMessageView(boardID));
		$(`#subMessage${boardID}`).click(() => {
			let message = $(`#addMessage${boardID}`).val();
			let data = {
				'userID': userID,
				'boardID': boardID,
				'message': message
			};

			$.ajax({
				type: "POST",
				url: "/MessageBoard/message/addMessage",
				data: { 0: JSON.stringify(data) }
			}).then(function (messageID) {
				if (messageID >= 1) {
					$(`#boardMessage${boardID}`).append(getMessageView(
						userID,
						userName,
						message,
						getTiemDifference(new Date()),
						messageID,
						true));
					addDeleteAndUpdateListener(messageID, boardID);
					$(`#messageText${messageID}`).text(message);
					$(`#addMessage${boardID}`).val("").trigger('input');
				}
			});
		});
		setTextareaMode();
	}

	//設定刪除及修改監聽器
	function addDeleteAndUpdateListener(messageID, boardID, isBoard = false) {

		//刪除按鈕
		$(`#deleteMessage${messageID}`).click(() => {
			if (!confirm('刪除並不能解決問題，但能解決這則留言，確定要刪除？')) {
				return;
			}
			$.ajax({
				type: "DELETE",
				url: "/MessageBoard/message/deleteMessage",
				data: { 0: messageID }
			}).then(function (e) {
				let jsonArr = JSON.parse(e);
				switch (key = Object.keys(jsonArr)[0]) {
					case "message":
						$(`#message${jsonArr[key]}`).remove();
						break;
					case "board":
						$(`#mainMessageShow${jsonArr[key]}`).remove();
						break;
				}
			});
		});

		//修改按鈕
		$(`#updateMessageBtn${messageID}`).click(function () {

			let updateMessageText = $("#updateMessageText");
			updateMessageText.val($(`#text${messageID}`).children().last().text());

			//因產生modal期間textarea的scrollHeight為0，故需找其他參照點來做
			let a = $(`#messageText${messageID}`).css('height');
			updateMessageText.css('height', $(`#messageText${messageID}`).css('height'));

			updateMessageID = messageID;
			updateBoardID = boardID;
		});

	}

<?php echo '</script'; ?>
>

<body>

	<?php $_smarty_tpl->_subTemplateRender('file:./navigationBar.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<main class="container">

		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-8">
				<?php if ($_smarty_tpl->tpl_vars['isLogin']->value === true) {?>
				<div class="addMainMassage">
					<h2>來說點什麼吧</h2>
					<textarea id="mainMessage"></textarea>
					<div class="row">
						<button class="pull-right btn btn-success" type="button" id="subMain">送出</button>
					</div>
					<br>
				</div>
				<?php }?>

				<div id="massageShow"></div>
			</div>
			<div class="col-xs-2"></div>
		</div>

		<!-- Modal，用於修改訊息用-->
		<div class="modal fade" id="updateMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<!--背景-->
			<div class="modal-dialog" role="document">
				<!--內距-->
				<div class="modal-content">
					<!--主體-->
					<div class="modal-header">
						<!--頭-->
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						<!--按鈕要先，才能保持在上方-->
						<h4 class="modal-title">修改留言</h4>
						<!--開頭-->
					</div>
					<div class="modal-body">
						<!--身-->
						<textarea id="updateMessageText" cols="30" rows="1"></textarea>
					</div>
					<div class="modal-footer">
						<!--底-->
						<button type="button" class="btn btn-default" data-dismiss="modal"
							id="updateCloseBtn">取消</button>
						<!--取消按鈕-->
						<button type="button" class="btn btn-primary" id="updateSubBtn">更新</button>
						<!--送出-->
					</div>
				</div>
			</div>
		</div>

	</main><!-- /.container -->

</body>

</html><?php }
}
