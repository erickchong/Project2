<?php
require_once("LibraryController.php");

$libraryController = new LibraryController();
$acmPapers = array();
$acmPapers = $libraryController->getACMPapersWithWord("aluminum", 10);
$numPapers = count($acmPapers);

foreach ($acmPapers as $paper)
{
	$author = $paper["authors"];
	echo "$author \n";
	$words = $paper["keywords"];
	echo "$words \n";
}


echo "Number of ACM papers: $numPapers \n";

?>