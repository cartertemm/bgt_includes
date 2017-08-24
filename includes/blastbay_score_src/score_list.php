<?php
// This file should be included when you wish to list the scores on a board.

// After including it, simply call the fetch_users function with the name of the board and the number of entries to retrieve.

// The entries are split up by a \n character, and the beginning of each field contains a number and an = sign.
// 1 is the user's name, 2 is their score, 3 is their email address and 4 is their country.
// Note that one or more fields may be empty for a particular user, but the \n character will always be present.

require_once("score_config.php");
require_once("score_functions.php");

// Connect to MySQL.
$datalink = @mysql_connect($database_host, $database_username, $database_password);
if(!$datalink)
{
echo("error failed database connection");
exit;
}
@mysql_select_db($database_name, $datalink);

?>