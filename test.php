<?php
require_once("LibraryController.php");

$libraryController = new LibraryController();
/*
$acmPapers = array();
$acmPapers = $libraryController->getACMPapersWithWord("aluminum", 20);
$numPapers = count($acmPapers);

foreach ($acmPapers as $paper)
{
	$authors = $libraryController->parseAuthors($paper["authors"]);
	echo "Paper: \n";
	foreach ($authors as $author)
	{
		echo "$author \n";
	}
	
}
echo "Number of ACM papers: $numPapers \n";
*/

$papers = $libraryController->combinePapers("aluminum", 20);
$numPapers = count($papers);
echo "$numPapers \n";

?>