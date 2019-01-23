function confirmation() {
  var x = confirm("Are you sure you want to delete this task?");
  return x;
}

function logout() {
  var x = confirm("Are you sure you want to logout?");
  return x;
}

function validateForm() {
  var str = document.getElementById("task").value;
  var date = document.getElementById("date").value;
  var priority = document.getElementById("priority").value;
  document.getElementById("task").style.borderColor = "#ced4da";
  document.getElementById("date").style.borderColor = "#ced4da";
  document.getElementById("priority").style.borderColor = "#ced4da";

  if (str == "" || date == "" || priority == "choose") {
    alert("Please fill in all required fields.");
    if (str == "") {
      document.getElementById("task").style.borderColor = "red";
    }
    if (date == "") {
      document.getElementById("date").style.borderColor = "red";
    }
    if (priority == "choose") {
      document.getElementById("priority").style.borderColor = "red";
    }

    return false;
  }
}

function validateLogin() {
  var email = document.getElementById("loginEmail").value;
  var pwd = document.getElementById("loginPassword").value;
  document.getElementById("loginEmail").style.borderColor = "#ced4da";
  document.getElementById("loginPassword").style.borderColor = "#ced4da";

  if (email == "" || pwd == "") {
    alert("Please fill in all required fields.");
    if (email == "") {
      document.getElementById("loginEmail").style.borderColor = "red";
    }
    if (pwd == "") {
      document.getElementById("loginPassword").style.borderColor = "red";
    }
    return false;
  }
}

function validateRegister(){
  var fname = document.getElementById("regFname").value;
  var lname = document.getElementById("regLname").value;
  var email = document.getElementById("regEmail").value;
  var pwd = document.getElementById("regPassword").value;
  document.getElementById("regFname").style.borderColor = "#ced4da";
  document.getElementById("regLname").style.borderColor = "#ced4da";
  document.getElementById("regEmail").style.borderColor = "#ced4da";
  document.getElementById("regPassword").style.borderColor = "#ced4da";

  if (fname == "" || lname == "" || email == "" || pwd == "") {
    alert("Please fill in all required fields.");
    if (fname == "") {
      document.getElementById("regFname").style.borderColor = "red";
    }
    if (lname == "") {
      document.getElementById("regLname").style.borderColor = "red";
    }
    if (email == "") {
      document.getElementById("regEmail").style.borderColor = "red";
    }
    if (pwd == "") {
      document.getElementById("regPassword").style.borderColor = "red";
    }

    return false;
  }
}

