<?php
if(isset($_GET["ip"])==false)
{
$data=file_get_contents("http://api.ipinfodb.com/v3/ip-city?key=".$_GET["ApiKey"]."&ip=".$_SERVER['REMOTE_ADDR']."&format=raw");
echo $data;
}
else
{
$data=file_get_contents("http://api.ipinfodb.com/v3/ip-city?key=".$_GET["ApiKey"]."&ip=".$_GET['ip']."&format=raw");
echo $data;
}
?>