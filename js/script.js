/**
 * Display remove confirmation or mail sending box acording to the given parm
 * @param {string} box 
 */
function confirm(box) {
    document.getElementById("confirmBoxMail").hidden = true;
    document.getElementById("confirmBoxRemove").hidden = true;
    document.getElementById("confirmBox" + box).hidden = false;
}

/**
 * Hide remove confirmation or mail sending box acording to the given parm
 * @param {string} box 
 */
function hide(box) {
    document.getElementById("confirmBox" + box).hidden = true;
}

/**
 * Validate send mail form if text has been writen
 */
function sendMail() {
    var text = document.getElementById("mailText").value;
    if (text.length > 0) {
        document.getElementById("submitButton").click();
    }
}

/**
 * enable or diable the submit  button for the mail box (if text is empty disable it) 
 */
function textChanged() {
    var text = document.getElementById("mailText").value;
    document.getElementById("validationButton").disabled = true;
    if (text.length > 0) {
        document.getElementById("validationButton").disabled = false;
    }
}