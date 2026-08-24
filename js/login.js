function login() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (email == "" || password == "") {
        alert("Please enter email and password");
    }
    else if (email == "student@gmail.com" && password == "12345") {
        alert("Login Successful");
        window.location.href = "home.html";
    }
    else {
        alert("Wrong email or password");
    }
}