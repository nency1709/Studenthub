
const form = document.getElementById("registrationForm");
form.addEventListener("submit", function(event) {
    event.preventDefault();
    let name =
        document.getElementById("name").value.trim();

    let email =
        document.getElementById("email").value.trim();

    let phone =
        document.getElementById("phone").value.trim();

    let password =
        document.getElementById("password").value;

    let confirmPassword =
        document.getElementById("confirmPassword").value;

    let course =
        document.getElementById("course").value;

    let year =
        document.getElementById("year").value;

    let terms =
        document.getElementById("terms").checked;
    document.getElementById("nameError").innerHTML = "";
document.getElementById("emailError").innerHTML = "";
 document.getElementById("phoneError").innerHTML = "";
 document.getElementById("passwordError").innerHTML = "";
 document.getElementById("confirmPasswordError").innerHTML = "";
 document.getElementById("courseError").innerHTML = "";
 document.getElementById("yearError").innerHTML = "";
 document.getElementById("genderError").innerHTML = "";
 document.getElementById("termsError").innerHTML = "";
 document.getElementById("successMessage").innerHTML = "";
 let valid = true;
    let namePattern = /^[A-Za-z ]+$/;
 if (name === "") {
  document.getElementById("nameError").innerHTML =
"Please enter your name.";
   valid = false;
  }
  else if (!namePattern.test(name)) {
 document.getElementById("nameError").innerHTML =
     "Name should contain only letters.";
  valid = false;
    }
    let emailPattern =
   /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
 if (email === "") {
  document.getElementById("emailError").innerHTML =
   "Please enter your email.";
  valid = false;
  }
  else if (!emailPattern.test(email)) {
 document.getElementById("emailError").innerHTML =
  "Please enter a valid email.";
    valid = false;
    }
    let phonePattern = /^[0-9]{10}$/;
    if (phone === "") {
   document.getElementById("phoneError").innerHTML =
  "Please enter phone number.";
  valid = false;
  }
 else if (!phonePattern.test(phone)) {
  document.getElementById("phoneError").innerHTML =
   "Phone number must be 10 digits.";
  valid = false;
    }
  let passwordPattern =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    if (password === "") {
  document.getElementById("passwordError").innerHTML =
            "Please enter password.";
 valid = false;
 }
 else if (!passwordPattern.test(password)) {
   document.getElementById("passwordError").innerHTML =
 "Password must contain 8 characters, uppercase, lowercase and number.";
   valid = false;
    }

    if (confirmPassword === "") {
 document.getElementById("confirmPasswordError").innerHTML =
            "Please confirm password.";
 valid = false;

    }
 else if (password !== confirmPassword) {
 document.getElementById("confirmPasswordError").innerHTML =
            "Passwords do not match.";
  valid = false;
    }

    if (course === "") {

        document.getElementById("courseError").innerHTML =
            "Please select course.";
   valid = false;
    }
 if (year === "") {
 document.getElementById("yearError").innerHTML =
            "Please select year.";
  valid = false;
    }
    let gender =
 document.querySelector(
            'input[name="gender"]:checked'
        );
    if (!gender) {
 document.getElementById("genderError").innerHTML =
            "Please select gender.";
  valid = false;
    }
 if (!terms) {
 document.getElementById("termsError").innerHTML =
  "Please accept Terms and Conditions.";
   valid = false;
    }
    if (valid) {
 document.getElementById("successMessage").innerHTML =
            "Registration successful!";

        form.reset();
    }

});