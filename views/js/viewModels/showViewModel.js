function getShowIndex(name) {
    return `<h1>您好！ ${name}</h1>
            <p class="btn" id="showBalance">目前餘額：</p>
            <div id="featuresShow"></div>`;
}

function getShowMenu() {
    return `<ul class="navbar-nav mr-auto list">
                <li class="nav-item active">
                    <button type="button" class="btn btn-primary btn-lg btn-block deposit">存款</button>
                </li>
                <li class="nav-item active">
                    <button type="button" class="btn btn-primary btn-lg btn-block withdrawal">提款</button>
                </li>
                <li class="nav-item active">
                    <button type="button" class="btn btn-primary btn-lg btn-block showDetail">查詢明細</button>
                </li>
            </ul>`;
}

function getShowDepositAndWithdrawal(isOutput) {
    if (isOutput) {
        return `<h2>請輸入提出金額</h2>
                <div><input id="inputAmount" type="number" min="1" value="1"></div><br>
                <div><button id="btnSub" type="button" class="btn btn-primary btn-lg btn-block">提出</button></div>`;
    } else {
        return `<h2>請輸入存入金額</h2>
                <div><input id="inputAmount" type="number" min="1" value="1"></div><br>
                <div><button id="btnSub" type="button" class="btn btn-primary btn-lg btn-block">存入</button></div>`;

    }
}

function getShowUnlogin() {
    return `<h1>您好！</h1>
            <h3>請進行下列動作</h3>
            <div>
                <ul class="navbar-nav mr-auto list">
                    <li class="nav-item active">
                        <a href="login.html" class="btn btn-primary btn-lg btn-block">登入</a>
                    </li>
                    <li class="nav-item active">
                        <a href="registered.html" class="btn btn-primary btn-lg btn-block">註冊</a>
                    </li>
                </ul>
            </div>`;
}