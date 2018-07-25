<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracking -- Database Page</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>   
<body>

<section id="Main-Page">
<div id="main-page-content">
	<div id="main-page-content_container">
		<div class="three_fourth">
			<p>This is a holder page for the database test page.  Updated 3-1-2018</p>

<?php
include('mysqlnfo.php');
//Try to connect to the database.
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    print '<p>You have successfully connected to the database.</p>';
    print '<ul>';
	print '<li><a href="create_blog_db.php">Create Blog Database</a></li>';
	print '<li><a href="create_blog_tbl.php">Create Blog Table</a></li>';
    print '<li><a href="insert_blog_data.php">Insert Dummy Data into Blog table</a></li>';
	print '<li><a href="drop_blog_tbl.php">Drop Blog Table</a></li>';
    print '<li>Download <a href="Ralph_Main_EM328_exportdb.sql">Ralph_Main_EM328_exportdb.sql</a></li>';
    print '<li><a href="create_store_tbl.php">Create Store Items Table</a></li>';
    print '<li><a href="insert_items_data.php">Insert Dummy Data into Store Items table</a></li>';
    print '<li><a href="drop_store_tbl.php">Drop Store Items Table</a></li>';
    print '<li><a href="create_msg_tbl.php">Create Message Table</a></li>';
    print '<li><a href="insert_msg_data.php">Insert Dummy Messages into msg table</a></li>';
    print '<li><a href="drop_msg_tbl.php">Drop msg Table</a></li>';
    print '<li>Download <a href="Ralph_Main_EM328_U4IP_exportdb.sql">Ralph_Main_EM328_U4IP_exportdb.sql</a></li>';
    print '</ul>';
    mysqli_close($dbc);
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}

?>
            <p><strong>Since I am just starting out, my prices are lower until I get some professional projects under my belt. 
               So book my time, and I'll get started on your project!</strong></p>
		</div>
		<div class="resetColumnSet"></div>	
	</div>
</div>
</section>

</body>
</html>
