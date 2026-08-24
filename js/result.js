function checkResult() {
    let enrollment = document.getElementById("enrollment").value;

    if (enrollment == "") {
        alert("Please enter enrollment number");
    } 
    else {
        alert("Result found successfully!");
    }
}