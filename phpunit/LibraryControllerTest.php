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

	public function testGetACMPapersWithAuthor()
	{
		$authorName = "Saito";
		$limit = 5;
		$acmPapers = array();
		$acmPapers = $this->libraryController->getACMPapersWithAuthor($authorName, $limit);

		$this->assertGreaterThan(0, count($acmPapers));
		$this->assertLessThanOrEqual($limit, count($acmPapers));

		foreach ($acmPapers as $paper)
		{
			$authors = $paper["authors"];
			$foundAuthor = false;

			foreach($authors as $author)
			{
				if (strpos($author, "Saito") !== false)
				{
					$foundAuthor = true;
					break;
				}
			}
			$this->assertEquals(true, $foundAuthor);
		}
	}

	public function testGetACMPapersWithWord()
	{
		$word = "analysis";
		$limit = 5;
		$acmPapers = array();
		$acmPapers = $this->libraryController->getACMPapersWithWord($word, $limit);

		$this->assertGreaterThan(0, count($acmPapers));
		$this->assertLessThanOrEqual($limit, count($acmPapers));

		foreach ($acmPapers as $paper)
		{
			$authors = $paper["authors"];
			$this->assertGreaterThan(0, count($authors));
			$this->assertEquals("acm", $paper["source"]);
		}

	}

	public function testGetIEEEPapersWithAuthor()
	{
		$authorName = "Saito";
		$limit = 5;
		$ieeePapers = array();
		$ieeePapers = $this->libraryController->getIEEEPapersWithAuthor($authorName, $limit);

		$this->assertGreaterThan(0, count($ieeePapers));
		$this->assertLessThanOrEqual($limit, count($ieeePapers));
		
		foreach ($ieeePapers as $paper)
		{
			$authors = $paper["authors"];
			$foundAuthor = false;

			foreach($authors as $author)
			{
				if (strpos($author, "Saito") !== false)
				{
					$foundAuthor = true;
					break;
				}
			}
			$this->assertEquals(true, $foundAuthor);
		}


		
	}

	public function testGetIEEEPapersWithWord()
	{
		$word = "analysis";
		$limit = 5;
		$ieeePapers = array();
		$ieeePapers = $this->libraryController->getIEEEPapersWithWord($word, $limit);

		$this->assertGreaterThan(0, count($ieeePapers));
		$this->assertLessThanOrEqual($limit, count($ieeePapers));

		foreach ($ieeePapers as $paper)
		{
			$authors = $paper["authors"];
			$this->assertGreaterThan(0, count($authors));
			//$this->assertEquals("acm", $paper["source"]);
		}
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

	public function testGetPapersForConference()
	{
		$conference = "2012 Conference on Lasers and Electro-Optics (CLEO)";
		$limit = 5;
		$ieeePapers = $this->libraryController->getPapersForConference($conference, "ieee", $limit);
		$acmPapers = $this->libraryController->getPapersForConference($conference, "acm", $limit);

		$this->assertLessThanOrEqual($limit, count($ieeePapers));
		$this->assertEquals(0, count($acmPapers));
	}

}


?>