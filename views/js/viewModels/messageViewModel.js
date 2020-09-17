//主留言
function getNewMainMessageView(userID, boardID, name, message, time, messageID = null, isMyself = false) {
    return `<div class="mainMessage" id="mainMessageShow${messageID}">
                <div class="row">
                    <!-- <img class="col-1" src="" alt="" srcset=""> -->
                    <h4 class="col text-primary"><a href="?userID=${userID}">${name}</a></h4>
                    ${myMessageButton(isMyself, messageID)}
                </div>
                
                <div class="row" id="text${messageID}">
                    <div class="col-1"></div>
                    <div class="col"><pre>${message}</pre></div>
                </div>
                <div class="time">${time}</div>
                <div id="boardMessage${boardID}"></div>
                <dib id="messageInputGrid${boardID}"></div>
            </div>`;
}

function getMainMessageView(userID, boardID, name, message, time, messageID = null, isMyself = false) {
    return `<div class="row">
                <!-- <img class="col-1" src="" alt="" srcset=""> -->
                <h4 class="col text-primary"><a href="?userID=${userID}">${name}</a></h4>
                ${myMessageButton(isMyself, messageID)}
            </div>

            <div class="row" id="text${messageID}">
                <div class="col-1"></div>
                <div class="col"><pre>${message}</pre></div>
            </div>
            <div class="time">${time}</div>
            <div id="boardMessage${boardID}"></div>
            <dib id="messageInputGrid${boardID}"></div>`;
}

//主留言下的副留言
function getMessageView(userID, name, message, time, messageID = null, isMyself = false) {
    return `<div class="row oneMessage" id="message${messageID}">
                <!-- <img class="col-1" src="" alt="" srcset=""> -->
                <div class="col">
                    <div class="row">
                        <a class="col" href="?userID=${userID}">${name}</a>
                        ${myMessageButton(isMyself, messageID)}
                    </div>
                    <div class="row" id="text${messageID}">
                        <div class="col-1"></div>
                        <div class="col"><pre>${message}</pre></div>
                    </div>
                    <div class="time">${time}</div>
                </div>
            </div>`;
}

function myMessageButton(isMyself, messageID) {
    return (isMyself) ?
        `<button class="col-1 btn btn-outline-danger float-right" id="deleteMessage${messageID}" type="button">刪除</button>
        <button class="col-1 btn btn-outline-info float-right" id="updateMessageBtn${messageID}" type="button">修改</button>`
        : "";
}

//新副留言輸入格
function getInputGridMessageView(id, message = "", isUpdate = false) {
    if (isUpdate) {
        return `<div class="row inputGridMessage" id="updateMessageGrid${id}">
                <div class="col"><textarea id="updateMessage${id}" cols="30" rows="1">${message}</textarea></div>
                <div class="col-2"><button class="btn btn-outline-success" id="updateMessageSub${id}">送出</button></div>
                <div class="col-2"><button class="btn btn-outline-danger" id="updateCancelBtn${id}">取消</button></div>
            </div>`;
    }
    return `<div class="row inputGridMessage"">
                <div class="col"><textarea id="addMessage${id}" cols="30" rows="1"></textarea></div>
                <div class="col-2"><button class="btn btn-outline-success" id="subMessage${id}">送出</button></div>
            </div>`;
}