/* Reconcile.js 
   Money Finance Tracking
*/

function loadtrans(account) {
    var myurl = "https://test.moneyfinancetracking.com/loadaccounts.php";
    
    document.forms["account_form"].selected_account.value = account;
    loadDoc2(myurl, account);
    
    var myurl2 = "https://test.moneyfinancetracking.com/loadtransactions.php?account=" + account;
   
    loadDoc(myurl2);
    
}

function loadDoc(myurl) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("transactions").innerHTML = this.responseText;
     load_reconcile_items();
     load_reconcile_values();
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
    location.assign("https://test.moneyfinancetracking.com/edit_transaction.php?account=" + account + "&transid=" + transid + "&return=reconcile");
}

function add_transaction() {
    var account = document.forms["account_form"].selected_account.value;
    location.assign("https://test.moneyfinancetracking.com/add_transaction.php?account=" + account + "&return=reconcile");
    
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
        //Reconcile
        check_reconcile(transid);
        //Save selection for later recall, incase user does edit/add transaction
        save_reconcile_selection(transid);
        save_reconcile_values();
    } else {
        if (elem.innerHTML == "✔") {
            elem.innerHTML = "R";
        } else {
            if (elem.innerHTML == "R") {
                elem.innerHTML = "&nbsp;";
                //Undo Reconcile
                undo_reconcile(transid);
                remove_reconcile_selection(transid);
            }
        }
    }
}

function check_reconcile(transid) {
    try {
        var transaction_item = document.getElementById("trans-" + transid);
        var cn = transaction_item.childNodes;
        
        var credit_elem = transaction_item.getElementsByClassName("ticredit");
        var credit = parseFloat(credit_elem[0].textContent);
        var credits = parseFloat(document.forms["reconcile_form"].credits.value);
        
        var debit_elem = transaction_item.getElementsByClassName("tidebit");
        var debit = parseFloat(debit_elem[0].textContent);
        var debits  = parseFloat(document.forms["reconcile_form"].debits.value);
        
        var credit_subtotal = credits;
        var debit_subtotal = debits;
        
        if (isNumber(credit)) {
            credit_subtotal = credit_subtotal + credit;
        } 
        
        if (isNumber(debit)) {
            debit_subtotal = debit_subtotal + debit;    
        }
        
        var begin_balance = document.forms["reconcile_form"].beginning_balance.value;
        var end_balance = document.forms["reconcile_form"].ending_balance.value;
        var computed_balance = begin_balance - debit_subtotal + credit_subtotal
        
        //Update form
        document.getElementById("credit_subtotal").textContent = credit_subtotal.toFixed(2);
        document.forms["reconcile_form"].credits.value = credit_subtotal.toFixed(2);
        document.getElementById("debit_subtotal").textContent = debit_subtotal.toFixed(2);
        document.forms["reconcile_form"].debits.value = debit_subtotal.toFixed(2);
        document.getElementById("computed_subtotal").textContent = computed_balance.toFixed(2);
        
    } catch(err) {
        alert(err.message);    
    }
}

function undo_reconcile(transid) {
    try {
        var transaction_item = document.getElementById("trans-" + transid);
        var cn = transaction_item.childNodes;
        
        var credit_elem = transaction_item.getElementsByClassName("ticredit");
        var credit = parseFloat(credit_elem[0].textContent);
        var credits = parseFloat(document.forms["reconcile_form"].credits.value);
        
        var debit_elem = transaction_item.getElementsByClassName("tidebit");
        var debit = parseFloat(debit_elem[0].textContent);
        var debits  = parseFloat(document.forms["reconcile_form"].debits.value);
        
        var credit_subtotal = credits;
        var debit_subtotal = debits;
        
        
        if (isNumber(credit)) {
            credit_subtotal = credit_subtotal - credit;
        }
        
        if (isNumber(debit)) {
            debit_subtotal = debit_subtotal - debit;    
        }
        
        var begin_balance = document.forms["reconcile_form"].beginning_balance.value;
        var end_balance = document.forms["reconcile_form"].ending_balance.value;
        var computed_balance = begin_balance - debit_subtotal + credit_subtotal
        
        //Update form
        document.getElementById("credit_subtotal").textContent = credit_subtotal.toFixed(2);
        document.forms["reconcile_form"].credits.value = credit_subtotal.toFixed(2);
        document.getElementById("debit_subtotal").textContent = debit_subtotal.toFixed(2);
        document.forms["reconcile_form"].debits.value = debit_subtotal.toFixed(2);
        document.getElementById("computed_subtotal").textContent = computed_balance.toFixed(2);
    } catch(err) {
        alert(err.message);    
    }
     
}

function isNumber(n) { return (!isNaN(parseFloat(n)) && !isNaN(n - 0)); }

