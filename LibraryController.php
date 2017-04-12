<?php
ini_set('max_execution_time', 300);

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
	
	
	
	// $authors should be a string of author names
	public function parseAuthors($authors)
	{	
		$result = array();
		$authors = (string)$authors;
		$authors = html_entity_decode(htmlentities($authors));
		$authors = trim(preg_replace('/\s+/', ' ', $authors)); // removes all unneccessary spaces and newlines
		$authors = str_replace(" and ", "; ", $authors); // Done to help parse ACM authors
		$builder = "";
		$readAuthor = false;
		
		//echo "$authors \n";
		for ($i = 0; $i < strlen($authors); $i++)
		{
			//$builder .= $authors;
			//echo "$builder \n";
			if (substr($authors, $i, 2) == "; " || $i == strlen($authors) - 1)
			{
				//echo "In first else \n";
				if ((substr($authors, $i, 1) != ";" && substr($authors, $i, 1) != " ") || $i == strlen($authors) - 1)
				{
					$builder .= substr($authors, $i, 1);
				}
				$result[] = $builder;
				$builder = "";
				$readAuthor = false;
			}
			else if ($readAuthor == true)
			{
				//echo "In 2nd else \n";
				$builder .= substr($authors, $i, 1);
			}
			else if ($readAuthor == false && substr($authors, $i, 1) != " ")
			{
				//echo "In 3rd else \n";
				$builder .= substr($authors, $i, 1);
				$readAuthor = true;
			}
		}
		return $result;
	}
	
	function getACMPapersWithAuthor($name, $limit)
	{	
		$papers = array();

		$acmURL = 'http://dl.acm.org/exportformats_search.cfm?query=persons%2Eauthors%2EpersonName%3A%28%252B' . urlencode($name) . '%29&srt=%5Fscore&expformat=csv';
		$acmCSV = file_get_contents($acmURL);

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
	
	function getACMPapersWithWord($word, $limit)
	{
		$papers = array();

		$acmURL = 'http://dl.acm.org/exportformats_search.cfm?query=' .rawurlencode($word). '&filtered=&within=owners%2Eowner%3DHOSTED&dte=&bfr=&srt=%5Fscore&expformat=csv';
		$acmCSV = file_get_contents($acmURL);

		$lines = $this->parseCSV($acmCSV);
		
		foreach ($lines as $line) {
			$paper = array();
			
			$paper["source"] = "acm";
			
			// Query the paper title
			$paper["title"] = $line["title"];
			
			// Query the paper authors
			// TODO: Need to parse author names when multiple authors are present
			$abc = $line["author"];
			$paper["authors"] = $this->parseAuthors($abc);
			
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

	function getACMPapersWithConference($conference, $limit){

	}

	function getACMAbstract($title){
		
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
        	$paper["source"] = "ieee";
        	$paper["title"] = $document->title[0]; 
        	$paper["authors"] = $document->authors; //need to parse 
        	$paper["abstract"] = $document->abstract; 
        	$paper["keywords"]  = "";
        	$count = count($document->thesaurusterms->term);
        	
        	for($a = 0; $a < $count; $a++){
        		$word = $document->thesaurusterms->term[$a];
        		$paper["keywords"]  =  $paper["keywords"]. " ". $word;
        	}

        	$paper["pdfURL"] = $document->pdf;
        	$paper["publication"] = $document->pubtitle;
        	$papers[] = $paper;

        }
        // Added the if statement to deal with 2 extraneous "papers" (xml parsing problem?)
		if (count($papers) > 2)
        {
        	$papers = array_slice($papers, 2, count($papers));
        }
		return $papers;
	}
	
	function getIEEEPapersWithWord($word, $limit)
	{	
		$papers = array();
		$ieeeURL = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?thsrsterms=' .rawurlencode($word). '&hc=' .rawurlencode($limit);
        $response = file_get_contents($ieeeURL);
        $documents = simplexml_load_string($response);
        foreach($documents as $document){
        	$paper = array();
        	$paper["source"] = "ieee";
        	$paper["title"] = $document->title[0]; 
        	
        	$abc = $document->authors;
			$paper["authors"] = $this->parseAuthors($abc);//need to parse 
        	$paper["abstract"] = $document->abstract; 
        	$paper["keywords"]  = "";
        	$count = count($document->thesaurusterms->term);
        	
        	for($a = 0; $a < $count; $a++){
        		$word = $document->thesaurusterms->term[$a];
        		$paper["keywords"]  =  $paper["keywords"]. " ". $word;
        	}
        	
        	$paper["pdfURL"] = $document->pdf;
        	$paper["publication"] = $document->pubtitle;
        	$papers[] = $paper;

        }
        // Added the if statement to deal with 2 extraneous "papers" (xml parsing problem?)
        if (count($papers) > 2)
        {
        	$papers = array_slice($papers, 2, count($papers));
        }
		return $papers;
	}

	function getIEEEPapersWithConference($conference, $limit){
		$papers = array();
		$ieeeURL = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?jn=' .rawurlencode($conference). '&hc=' .rawurlencode($limit);
        $response = file_get_contents($ieeeURL);
        $documents = simplexml_load_string($response);
        foreach($documents as $document){
        	$paper = array();
        	$paper["source"] = "ieee";
        	$paper["title"] = $document->title[0]; 
        	
        	$abc = $document->authors;
			$paper["authors"] = $this->parseAuthors($abc);//need to parse 
        	$paper["abstract"] = $document->abstract; 
        	$paper["keywords"]  = "";
        	$count = count($document->thesaurusterms->term);
        	
        	for($a = 0; $a < $count; $a++){
        		$word = $document->thesaurusterms->term[$a];
        		$paper["keywords"]  =  $paper["keywords"]. " ". $word;
        	}
        	
        	$paper["pdfURL"] = $document->pdf;
        	$paper["publication"] = $document->pubtitle;
        	$papers[] = $paper;

        }
        // Added the if statement to deal with 2 extraneous "papers" (xml parsing problem?)
        if (count($papers) > 2)
        {
        	$papers = array_slice($papers, 2, count($papers));
        }
		return $papers;
	}

	function getIEEEAbstract($title){

		$ieeeURL = 'http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?ti=' .rawurlencode($title);
        $response = file_get_contents($ieeeURL);
        $documents = simplexml_load_string($response);
        $abstract_is = "";
        foreach($documents as $document){
        	$abstract_is = $document->abstract;
        }
        
		return $abstract_is;
	}
	
	function combineKeywords($author, $limit)
	{
		$libraryController = new LibraryController();
		$acmPapers = $libraryController->getACMPapersWithAuthor($author, $limit);
		$ieeePapers = $libraryController->getIEEEPapersWithAuthor($author, $limit);
		$keywords = "";
		if(count($acmPapers)==0 && count($ieeePapers)==0){

		}else{
			foreach($acmPapers as $paper){
				$keystring = $paper["keywords"];
				$keywords = $keywords." ".$keystring;
			}
			foreach($ieeePapers as $paper){
				$keystring = $paper["keywords"];
				$keywords = $keywords." ".$keystring;
			}
			//$keywords = $acmPapers["keywords"] . " " . $ieeePapers["keywords"];
			$keywords = trim(preg_replace('/\s+/', ' ', $keywords)); // removes all unneccessary spaces and newlines
		}
		
		return $keywords;
	}
	
	function combinePapers($word, $limit)
	{
		$libraryController = new LibraryController();
		$acmPapers = $libraryController->getACMPapersWithWord($word, $limit);
		$ieeePapers = $libraryController->getIEEEPapersWithWord($word, $limit);
		$papers = array_merge($acmPapers, $ieeePapers);
		$numPapers = count($papers);
		//echo "Initial amount of papers: $numPapers \n";
		if (count($papers > $limit))
		{
			shuffle($papers); // Randomize order of papers
			$papers = array_slice($papers, 0, $limit); // Get only the first $limit papers
		}
		$cnt = count($papers);
		// for($x = 0; $x < $cnt; $x++){
		// 	echo $x. " : ".$papers[$x]['title']." \n ";
		// }
		return $papers;
	}

	function getPapersForConference($conference, $source, $limit)
	{
		$libraryController = new LibraryController();
		$papers = array();
		if($source=='acm'){
			$papers = $libraryController->getACMPapersWithConference($conference, $limit);
		}else{
			$papers = $libraryController->getIEEEPapersWithConference($conference, $limit);
		}

		return $papers;
	}

	function getAbstractForPaper($title, $source)
	{
		$libraryController = new LibraryController();
		$abstract = "";
		if($source=='acm'){
			$abstract = $libraryController->getACMAbstract($title);
		}else{
			$abstract = $libraryController->getIEEEAbstract($title);
		}
	
		return $abstract;
	}
}
?>