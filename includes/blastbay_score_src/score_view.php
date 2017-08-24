<table>
<tr>
<td>Rank</td>
<td>Name</td>
<td>Score</td>
<td>Email</td>
<td>Country</td>
</tr>
<?php
$channel="Nicklas";
$default_score_count=10;

// Do not modify the following PHP code.
require_once("score_list.php");
$entries=$default_score_count;
if(!empty($_GET['count']))
{
$count=$_GET['count'];
if(is_numeric($count))
{
$entries=(int)$count;
if($entries>100)
{
$entries=100;
}
}
}
$score_string=fetch_users($channel, $entries);
$user_array=explode("\n", $score_string);
$current=0;
for($i=0;$i<count($user_array);$i+=4)
{
echo("<tr>");
echo("<td>");
echo($current +1);
echo(".</td>");
for($field=0;$field<4;$field++)
{
if($user_array[$i+$field]=="")
{
echo("<td></td>");
}
else
{
echo("<td>" . substr($user_array[$i+$field], 2) . "</td>");
}
}
echo("</tr>");
$current++;
}
?></table>
<br>
Number of scores: 
<form action="<?php echo($_SERVER['SCRIPT_NAME']); ?>" method="get">
<select name="count">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
<input type="submit" value="Go">
</form>