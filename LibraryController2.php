<?php

class LibraryController {
	
	function __construct() {}

	private function parseCSV($text)
	{
		$lines = explode(PHP_EOL, $text);
		$keys = str_getcsv($lines[0]);
		
		$out = array();
		foreach (array_slice($lines, 1) as $line)
		{
			$values = str_getcsv($line);
			if (count($keys) == count($values)) {
				$out[] = array_combine($keys, $values);
			}
		}
		
		return $out;
	}
	
	
	function getACMPapersWithAuthor($name, $limit)
	{	
		$papers = array();

		$acmURL = 'http://dl.acm.org/exportformats_search.cfm?query=persons%2Eauthors%2EpersonName%3A%28%252B' . urlencode($name) . '%29&srt=%5Fscore&expformat=csv';
		$acmCSV = file_get_contents($acmURL); // this request is a bottleneck

		$lines = $this->parseCSV($acmCSV);
		
		foreach ($lines as $line) {
			$paper = array();
			
			$paper["source"] = "acm";
			
			// Query the paper title
			$paper["title"] = $line["title"];
			
			// Query the paper authors
			// TODO: Need to parse author names when multiple authors are present
			$paper["authors"] = $line["author"];
			
			// Query the paper publication name
			$paper["publication"] = $line["booktitle"];
			
			// Derive the full text URL name from the ID
			$paper["pdfURL"] = "http://dl.acm.org/ft_gateway.cfm?id=" . $line["id"];
			
			// Query the paper abstract
			$paper["abstract"] = "";
			
			$line["keywords"] = str_replace(",", "",$line["keywords"]); //remove commas
			$line["keywords"] = strtolower($line["keywords"]); //convert to lower case
			
			// Query the keyword terms
			$paper["keywords"] = $line["keywords"];
			
			$papers[] = $paper;
			
			if (count($papers) == $limit)
			{
				break;
			}
		}
		
		return $papers;
	}
	function getIEEEPapersWithAuthor($name, $limit)
	{	
		$papers = array();
		$urlBase = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?';
        $author_name = "au=" . $name;
        $limit_number = "&hc=".$limit;
        $query = $urlBase . $author_name . $limit_number;
        $response = file_get_contents($query);
        $documents = simplexml_load_string($response);
        foreach($documents as $document){
        	$paper = array();
        	$paper["title"] = $document->title[0]; 
        	$paper["authors"] = $document->authors; //need to parse 
        	$paper["abstract"] = $document->abstract; 
        	$paper["keywords"]  = "";
        	
        	foreach($document->thesaurusterms as $keyword){
        		$word = $keyword->term;
        		$paper["keywords"]  =  $paper["keywords"]. " ". $word;	
        	}

        	$paper["pdfURL"] = $document->pdf;


        }
		
		return $papers;
	}
	
	function combineKeywords($author, $limit)
	{
		$libraryController = new LibraryController();
		$acmPapers = $libraryController->getACMPapersWithAuthor($author, $limit);
		$ieeePapers = $libraryController->getIEEEPapersWithAuthor($author, $limit);
		$keywords = $acmPapers["keywords"] . " " . $ieeePapers["keywords"];
		return $keywords; 
		
	}
	
	
}
?>