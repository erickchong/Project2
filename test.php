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

/*
$papers = $libraryController->getIEEEPapersWithAuthor("saito", 5);
$numPapers = count($papers);

echo "$numPapers \n";
foreach ($papers as $paper)
{
	$source = $paper["source"];
	echo "Source: $source \n";
	$id = $paper["id"];
	echo "ID: $id \n";
	$keywords = $paper["keywords"];
	echo "Keywords : $keywords \n";
}
*/



$papers = $libraryController->combinePapers("saito", 10);
foreach ($papers as $paper)
{
	$title = $paper["title"];
	echo "Title: $title \n";
}


/*
$bibtex = $libraryController->getBibtexForPaper("ieee", $id);
$bibtexType = gettype($bibtex);
echo "$bibtex \n";
*/
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