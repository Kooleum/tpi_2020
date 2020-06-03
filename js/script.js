//Show confirmation box
function confirm(box) {
    document.getElementById("confirmBoxMail").hidden = true;
    document.getElementById("confirmBoxRemove").hidden = true;
    document.getElementById("confirmBox" + box).hidden = false;
}

//hide confirmation box
function hide(box) {
    document.getElementById("confirmBox" + box).hidden = true;
}

function sendMail() {
    var text = document.getElementById("mailText").value;
    if (text.length > 0) {
        document.getElementById("submitButton").click();
    }
}

function textChanged() {
    var text = document.getElementById("mailText").value;
    document.getElementById("validationButton").disabled = true;
    if (text.length > 0) {
        document.getElementById("validationButton").disabled = false;
    }
}