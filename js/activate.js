// Javescript file for activate_account.php
// to validiate form
//
function validate() {
    
    
    var code = document.forms["activate_form"].activationcode.value;
    var codeerror_elem = document.getElementById('code_error');

    var errorval = 0;
    
    if (code == "") {
        codeerror_elem.innerHTML="You must enter a username!";
        codeerror_elem.style.display = "block";
        errorval = 1;
    } else {
        codeerror_elem.style.display = "none";  
    }
    
    if (errorval === 0) {
        return true;    
    } else {
        return false;    
    }
}