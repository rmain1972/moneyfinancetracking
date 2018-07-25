// Javescript file for register.html
// to validiate form
//
function validate() {
    
    
    var name = document.forms["register_form"].username.value;
    var nameerror_elem = document.getElementById('username_error');
    var email = document.forms["register_form"].email.value;
    var emailerror_elem = document.getElementById('email_error');
    var pass1 = document.forms["register_form"].userpassword.value;
    var passerror_elem = document.getElementById('password_error');
    var pass2 = document.forms["register_form"].userpass2.value;
    var pass2error_elem = document.getElementById('pass2_error');
    
   
    var errorval = 0;
    
    if (name == "") {
        nameerror_elem.innerHTML="You must enter a username!";
        nameerror_elem.style.display = "block";
        errorval = 1;
    } else {
        nameerror_elem.style.display = "none";  
    }
    
    if ((email == "") || (checkEmail())) {
        emailerror_elem.style.display = "block";
        errorval = 1;
    } else {
        emailerror_elem.style.display = "none";
    }
    
    if (pass1 == "") {
        passerror_elem.style.display = "block";
        errorval = 1;
    } else {
        passerror_elem.style.display = "none";   
    }
    
    if ((pass2 === "") || (pass2 != pass1)){
        pass2error_elem.style.display = "block";
        errorval = 1;
    } else {
        pass2error_elem.style.display = "none";
    }
    
    if (errorval === 0) {
        return true;    
    } else {
        return false;    
    }
} 


function checkEmail() {

    var email = document.forms["register_form"]["email"].value
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    email.focus;
    return false;
    } else {
        return true;
    }
}

function checkusername() {
    var name = document.forms["register_form"].username.value;
    
    var myurl = "https://test.moneyfinancetracking.com/checkusername.php?username=" + name;
    
    loadDoc(myurl);
}

function loadDoc(myurl) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("data").innerHTML = this.responseText;
     var nameerror_elem = document.getElementById('username_error');
     if (this.responseText == "EXISTS") {
         nameerror_elem.style.display = "block";
         nameerror_elem.innerHTML="Username exists";
     } else {
        nameerror_elem.style.display = "none";    
     }
    }
  };
  xhttp.open("GET", myurl, true);
  xhttp.send();
} 