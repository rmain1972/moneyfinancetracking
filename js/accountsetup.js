// Javescript file for login.html
// to validiate form
//
function validate() {
    
    var name = document.forms["accountsetup_form"].accountname.value;
    var nameerror_elem = document.getElementById('name_error');
    var sbdate = document.forms["accountsetup_form"].starting_balance_date.value;
    var sbdate_elem = document.getElementById('sbdate_error');
    var sbnum = document.forms["accountsetup_form"].starting_balance.value;
    var sbnum_elem = document.getElementById('sbdnum_error');
   
    var errorval = 0;
    
    if (name == "") {
        nameerror_elem.style.display = "block";
        errorval = 1;
    } else {
        nameerror_elem.style.display = "none";  
    }
    
    if (sbdate == "") {
        sbdate_elem.style.display = "block";
        errorval = 1;
    } else {
        sbdate_elem.style.display = "none";   
    }
    
     if (sbnum == "") {
        sbnum_elem.style.display = "block";
        errorval = 1;
    } else {
        sbnum_elem.style.display = "none";   
    }
     
    if (errorval === 0) {
        return true;    
    } else {
        return false;    
    }
} 
