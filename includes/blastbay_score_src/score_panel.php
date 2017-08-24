<html><head><title>Blastbay Score Server - Control Panel</title></head>
<body>
<h1>Blastbay Score Server Control Panel</h1>
<?php
require_once("score_config.php");
require_once("score_functions.php");

// Connect to MySQL.
$datalink = @mysql_connect($database_host, $database_username, $database_password);
if(!$datalink)
{
echo "<h2>Error</h2>The connection to the database failed. Please make sure you have assigned the values in score_config.php correctly.<br>";
exit;
}
@mysql_select_db($database_name, $datalink);
$make_now=0;
if(table_exists($table_prefix."sessions")==false or table_exists($table_prefix."channels")==false)
{
echo "No scoreboard seems to be setup in this database. Attempting to create it.<br><br>";
$make_now=1;
}
if($_GET['action']=="setup" or $make_now==1)
{
$q="DROP TABLE IF EXISTS ".$table_prefix."sessions";
mysql_query($q, $datalink);
$q="CREATE TABLE ".$table_prefix."sessions (";
$q.="cdid int(100) NOT NULL AUTO_INCREMENT,";
$q.="channel varchar(101) NOT NULL,";
$q.="authid varchar(30) NOT NULL,";
$q.="ip varchar(30) NOT NULL,";
$q.="username varchar(101) NOT NULL,";
$q.="usermail varchar(101) NOT NULL,";
$q.="usercountry varchar(101) NOT NULL,";
$q.="userscore int(40) NOT NULL,";
$q.="timestamp int(40) NOT NULL,";
$q.="PRIMARY KEY (cdid))";
mysql_query($q, $datalink);
echo "Creating sessions table...<br>";
echo mysql_error($datalink);
echo "<br><br>";
$q="DROP TABLE IF EXISTS ".$table_prefix."channels";
mysql_query($q, $datalink);
$q="CREATE TABLE ".$table_prefix."channels (";
$q.="channel int(100) NOT NULL AUTO_INCREMENT,";
$q.="name varchar(101) NOT NULL,";
$q.="password varchar(101) NOT NULL,";
$q.="PRIMARY KEY (channel))";
mysql_query($q, $datalink);
echo "Creating channels table...<br>";
echo mysql_error($datalink);
echo "<br><br>";
echo "Completed.<br>";
}

if($_GET['action']=="createchannel")
{
if(empty($_GET['name']) or empty($_GET['password']))
{
echo "<h2>Error</h2>Missing input.<br>";
}
else
{
if(ctype_alnum($_GET['name'])==false or ctype_alnum($_GET['password'])==false)
{
echo "<h2>Error</h2>Invalid input.<br>";
}
else
{
if(channel_exists($_GET['name'])==true)
{
echo "<h2>Error</h2>A channel with this name already exists.<br>";
}
else
{
create_channel($_GET['name'], $_GET['password']);
}
}
}
}
if($_GET['action']=="deletechannel")
{
if(empty($_GET['name']))
{
echo "<h2>Error</h2>Missing input.<br>";
}
else
{
if(ctype_alnum($_GET['name'])==false)
{
echo "<h2>Error</h2>Invalid input.<br>";
}
else
{
if(channel_exists($_GET['name'])==false)
{
echo "<h2>Error</h2>No channel with this name exists.<br>";
}
else
{
mysql_query("delete from " . $table_prefix . "channels where name='".$_GET['name']."'", $datalink);
echo("Deleting channel.<br>");
}
}
}
}
if($_GET['action']=="clearchannel")
{
if(empty($_GET['name']))
{
echo "<h2>Error</h2>Missing input.<br>";
}
else
{
if(ctype_alnum($_GET['name'])==false)
{
echo "<h2>Error</h2>Invalid input.<br>";
}
else
{
if(channel_exists($_GET['name'])==false)
{
echo "<h2>Error</h2>No channel with this name exists.<br>";
}
else
{
mysql_query("delete from " . $table_prefix . "sessions where channel='".$_GET['name']."'", $datalink);
echo("Clearing channel.<br>");
}
}
}
}


?>
<br>
<?php
fetch_channels();
?>
<br>
<h2>Create New Channel</h2>
<form action="<?php echo $_SERVER['script_name']; ?>" method="get">
<input type="hidden" name="action" value="createchannel">
Name: <input type="text" name="name" size="40"><br>
Password: <input type="password" name="password" size="40"><br>
<input type="submit" value="Create"><br>
</form>
<h2>Reset Scoreboard</h2>
Warning: If you reset the scoreboard, all channels and all scores will be lost.<br>
<br>
<a href="<?php echo $_SERVER['script_name']; ?>?action=setup">Reset Entire Scoreboard</a><br>
<br>
Copyright Blastbay Studios, 2011.<br>
</body>
</html>
