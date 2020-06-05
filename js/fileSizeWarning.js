//check total file size and display error message if too big
var loadFile = function(event) {
    document.getElementById('sizeTooBig').hidden = true;
    var totSize = 0;
    for (var i = 0; i < event.target.files.length; i++) {
        totSize += event.target.files[i].size
    }
    if (totSize > 30000000) {
        document.getElementById('sizeTooBig').hidden = false;
    }
};