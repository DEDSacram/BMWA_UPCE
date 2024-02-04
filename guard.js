// if (!localStorage.getItem('hasCodeRunBefore')) {
//     let formData = new FormData();
// formData.append("action", "checkcookie");
// fetch("http://localhost/BMWA_UPCE/api/userlogin.php", {
//     method: "POST",
//     body: formData,
//     credentials: 'include' // Include cookies in the request
// })
//     .then(response => response.json()) // Parse response as JSON
//     .then(data => {
//         console.log(data.message);
//         if(data.status){
//                 // window.location.reload(); // Reload the current page
//         }
//     })
//     .catch(error => {
//         console.log("Error:", error);
//     })
  
//     localStorage.setItem('hasCodeRunBefore', 'true');
//   }
