// Javescript file for login.html
// to validiate form
//
function validate() {
    
    var name = document.forms["register_form"].username.value;
    var nameerror_elem = document.getElementById('username_error');
    var pass1 = document.forms["register_form"].userpassword.value;
    var passerror_elem = document.getElementById('password_error');
   
    var errorval = 0;
    
    if (name == "") {
        nameerror_elem.innerHTML="You must enter a username!";
        nameerror_elem.style.display = "block";
        errorval = 1;
    } else {
        nameerror_elem.style.display = "none";  
    }
    
    if (pass1 == "") {
        passerror_elem.style.display = "block";
        errorval = 1;
    } else {
        passerror_elem.style.display = "none";   
    }
     
    if (errorval === 0) {
        return true;    
    } else {
        return false;    
    }
} 
