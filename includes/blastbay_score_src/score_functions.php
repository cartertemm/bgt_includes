<?php
function fetch_channels()
{
global $datalink, $table_prefix;
$q="SELECT * FROM ".$table_prefix."channels";
$result = @mysql_query($q, $datalink);
$url=$_SERVER['SCRIPT_NAME'];
?>
<h2>Channel List</h2>
<table>
<tr>
<td>Name</td>
<td>Password</td>
<td>Clear</td>
<td>Delete</td>
</tr>
<?php

while($s = mysql_fetch_array($result))
{
echo("<tr>");
echo("<td>" . $s['name'] . "</td>");
echo("<td>" . $s['password'] . "</td>");
echo("<td><a href=\"".$url."?action=clearchannel&name=".$s['name']."\">Clear</a></td");
echo("<td><a href=\"".$url."?action=deletechannel&name=".$s['name']."\">Delete</a></td");
echo("</tr>");
}
?></table>
<?php
}

function user_exists($auth)
{
global $datalink, $table_prefix, $ip;
if(!ctype_alnum($auth))
{
return false;
}
$q="SELECT COUNT(*) FROM ".$table_prefix."sessions where authid='$auth' and ip='$ip'";
$total = @mysql_query($q, $datalink);
$total = mysql_fetch_array($total);
if($total[0]==1)
{
return true;
}
return false;
}

function channel_exists($channel)
{
global $datalink, $table_prefix;
if(!ctype_alnum($channel))
{
return false;
}
$q="SELECT COUNT(*) FROM ".$table_prefix."channels where name='$channel'";
$total = @mysql_query($q, $datalink);
$total = mysql_fetch_array($total);
if($total[0]==1)
{
return true;
}
return false;
}

// This function should be part of the control panel interface, not the server.
function create_channel($name, $password)
{
global $datalink, $table_prefix;
$q="insert into " . $table_prefix . "channels values ('','$name','$password')";
@mysql_query($q, $datalink);
echo "Creating channel.<br>";
echo mysql_error($datalink);
}

function update_user_info($auth, $channel, $userscore, $username, $usermail='', $usercountry='')
{
global $datalink, $table_prefix, $ip, $current_time;
$username=mysql_real_escape_string($username);
$usermail=mysql_real_escape_string($usermail);
$usercountry=mysql_real_escape_string($usercountry);
$q="update ".$table_prefix."sessions set userscore=".$userscore.", username='$username', usermail='$usermail', usercountry='$usercountry', channel='$channel', timestamp=".$current_time." where authid='$auth'";
@mysql_query($q, $datalink);
}

function fetch_users($channel, $entries)
{
global $datalink, $table_prefix;
if(!ctype_alnum($channel))
{
return false;
}
$q="SELECT * FROM ".$table_prefix."sessions where username!='' and channel='$channel' ORDER BY userscore desc limit ".$entries;
$result = @mysql_query($q, $datalink);
$output="";
while($s = mysql_fetch_array($result))
{
if($output!="")
{
$output.="\n";
}
$output.="1=".$s['username']."\n2=".$s['userscore']."\n3=".$s['usermail']."\n4=".$s['usercountry'];
}
return $output;
}

function get_rank($channel, $auth)
{
global $datalink, $table_prefix;
if(!ctype_alnum($channel))
{
return false;
}
$q="SELECT * FROM ".$table_prefix."sessions where username!='' and channel='$channel' ORDER BY userscore desc";
$result = @mysql_query($q, $datalink);
$rank=0;
while($s = mysql_fetch_array($result))
{
$rank+=1;
if($s['authid']==$auth)
{
return $rank;
}
}
return 0;
}

function get_channel_info($channel)
{
global $datalink, $table_prefix;
$q="select * from ".$table_prefix."channels where name='$channel'";
$result=@mysql_query($q);
if(mysql_numrows($result)==0)
{
echo "error invalid channel";
exit;
}
$s = mysql_fetch_array($result);
return $s;
}

function table_exists($table)
{
global $datalink;
$result = mysql_query("show tables like '$table'",$datalink);
if (mysql_num_rows ($result)>0)
return true;
else
return false;
}

?>