//主留言
function getNewMainMessageView(userID, boardID, name, message, time, messageID = null, isMyself = false) {
    return `<div class="mainMessage" id="mainMessageShow${messageID}">
                ${getMainMessageView(userID, boardID, name, message, time, messageID, isMyself)}
            </div>`;
}

function getMainMessageView(userID, boardID, name, message, time, messageID = null, isMyself = false) {
    return `<div class="row">
                <img class="col-xs-2" src="/MessageBoard/member/getUserImg?id=${userID}" onerror="javascript:this.src='/MessageBoard/views/img/shadow.png'">
                <h4 class="col-xs-4"><a href="?userID=${userID}">${name}</a></h4>
                <div class="pull-right">
                    ${myMessageButton(isMyself, messageID)}
                </div>
            </div>

            <div class="row" id="text${messageID}">
                <div class="col-xs-1"></div>
                <div class="col-xs-11"><pre class="messageFontSize" id="messageText${messageID}"></pre></div>
            </div>
            <div class="time">${time}</div>
            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-10" id="boardMessage${boardID}"></div>
                <div class="col-xs-1"></div>
            </div>
            <dib class="row" id="messageInputGrid${boardID}"></div>`;
}

//主留言下的副留言
function getMessageView(userID, name, message, time, messageID = null, isMyself = false) {
    return `<div class="row oneMessage btn-default" id="message${messageID}">
                <img class="col-xs-2" src="/MessageBoard/member/getUserImg?id=${userID}" onerror="javascript:this.src='/MessageBoard/views/img/shadow.png'">
                <div class="col-xs-10 oneAttachedMessage">
                    <div class="row">
                        <a class="col-xs-" href="?userID=${userID}">${name}</a>
                        <div class="pull-right">
                            ${myMessageButton(isMyself, messageID)}
                        </div>
                    </div>
                    <div class="row" id="text${messageID}">
                        <div class="col-xs-1"></div>
                        <div class="col-xs-11"><pre class="messageFontSize" id="messageText${messageID}"></pre></div>
                    </div>
                    <div class="time">${time}</div>
                </div>
            </div>`;
}

function myMessageButton(isMyself, messageID) {
    return (isMyself) ?
        `<button class="btn btn-danger" id="deleteMessage${messageID}" type="button">刪除</button>
        <button class="btn btn-info" id="updateMessageBtn${messageID}" type="button" data-toggle="modal" data-target="#updateMessageModal">修改</button>`
        : "";
}

//新副留言輸入格
function getInputGridMessageView(id, message = "", isUpdate = false) {
    if (isUpdate) {
        return `<div class="row inputGridMessage" id="updateMessageGrid${id}">
                    <div class="col-xs-8"><textarea id="updateMessage${id}" cols="30" rows="1">${message}</textarea></div>
                    <div class="col-xs-2"><button class="btn btn-success" id="updateMessageSub${id}">送出</button></div>
                    <div class="col-xs-2"><button class="btn btn-danger" id="updateCancelBtn${id}">取消</button></div>
                </div>`;
    }
    return `<div class="row inputGridMessage"">
                <div class="col-xs-1"></div>
                <div class="col-xs-10 row">
                    <div class="col-xs-10"><textarea id="addMessage${id}" cols="30" rows="1"></textarea></div>
                    <div class="col-xs-2"><button class="btn btn-success" id="subMessage${id}">送出</button></div>
                </div>
                <div class="col-xs-1"></div>
            </div>`;
}

function getShowMoreMessageButton(id){
    return `<div class="row oneMessage btn-default" id="showMoreMessage${id}"><a>想看更多嗎？</a></div>`;
}