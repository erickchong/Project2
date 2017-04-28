<?php
require_once 'LibraryController.php';
use PHPUnit\Framework\TestCase;

class LibraryControllerTest extends TestCase
{
	private $libraryController;

	protected function setUp()
	{
		$this->libraryController = new LibraryController();
	}
	
	public function testCombineKeywords()
	{
		$authorName = "saito";
		$limit = 5;
		$keywords = "";
		$keywords = $this->libraryController->combineKeywords($authorName, $limit);

		$this->assertGreaterThan(0, count($keywords));
	}

	public function testCombinePapers()
	{
		$word = "analysis";
		$limit = 5;
		$papers = array();
		$papers = $this->libraryController->combinePapers($word, $limit);

		$this->assertGreaterThan(0, count($papers));
		$this->assertLessThanOrEqual($limit, count($papers));

		$acmCount = 0;
		$ieeeCount = 0;
		foreach ($papers as $paper)
		{
			$source = $paper["source"];
			if ($source == "acm")
			{
				$acmCount++;
			}
			else
			{
				$ieeeCount++;
			}
		}

		$this->assertGreaterThan(0, $acmCount);
		$this->assertGreaterThan(0, $ieeeCount);
	}
	
	public function testGetPapersForConferenceACM()
	{
		$conference = "Proceedings of the 23rd Symposium on Integrated Circuits and System Design";
		$limit = 5;
		$acmPapers = $this->libraryController->getPapersForConference($conference, "acm", $limit);

		$this->assertGreaterThan(0, count($acmPapers));
		$this->assertLessThanOrEqual($limit, count($acmPapers));

	}
	
	public function testGetPapersForConferenceIEEE()
	{
		$conference = "2012 Conference on Lasers and Electro-Optics (CLEO)";
		$limit = 5;
		$ieeePapers = $this->libraryController->getPapersForConference($conference, "ieee", $limit);

		$this->assertGreaterThan(0, count($ieeePapers));
		$this->assertLessThanOrEqual($limit, count($ieeePapers));
	}

	public function testGetAbstractForPaperACM()
	{
		$abstract = "";
		$title = ":)";
		// Chose a known specific id
		$abstract = $this->libraryController->getAbstractForPaper($title, "acm", "1900331");
		$this->assertGreaterThan(0, strlen($abstract));
	}

	public function testGetAbstractForPaperIEEE()
	{
		$abstract = "";
		$title = ":)";
		// Chose a known specific id
		$abstract = $this->libraryController->getAbstractForPaper($title, "ieee", "4548940");
		$this->assertGreaterThan(0, strlen($abstract));
	}
	
	public function testGetBibtexForPaperACM()
	{
		$bibtex = $this->libraryController->getBibtexForPaper("acm", "1348556", "1348556");
		$this->assertGreaterThan(0, strlen($bibtex));
	}
	
	public function testGetBibtexForPaperIEEE()
	{
		$bibtex = $this->libraryController->getBibtexForPaper("ieee", "blargh", "10.1109/IEMBS.2008.4650035");
		$this->assertGreaterThan(0, strlen($bibtex));
	}
	
	public function testGetBibtedForPaperIEEEFail()
	{
		$bibtex = $this->libraryController->getBibtexForPaper("ieee", "blargh", "ahaha");
		$this->assertEquals("Bibtex not available :(", $bibtex);
	}

	public function testCombineKeywordsForMultiplePapersACM()
	{
		$papers = array("acm-1348556");
		$keywords = $this->libraryController->combineKeywordsForMultiplePapers($papers);
		$this->assertGreaterThan(0, count($keywords));
	}

	public function testCombineKeywordsForMultiplePapersIEEE()
	{
		$papers = array("ieee-4650035");
		$keywords = $this->libraryController->combineKeywordsForMultiplePapers($papers);
		$this->assertGreaterThan(0, count($keywords));
	}

		

}


?>