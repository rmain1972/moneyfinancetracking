/* Main.js 
   Money Finance Tracking
*/

function loadtrans(account, mode) {
    var myurl = "https://test.moneyfinancetracking.com/loadaccounts.php";
    
    document.forms["account_form"].selected_account.value = account;
    loadDoc2(myurl, account);
    
    var myurl = "https://test.moneyfinancetracking.com/loadtransactions.php?account=" + account + "&mode=" + mode;
   
    loadDoc(myurl);
    
}

function loadDoc(myurl) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("transactions").innerHTML = this.responseText;
     var el = document.getElementById('bottomoftrans');
     el.scrollIntoView();
    }
  };
  xhttp.open("GET", myurl, true);
  xhttp.send();
}

function loadDoc2(myurl, account) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("accounts").innerHTML = this.responseText;
        var elem = document.getElementsByClassName("account_item");
        
        for (var i = 0; i < elem.lenght; i++) {
            if (i == account - 1) {
                elem[i].classList.add("selected");
            } else {
                elem[i].classList.remove("selected");
            }
        }
    }
  };
  xhttp.open("GET", myurl, true);
  xhttp.send();
}

function edit(account, transid) {
    location.assign("https://test.moneyfinancetracking.com/edit_transaction.php?account=" + account + "&transid=" + transid + "&return=main");
}

function add_transaction() {
    var account = document.forms["account_form"].selected_account.value;
    location.assign("https://test.moneyfinancetracking.com/add_transaction.php?account=" + account + "&return=main");
    
}

function delete_account_data() {
    var account = document.forms["account_form"].selected_account.value;
    
    if (confirm('Are you sure you want to delete all account information?  At this time, it does not delete starting balance.')) {
        location.assign("https://test.moneyfinancetracking.com/delete_all_transactions.php?account=" + account);
    } else {
    // Do nothing!
    }
}

function toggle_checkmark(transid) {
    var elem = document.getElementById("check-" + transid);
    
    if (elem.innerHTML == "&nbsp;") {
        elem.innerHTML = "&#x2714;";
    } else {
        if (elem.innerHTML == "✔") {
            elem.innerHTML = "R";
        } else {
            if (elem.innerHTML == "R") {
                elem.innerHTML = "&nbsp;"
            }
        }
    }
}

function FilterTransactions() {
    var elem = document.getElementById("date_controls");
    
    var account = document.forms["account_form"].selected_account.value;
    var mode = elem.value;
     
    var myurl = "https://test.moneyfinancetracking.com/loadtransactions.php?account=" + account + "&mode=" + mode;
    loadDoc(myurl);
}