function do_reconcile() {
    // First collect all "Reconciled (checked)" items
    try {
        var json_data = '{ "transactions" : [';
  
        var transaction_items = document.getElementsByClassName("transaction_item");
        
        for (var i = 0; i < transaction_items.length; i++) {
            var cn = transaction_items[i].childNodes;
            var reconcile_node = cn[6];
            if (reconcile_node.innerHTML == "✔") {
                    json_data = json_data + '"' + transaction_items[i].getAttribute("id").toString() + '",';
            }
        }
        
        json_data = json_data.substring(0, json_data.length - 1);
        json_data = json_data + ']}';
        
        var rcd = document.getElementById("json_data");
        rcd.value = json_data;
        
        reset_reconcile();
        
        var rcf = document.getElementById("reconcile_form");
        rcf.submit();
        
    } catch(err) {
        alert(err.message);    
    }
}

function save_reconcile_selection(transid) {
    var json_data;
    var skip = 0;
    try {
        if (localStorage.getItem("transactions") === null) {
            json_data = '{ "transactions" : [' + transid;
            skip = 1;
        } else {
            json_data = localStorage.getItem("transactions");
            // Take off end of string
            json_data = json_data.substring(0,json_data.length-2)
        }
        
        if (skip === 0) {
            // Add transaction to list
            json_data = json_data + ', ' + transid;    
        }
        
        //Fix end of json data
        json_data = json_data + ']}';
        
        // Save data
        localStorage.setItem("transactions", json_data);    
    } catch(err) {
        alert(err.message);
    }
}

function remove_reconcile_selection(transid) {
    var json_data;
    
    try {
        if (localStorage.getItem("transactions") === null) {
            //Should not be null, but it if it is, skip function
            return;
        } else {
            json_data = localStorage.getItem("transactions");
            var i = json_data.search(transid);
            //var n = json_data.search('\[');
            var commax = json_data.search(',');
            var y = json_data.search('\]');
            
            // One transaction in array
            if (commax === -1) {
                localStorage.removeItem("transactions");
                alert("Only one item in array, localstorage transactions deleted");
                return;
            }
            
            var tempa = json_data.substring(0, i); //Left Half
            var tempb = json_data.substring(i); //Right Half
            alert("Left = " + tempa + ", Right = " + tempb);
            commax = tempb.search(',');
            
            // At end of arrary
            if (commax === -1) {
                json_data = tempa + "]}";
                localStorage.setItem("transactions", json_data);
                alert(json_data);
                return;
            }
            
            // In Middle of array
            var tempc = tempb.substring(commax+1);
            json_data = tempa + tempc;
            localStorage.setItem("transactions", json_data);
            
            alert(json_data);
            
        }
        
    } catch(err) {
        alert(err.message);
    }
}

function reset_reconcile() {
    localStorage.removeItem("transactions");
    localStorage.removeItem("reconcile_values");
    alert("Local storage reset!");
}

//Restore checked items
function load_reconcile_items() {
    try {
        if (localStorage.getItem("transactions") === null) {
            //Do nothing if not there
            return
        } else {
            var json_data = localStorage.getItem("transactions");
            var data = JSON.parse(json_data);
            for (var i = 0; i < data.transactions.length; i++) {
                var check_item = document.getElementById("check-" + data.transactions[i]);
                check_item.innerHTML = "✔";
            }
        }   
    } catch (err) {
        alert(err.message);
    }
}

//Saves reconcile_form values to localstorage for later recall
function save_reconcile_values() {
    try {        
        var json_data = '{ "statement_begin_date" : "' + document.forms["reconcile_form"].statement_begin_date.value + '",' +
                           '"beginning_balance" : "' + document.forms["reconcile_form"].beginning_balance.value + '",' +
                           '"ending_balance" : "' + document.forms["reconcile_form"].ending_balance.value + '",' +
                           '"debits_text" : "' + document.getElementById("debit_subtotal").innerHTML + '",' +
                           '"credits_text" : "' + document.getElementById("credit_subtotal").innerHTML + '",' +
                           '"computed_balance" : "' + document.getElementById("computed_subtotal").innerHTML + '" }';
            
        localStorage.setItem("reconcile_values", json_data);
    } catch (err) {
        alert(err.message);
    }
}

function load_reconcile_values() {
    try {
        if (localStorage.getItem("reconcile_values") === null) {
            //Do nothing if not there
            return
        } else {
            var json_data = localStorage.getItem("reconcile_values");
            var data = JSON.parse(json_data);
            
            var statement_begin_date = data.statement_begin_date;
            var beginning_balance = data.beginning_balance;
            var ending_balance = data.ending_balance;
            var debits_text = data.debits_text;
            var credits_text = data.credits_text;
            var computed_balance = data.computed_balance;
            
            alert("BEGIN_DATE:" + statement_begin_date + ", BEGIN_BALANCE: " + beginning_balance +
                  ", END_BALACE:" + ending_balance + ", DEBIT_TEXT: " + debits_text + ", CREDITS_TEXT:" +
                  credits_text + ", COMPUTE_BAL:" + computed_balance);
            
            document.forms["reconcile_form"].statement_begin_date.value = statement_begin_date;
            document.forms["reconcile_form"].beginning_balance.value = beginning_balance;
            document.forms["reconcile_form"].ending_balance.value = ending_balance;
            document.getElementById("debit_subtotal").innerHTML = debits_text;
            document.getElementById("credit_subtotal").innerHTML = credits_text;
            document.getElementById("computed_subtotal").innerHTML = computed_balance;
        } 
    }
        catch(err) {
        alert(err.message);
    }
}