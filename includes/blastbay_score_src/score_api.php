<?php
require_once("score_config.php");
require_once("score_functions.php");

// Are we missing the action parameter?
if(empty($_POST['action']))
{
echo "error missing input";
exit;
}
$ip=$_SERVER['REMOTE_ADDR'];
$action=$_POST['action'];

// Connect to MySQL.
$datalink = @mysql_connect($database_host, $database_username, $database_password);
if(!$datalink)
{
echo("error failed database connection");
exit;
}
@mysql_select_db($database_name, $datalink);

// Delete any unverified entries that are older than the allowed timeframe.
$current_time=time();
$time_of_doom=$current_time-$expire_time;
@mysql_query("delete from " . $table_prefix . "sessions where timestamp<" . $time_of_doom . " and channel=''", $datalink);

// Look for different actions and respond appropriately.
if($action=="initauth")
{

// This is the initial request that a client sends, where we give them a session ID.
$id=uniqid("bss", true);
$id=str_replace(".", "", $id);
$q="insert into " . $table_prefix . "sessions (authid,timestamp,channel,ip,username) values ('$id',".$current_time.", '', '$ip', '')";
@mysql_query($q, $datalink);
echo $id;
exit();
}

if($action=="auth")
{

// This is the main verification step. First, check for idiotic input.
if(empty($_POST['auth']))
{
echo "error missing input";
exit;
}
$auth=$_POST['auth'];
if(empty($_POST['authkey']))
{
echo "error missing input";
exit;
}
$authkey=$_POST['authkey'];
if(empty($_POST['username']))
{
echo "error missing input";
exit;
}
$username=$_POST['username'];
if(empty($_POST['channel']))
{
echo "error missing input";
exit;
}
$channel=$_POST['channel'];
if(!ctype_alnum($authkey))
{
echo "error invalid auth key";
exit;
}
if(empty($_POST['userscore']))
{
echo "error missing input";
exit;
}
$userscore=$_POST['userscore'];
if(!is_numeric($userscore))
{
echo "error invalid score";
exit;
}
$userscore=(int)$userscore;
if(!ctype_alnum($channel))
{
echo "error invalid channel";
exit;
}
$usermail='';
if(!empty($_POST['usermail']))
{
$usermail=$_POST['usermail'];
}
$usercountry='';
if(!empty($_POST['usercountry']))
{
$usercountry=$_POST['usercountry'];
}

// Check whether a session with the given ID exists, meaning the client issued an "initauth" action properly.
if(user_exists($auth)==false)
{
echo "error invalid auth";
exit;
}

// Retrieve the information about the requested channel from the database.
$channel_info=get_channel_info($channel);

// Generate the correct key with a sha256 hash of the session ID and channel password.
$authkey=strtolower($authkey);
$authhash=$auth.$channel_info['password'];
$authhash=hash("sha256", $authhash, false);

// Do they match?
if($authhash==$authkey)
{

// They do, so submit the score.
update_user_info($auth, $channel, $userscore, $username, $usermail, $usercountry);
echo "rank ";
echo get_rank($channel, $auth);
exit;
}
else
{

// Not a match, so we die.
echo "error invalid auth key";
exit;
}
exit;
}

if($action=="list")
{
if(empty($_POST['channel']))
{
echo "error missing input";
exit;
}
$channel=$_POST['channel'];
$entries=10;
if(!empty($_POST['entries']))
{
if(is_numeric($_POST['entries']))
{
$entries=(int)$_POST['entries'];
if($entries<0)
{
$entries=10;
}
}
}

if(channel_exists($channel)==false)
{
echo "error invalid channel";
exit;
}
// Now we output the users.
echo "list\n";
echo fetch_users($channel, $entries);
exit;
}
if($_GET['action']=="list")
{
if(empty($_GET['channel']))
{
echo "error missing input";
exit;
}
$channel=$_GET['channel'];
$entries=10;
if(!empty($_GET['entries']))
{
if(is_numeric($_GET['entries']))
{
$entries=(int)$_GET['entries'];
if($entries<0)
{
$entries=10;
}
}
}

if(channel_exists($channel)==false)
{
echo "error invalid channel";
exit;
}
// Now we output the users.
echo print_users($channel, $entries);
exit;
}
echo "error invalid input";

?>