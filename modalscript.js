//modal n1
const showButton = document.getElementById("showDialog");
const loginDialog = document.getElementById("loginDialog");
//form
const loginForm = loginDialog.querySelector("form")
const loginConfirm = loginDialog.querySelector("#confirmBtn")
const loginCancel = loginDialog.querySelector("#loginCancel")

// makes a shadow behind the modal
const modalblackout = document.getElementById("modal-blackout")

// modal n2
const registerDialog = document.getElementById("registerDialog")
// form
const registerForm = registerDialog.querySelector("form")
//open from modal n1
const registerShow = loginDialog.querySelector("#registerBtn")
const registerCancel = registerDialog.querySelector("#registerCancel")

//warnings
let emailError = document.getElementById('emailError');
let passwordError = document.getElementById('passwordError');
let confirmPasswordError = document.getElementById('confirmPasswordError');

let isOpen = false; // boolean variable to track if a modal is open

// Function to open the modal
function openModal(modal) {
  modal.style.display = "flex";
  modalblackout.classList = ["modal-container"];
  }

// Function to close the modal
function closeModal(modal) {
  modal.style.display = "none";
  modalblackout.classList = [];
}

// Event listener for the showButton to open the loginDialog
showButton.addEventListener("click", () => {
  openModal(loginDialog);
});

// Event listener for the loginConfirm button to close the loginDialog and open the registerDialog
registerShow.addEventListener("click", () => {
  closeModal(loginDialog);
  openModal(registerDialog);
});

// Event listener for the loginCancel button to close the loginDialog
loginCancel.addEventListener("click", () => {
  closeModal(loginDialog);
});

// Event listener for the registerCancel button to close the registerDialog
registerCancel.addEventListener("click", () => {
  closeModal(registerDialog);
});

// Event listener for the registerConfirm button to close the registerDialog

// Assuming `loginForm` is the form that should not be submitted

loginForm.addEventListener('submit', function(event) {
  event.preventDefault();
  // Your code here...
});

registerForm.addEventListener('submit', function(event) {
  event.preventDefault();

  let formElements = event.target.elements;
  console.log(formElements);
  // Access form fields by their names
  let email = formElements["email"].value;
  let password = formElements["password"].value;
  let confirmPassword = formElements["confirmPassword"].value;

  // Regular expression patterns for email and password validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;


  let post = true //isready to post ?
  // Check if email is valid
  if (!emailPattern.test(email)) {
    console.log("Invalid email");
    // Add warning above the email input
    emailError.textContent = "Please enter a valid email.";
    post = false
  } else {
    // Remove any existing warning above the email input
    emailError.textContent = "";
  }

  // Check if password is valid
  if (!passwordPattern.test(password)) {
    console.log("Invalid password. Password must contain at least 8 characters, including at least one letter and one number.");
    // Add warning above the password input
    passwordError.textContent = "Invalid password. Password must contain at least 8 characters, including at least one letter and one number.";
    post = false
  } else {
    // Remove any existing warning above the password input
    passwordError.textContent = "";
  }

  // Check if passwords match
  if (password !== confirmPassword) {
    console.log("Passwords do not match");
    // Add warning above the confirmPassword input
    confirmPasswordError.textContent = "Passwords do not match";
    post = false
  } else {
    // Remove any existing warning above the confirmPassword input
    confirmPasswordError.textContent = "";
  }

  if(!post){
    return;
  }
  // If all validations pass, proceed with further logic
  console.log("Email and passwords are valid");

  // Your code here...
});



modalblackout.addEventListener("click", () => {
    closeModal(loginDialog);
    closeModal(registerDialog);
});