export class MemberViewModel {
    static getManagerView(id, phone, name, status) {
        return `<li class="row">
                    <div class="col-3">
                        <img src="/MessageBoard/views/img/gravatar.jpg"><br>
                    </div>
                    <div class="col-2">${id}</div>
                    <div class="col-2">${phone}</div>
                    <div class="col-2">${name}</div>
                    <div class="col-2">
                        <select id="select${id}" name="select${id}" class="custom-select">
                            <option value="1">啟用</option>
                            <option value="0">停用</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <button type="button" name="btnShowOrder${id}" id="btnShowOrder${id}">過往訂單</button>
                    </div>
                </li>
                <ul id="orders${id}">
                </ul><br>`
            ;
    }
    static getStatus(status) {
        if (status) {
            return `<option value="1" SELECTED>啟用</option>
                    <option value="0">停用</option>`;
        }
        return `<option value="1">啟用</option>
                <option value="0" SELECTED>停用</option>`;

    }
}
