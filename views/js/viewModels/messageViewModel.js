//主留言
function getMainMessageView(userID, boardID, name, message) {
    return `<div class="mainMessage">
                <h4 class="text-primary"><a href="?userID=${userID}">${name}</a></h4>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col">
                        <p>${message}</p>
                    </div>
                </div>
                <div id="message${boardID}"></div>
                <br>
            </div>`;
}

//主留言下的副留言
function getMessageView(userID, name, message) {
    return `<div>
                <div class="row oneMessage">
                    <div class="col-1">
                        <!-- <img src="" alt="" srcset=""> -->
                    </div>
                    <div class="col">
                        <div><a href="?userID=${userID}">${name}</a></div>
                        <div>${message}</div>
                    </div>
                </div>
            </div>`;
}

//新副留言輸入格
function getAddMessageView(id) {
    return `<div class="row addMessage">
                <div class="col"><textarea id="addMessage${id}" cols="30" rows="1"></textarea></div>
                <div class="col-2"><button class="btn btn-outline-success" id="subMessage${id}">送出</button></div>
            </div>`;
}