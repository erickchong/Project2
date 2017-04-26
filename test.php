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


$papers = $libraryController->getIEEEPapersWithWord("java", 5);
$numPapers = count($papers);

echo "$numPapers \n";

foreach ($papers as $paper)
{
	$doi = $paper["doi"];
	echo "DOI: $doi \n";
	$bibtex = $libraryController->getIEEEBibtex($doi);
	echo "$bibtex \n";
	break;
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