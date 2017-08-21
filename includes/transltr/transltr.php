<?php
//this is a php script which should be used alongside bgt for getting translations from transltr.org
//written by amir ramezani
//i'm not responsible for anything that can come out from usage of this script, use of this script is totaly at your own risk

//initialize cURL for obtaining the result from transltr.org
$ch=curl_init();
//allow to get the returned transfer and parse it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//action: translate, langcodes
if(isset($_POST["action"]))
{
$action=$_POST["action"];
if($action=="translate")
{
//translation starts from here
if(!isset($_POST["from"]))
{
die("you must select the language to translate the text from");
}
if(!isset($_POST["to"]))
{
die("you need to choose the language that the text translate's to");
}
if(!isset($_POST["text"]))
{
die("the translation text is empty");
}
$text=urlencode($_POST["text"]);
curl_setopt($ch, CURLOPT_URL, "http://transltr.org/api/translate?text=".$text."&to=".$_POST["to"]."&from=".$_POST["from"]);
$json=json_decode(curl_exec($ch));
echo $json->translationText;
}
else if($action=="langcodes")
{
curl_setopt($ch, CURLOPT_URL, "http://transltr.org/api/getlanguagesfortranslate");
$json=json_decode(curl_exec($ch));
foreach($json as $key => $val)
{
echo $val->languageCode.":";
}
}
else
{
die("invalid action given");
}
}
else
{
die("action must be set");
}

?>