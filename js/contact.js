function validateForm() {

    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let message = document.getElementById("message").value;

    if (name == "") {
        alert("Please enter your name");
        return false;
    }

    if (email == "") {
        alert("Please enter your email");
        return false;
    }

    if (phone == "") {
        alert("Please enter your phone number");
        return false;
    }

    if (message == "") {
        alert("Please enter your message");
        return false;
    }

    alert("Form submitted successfully!");

    return true;
}