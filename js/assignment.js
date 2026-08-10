
alert("Welcome to Assignment Page");
console.log("Assignment Page Loaded");
let submitBtn = document.querySelector('input[type="submit"]');
let resetBtn = document.querySelector('input[type="reset"]');
let fileInput = document.querySelector('input[type="file"]');


submitBtn.onclick = function () {

    if (fileInput.value == "") {
        alert("Please select an assignment file.");
    } else {
        alert("Assignment Submitted Successfully!");
    }

};
resetBtn.onclick = function () {
    alert("Form Reset Successfully!");
};

fileInput.onchange = function () {
    alert("File Selected Successfully!");
};
