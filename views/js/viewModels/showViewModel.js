function getMemberUpdateDateView() {
    return `<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-user"></i> </span>
				</div>
				<input id="userName" class="form-control" placeholder="請輸入姓名" type="text">
			</div> <!-- form-group// -->

			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
				</div>
				<input id="userEmail" class="form-control" placeholder="請輸入Email" type="email">
			</div> <!-- form-group// -->

			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-phone"></i> </span>
				</div>
				<input id="userPhone" class="form-control" placeholder="請輸入手機號碼" type="text">
			</div> <!-- form-group// -->

			<div class="form-group input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
				</div>
				<input id="userPassword" class="form-control" placeholder="請輸入密碼" type="password">
			</div> <!-- form-group// -->
    `;
}

function getMemberUpdatePasswordView() {
    return `<div class="form-group input-group">
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
            <p class="form-group" id="passwordCheckMessage"></p>`;
}