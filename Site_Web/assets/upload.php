<?php
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
if(!isset($_GET['uniq_hash']) || $_GET['uniq_hash'] == NULL)
{
	print "ERROR: Hash obligatoire !\n";
	exit();
}

$filename = $_GET['uniq_hash'] . '.jpg';
$result = file_put_contents('../../Base_de_donnees/tmp/' . $filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

print "$filename\n";
?>
