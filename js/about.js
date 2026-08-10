
alert("Welcome to Student Hub Portal!");
console.log("About Page Loaded Successfully");

document.querySelector("h1").innerHTML = "Welcome to Student Hub Portal";

let features = document.querySelectorAll("ul li");
console.log("Total Features : " + features.length);

document.querySelector("h1").onclick = function () {
    this.style.color = "red";
};

document.querySelector("img").onmouseover = function () {
    this.style.border = "5px solid blue";
};

document.querySelector("img").onmouseout = function () {
    this.style.border = "2px solid black";
};