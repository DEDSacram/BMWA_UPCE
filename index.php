<?php
ob_start(); // Start output buffering
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start(); // Start the session

// Redirect only when guard is set, which is always and if it isn't move to the javascript and set it there, if a cookie is valid, otherwise restart site and redirect
if (isset($_SESSION['guard']) && $_SESSION['guard'] == false) {
  header('Location: main.php'); // Redirect to the login page
  exit;
}

ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
  <script>
    if (sessionStorage.getItem('hasCodeRunBefore') != 'true') {
      let formData = new FormData();
      formData.append("action", "checkcookie");
      fetch("http://localhost/BMWA_UPCE/api/userlogin.php", {
          method: "POST",
          body: formData,
          credentials: 'include' // Include cookies in the request
      })
      .then(response => response.json()) // Parse response as JSON
      .then(data => {
        if (data.status) {
          sessionStorage.setItem('hasCodeRunBefore', 'true');
          window.location.reload();
        } else {
          sessionStorage.setItem('hasCodeRunBefore', 'false');
          window.location.reload();
        }
      })
      .catch(error => {
          console.log("Error:", error);
      });
    }
  </script>
  <link rel="stylesheet" href="./styles/scheduler.css">
  <link rel="stylesheet" href="./styles/scheduler-settings.css">
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <button onclick="toggleSidebar()">Back</button>
    <div id="manage-tasks" class="hidden">
      <button onclick="backToTodoLists()">Backto</button>
      <button onclick="addnew()" id="addtask">+</button>
      <button onclick="createDrag()" id="addtaskdd">+</button>
    </div>
    <div id="manage_todo_lists">
      <button onclick="addnewtodolist()">+</button>
      <div id="todo-lists"></div>
    </div>
  </div>
  <div id="settings">
    <svg id="showSettingsDialog" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
      <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
    </svg>
  </div>
  <div id="edit">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
      <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
    </svg>
  </div>
  <div id="Hamburgur" onclick="toggleSidebar()">
    <svg height="32px" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" width="32px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2 s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2 S29.104,22,28,22z"/>
    </svg>
  </div>
  <div id="modal-blackout"></div>
  <div id="settingsDialog">
    <div id="colorpicker">
      <div id="colorpickerside">
        <canvas id='canvas'></canvas>
        <div id="sidepicker"></div>
      </div>
      <div id='colorpreview'>here</div>
    </div>
    <form>
      <div>
        <button id="loginCancel">Cancel</button>
        <button id="confirmBtn" value="default">Confirm</button>
        <button id="registerBtn">Register</button>
      </div>
    </form>
  </div>
  <!-- Main Container -->
  <div id="main-container"></div>
  <script src="scheduler.js"></script>
  <script src="modal-settings.js"></script>
  <script src="colorwheel.js"></script>
  <script>
    function generateTodoLists() {
      // Dynamically generate content
      let formData = new FormData();
      formData.append("action", "gettodolists");
      fetch("http://localhost/BMWA_UPCE/api/app.php", {
        method: "POST",
        body: formData,
        credentials: 'include' // Include cookies in the request
      })
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById("todo-lists");
        container.innerHTML = "";
        data.forEach(todoItem => {
          const button = document.createElement("button"); // Create a button element
          button.setAttribute("data-id", todoItem.ListID);
          button.textContent = todoItem.ListName;
          button.classList.add("todo-list"); // Add the class "todo-list"
          button.onclick = handleClick; // Set the onclick event to the named function handleClick
          container.insertBefore(button, container.firstChild);
        });
      })
      .catch(error => {
        console.log("Error:", error);
      });
    }

    function handleClick() {
      // should hide only if call is successful we assume it is, because 
      const manageTodoLists = document.getElementById("manage_todo_lists");
      manage_todo_lists.classList.add("hidden");

      const managetasks = document.getElementById("manage-tasks");
      managetasks.classList.remove("hidden");

      let listId = this.getAttribute("data-id");

      // save new created to-do lists
      // call to dom
      if (sessionStorage.getItem('savenewTodoLists') != 'true') {
        // get list of tasks
        let formData = new FormData();
        formData.append("action", "getitemsintodolist");
        formData.append("ListID", listId);
        fetch("http://localhost/BMWA_UPCE/api/app.php", {
          method: "POST",
          body: formData,
          credentials: 'include' // Include cookies in the request
        })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          // const container = document.getElementById("sidebar-todos");
          // container.innerHTML = "";
          // data.forEach(todoItem => {
          //   const button = document.createElement("button"); // Create a button element
          //   button.setAttribute("data-id", todoItem.TaskID);
          //   button.textContent = todoItem.TaskName;
          //   button.classList.add("todo-list"); // Add the class "todo-list"
          //   button.onclick = handleClick; // Set the onclick event to the named function handleClick
          //   container.insertBefore(button, container.firstChild);
          // });
        });
        return;
      }

      const listId_temporary = this.getAttribute("data-id-new");

      // create an array for form data
      const todoListsContainer = document.getElementById("todo-lists");
      let array = [];

      for (let i = 0; i < todoListsContainer.children.length; i++) {
        const child = todoListsContainer.children[i];
        // check if you should break by getting into ones that are already in the db
        const listId = child.getAttribute("data-id");
        if (listId !== null) {
          break;
        }
        array.push(child.textContent); // here we get the same order as we will get last inserted ids from the db
      }

      // save all these
      let data = {
        action: "addtodolist",
        UserID: "6", // replace with the actual user ID
        ListNameArray: array
      };

      fetch("http://localhost/BMWA_UPCE/api/app.php", {
        method: "POST",
        body: JSON.stringify(data),
        credentials: 'include', // Include cookies in the request
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
      })
      .catch(error => {
        console.log("Error:", error);
      });
    }

    function backToTodoLists() {
      const manageTodoLists = document.getElementById("manage_todo_lists");
      manage_todo_lists.classList.remove("hidden");

      const managetasks = document.getElementById("manage-tasks");
      managetasks.classList.add("hidden");
    }

    function addnewtodolist() {
      let ListName = prompt('Type list name');
      if (ListName == null || ListName == "") {
        return;
      }
      sessionStorage.setItem('savenewTodoLists', 'true');

      const TodoLists = document.getElementById("todo-lists");
      const button = document.createElement("button");
      button.textContent = ListName;
      button.classList.add("todo-list");
      button.onclick = handleClick;

      // Get the value of data-id-new attribute
      let dataIdNew = TodoLists.firstChild.getAttribute("data-id-new");
      if (dataIdNew) {
        // Increment the value by one
        dataIdNew = parseInt(dataIdNew) + 1;
      } else {
        // Set the initial value to 1
        dataIdNew = 1;
      }
      // Set the data-id-new attribute with the updated value
      button.setAttribute("data-id-new", dataIdNew);

      TodoLists.insertBefore(button, TodoLists.firstChild);
    }

    generateTodoLists();
  </script>
  <script>
    // create color wheel
    document.addEventListener('keydown', function(event) {
      if (event.key === "Escape") {
        let formData = new FormData();
        formData.append("action", "destroysession");
        fetch("http://localhost/BMWA_UPCE/api/userlogin.php", {
          method: "POST",
          body: formData,
          credentials: 'include' // Include cookies in the request
        })
        .then(response => response.json()) // Parse response as JSON
        .then(data => {
          if (data.status) {
            sessionStorage.setItem('hasCodeRunBefore', 'false');
            window.location.href = 'logout.php'; // Redirect to the login page
          }
        })
        .catch(error => {
          alert('Odhlášení neúspěšné');
          console.log("Error:", error);
        });
      }
    });
    createcolorpicker('canvas', 'sidepicker', 'colorpreview');
  </script>
</body>
</html>
