/* edit_transaction.js 
   Money Finance Tracking
*/

function getcategories(category) {
    var myurl = "https://test.moneyfinancetracking.com/getcategories.php?account=1&setcat=" + category;
    
    loadDoc(myurl);
}

function loadDoc(myurl) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("category_field").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", myurl, true);
  xhttp.send();
}

// Javescript file for register.html
// to validiate form
//
function validate() {
    
    
    var transdate = document.forms["edit_transaction_form"].trans_date_field.value;
    var dateerror_elem = document.getElementById('trans_date_error');
    var dateinput_elem = document.getElementById('trans_date_field_input');
    var payee_error = document.forms["edit_transaction_form"].payee_field.value;
    var payee_field_error_elem = document.getElementById('payee_field_error');
    var payee_field_input_elem = document.getElementById('payee_field_input');
    var startDate = document.forms["edit_transaction_form"].startingDate.value;
    
    var errorval = 0;
    
    if (payee_error == "") {
        payee_field_error_elem.innerHTML="You must enter a name for the Payee field!";
        payee_field_error_elem.style.display = "block";
        payee_field_input_elem.style.height = "50%";
        
        errorval = 1;
    } else {
        payee_field_error_elem.style.display = "none";
        payee_field_input_elem.style.height = "100%";
    }
    
    if (transdate < startDate) {
        dateerror_elem.innerHTML="<p>Transaction date must be on or after beginning balance data</p>";
        dateerror_elem.style.display = "block";
        dateinput_elem.style.height = "50%";
        errorval = 1;   
    } else {
        dateerror_elem.style.direction = "none";
        dateinput_elem.style.height = "100%"
    }
    
    
    if (errorval === 0) {
        return true;    
    } else {
        return false;    
    }
} 

function delete_transaction(account, transid, rtn) {
location.assign("https://test.moneyfinancetracking.com/delete_transaction.php?account=" + account + "&transid=" + transid + "&return=" + rtn);
    
    return false;
}