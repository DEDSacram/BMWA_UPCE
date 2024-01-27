const showButton = document.getElementById("showSettingsDialog");
const loginDialog = document.getElementById("settingsDialog");
const loginConfirm = loginDialog.querySelector("#confirmBtn")
const loginCancel = loginDialog.querySelector("#loginCancel")
const modalblackout = document.getElementById("modal-blackout")

let modalarr = [{dialog:loginDialog}]

function modal(showbtn,dialog,confirmBtn,cancel,blackout, modalarray) {

    showbtn.addEventListener("click", () => {
      dialog.style.display = "block";
      blackout.classList.add("modal-container");
    
      modalarray.forEach(element => {
        if(element.dialog != dialog){
          console.log(element)
          element.dialog.style.display = "none"
        }
      });
    
    });
    
    
    confirmBtn.addEventListener("click", (event) => {
      event.preventDefault();
      dialog.style.display = "none";
      blackout.classList = [];
    
      // function to do
    });
    
    cancel.addEventListener("click", (event) => {
      event.preventDefault();
      dialog.style.display = "none";
      blackout.classList = [];
    
      // function to do
    });
    
    window.onclick = function(event) {
    
        // show button doesnt close modal
        if (event.target != dialog && !dialog.contains(event.target) && event.target != showbtn ) {
          blackout.classList = [];
          dialog.style.display = "none";
          modalarray.forEach(element => {
            if(element.dialog != dialog){
              element.dialog.style.display = "none"
            }
          });
        }
        
      }
    }

    modal(showButton,loginDialog,loginConfirm,loginCancel,modalblackout,modalarr)