//modal n1
const showButton = document.getElementById("showDialog");
const loginDialog = document.getElementById("loginDialog");
const loginConfirm = loginDialog.querySelector("#confirmBtn")
const loginCancel = loginDialog.querySelector("#loginCancel")

// makes a shadow behind the modal
const modalblackout = document.getElementById("modal-blackout")

// modal n2
const registerDialog = document.getElementById("registerDialog")
//open from modal n1
const registerShow = loginDialog.querySelector("#registerBtn")
const registerCancel = registerDialog.querySelector("#registerCancel")
const registerConfirm = registerDialog.querySelector("#confirmRegister")

let isOpen = false; // boolean variable to track if a modal is open

// Function to open the modal
function openModal(modal) {
  modal.style.display = "block";
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
registerConfirm.addEventListener("click", () => {
  closeModal(registerDialog);
});

modalblackout.addEventListener("click", () => {
    closeModal(loginDialog);
    closeModal(registerDialog);
});