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

$papers = $libraryController->getACMPapersWithAuthor("saito", 2);
$numPapers = count($papers);

echo "$numPapers \n";
$id = $papers[0]["id"];
echo "$id \n";
$bibtex = $libraryController->getACMBibtex($id);
$bibtexType = gettype($bibtex);
echo "$bibtex \n";
/*
foreach ($papers as $paper)
{
	$abstract = $libraryController->getACMAbstract($paper["id"]);
	echo "$abstract \n";
	$type = gettype($abstract);
	echo "Type: $type \n";
	break;
}
*/

?>