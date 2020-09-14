
function getMonthShow(month) {
    return `<div class="month" id="month${month}">
                <div>${month}月</div>
                <div class="row day">
                    <div class="col-1"></div>
                    <div class="col">
                        <div class="row">
                            <div class="col">日期</div>
                            <div class="col">時間</div>
                            <div class="col">存入</div>
                            <div class="col">提出</div>
                            <div class="col">當時餘額</div>
                        </div>
                    </div>
                </div>
                <div class="row day">
                    <div class="col-1"></div>
                    <div class="col" id="day${month}"></div>
                </div>
                <div class="showMoreRecord" id="showMoreRecord${month}" style="display:none">
                    <button type="button" class="btn btn-primary btn-lg btn-block">我想看更多</button>
                </div>
            </div>`;
}

function getDayShow(day, time, deposit, withdrawal, currentAmount) {
    return `<div class="row">
                <div class="col">${day}</div>
                <div class="col">${time}</div>
                <div class="col">${deposit}</div>
                <div class="col">${withdrawal}</div>
                <div class="col">${currentAmount}</div>
            </div>`;
}


