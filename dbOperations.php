<?php
/*  Group 2   The Londoners  Project  15/02/19    DB Operations */

define("DBHOST", "localhost");
define("DBDB",   "Londoners");
define("DBUSER", "londoners");
define("DBPW", "London123!");


function dbconnect($host, $db, $user, $pw){
$db_conn = new mysqli($host, $user, $pw, $db);
	if ($db_conn->connect_errno) {
   	 die ("Could not connect to database server".$db_host."\n Error: "
			.$db_conn->connect_errno 
			."\n Report: ".$db_conn->connect_error."\n");
	}
	return $db_conn;
}

function dbdisconnect($db_conn){
	$db_conn->close();
}

// get post deatis for the selecgted category
function getPostsByCategoryID($category_id){

	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

	$qry_post = "select * from post_master  pm
				  left outer join member_profile mp
				  on pm.member_id =mp.member_id"				
				." where pm.category_id =".$category_id." order by pm.post_date DESC;";
	$rs = $db_conn->query($qry_post);
        // showQueryErrors($db_conn,$qry_post);
	
	dbdisconnect($db_conn);
	return $rs;

}

function formPost_Delete($post_id)
{
	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

	$qry_post = "UPDATE post_master SET post_active = 'D' WHERE post_master_id =".$post_id.";" ;
	$rs = $db_conn->query($qry_post);
        // showQueryErrors($db_conn,$qry_post);
	
	dbdisconnect($db_conn);
	return $rs;

}

function formPost_Archive($post_id)
{
	$db_conn = dbconnect(DBHOST, DBDB, DBUSER, DBPW);

	$qry_post = "UPDATE post_master SET post_active = 'A' WHERE post_master_id =".$post_id.";" ;
	$rs = $db_conn->query($qry_post);
        // showQueryErrors($db_conn,$qry_post);
	
	dbdisconnect($db_conn);
	return $rs;

}

?>
