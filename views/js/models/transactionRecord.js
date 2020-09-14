export class TransactionRecord {
    constructor(recordID, transactionAmount, userUTC, userID="", currentAmount = 0, transactionDate = "", transactionChangeDate = "", status = "success") {
        this._recordID = recordID;
        this._userID = userID;
        this._transactionAmount = transactionAmount;
        this._transactionDate = transactionDate;
        this._transactionChangeDate = transactionChangeDate;
        this._userUTC = userUTC;
        this._status = status;
        this._currentAmount = currentAmount;
    }

    get currentAmount() {
        return this._currentAmount;
    }
    set currentAmount(currentAmount) {
        this._currentAmount = currentAmount;
    }

    get status() {
        return this._status;
    }
    set status(status) {
        this._status = status;
    }

    get userUTC() {
        return this._userUTC;
    }
    set userUTC(userUTC) {
        this._userUTC = userUTC;
    }

    get transactionChangeDate() {
        return this._transactionChangeDate;
    }
    set transactionChangeDate(transactionChangeDate) {
        this._transactionChangeDate = transactionChangeDate;
    }

    get transactionDate() {
        return this._transactionDate;
    }
    set transactionDate(transactionDate) {
        this._transactionDate = transactionDate;
    }

    get transactionAmount() {
        return this._transactionAmount;
    }
    set transactionAmount(transactionAmount) {
        this._transactionAmount = transactionAmount;
    }

    get userID() {
        return this._userID;
    }
    set userID(userID) {
        this._userID = userID;
    }

    get recordID() {
        return this._recordID;
    }
    set recordID(recordID) {
        this._recordID = recordID;
    }
}