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
		$authorName = "saito";
		$limit = 10;
		$acmPapers = array();
		$acmPapers = $this->libraryController->getACMPapersWithAuthor($authorName, $limit);

		$this->assertGreaterThan(0, count($acmPapers));
		$this->assertLessThanOrEqual($limit, count($acmPapers));

		foreach ($acmPapers as $paper)
		{
			$author = $paper["authors"];
			if (empty($author) == false)
			{
				$this->assertContains("Saito", (string)$author);
			}
		}
	}

	public function testGetIEEEPapersWithAuthor()
	{
		$authorName = "Saito";
		$limit = 10;
		$ieeePapers = array();
		$ieeePapers = $this->libraryController->getIEEEPapersWithAuthor($authorName, $limit);

		$numPapers = 0;
		
		foreach ($ieeePapers as $paper)
		{
			$author = $paper["authors"];
			if (empty($author) == false)
			{
				$this->assertContains("Saito", (string)$author);
				$numPapers++;
			}
		}

		$this->assertGreaterThan(0, $numPapers);
		$this->assertLessThanOrEqual($limit, $numPapers);
		
	}

	public function testCombineKeywords()
	{
		$authorName = "saito";
		$limit = 10;
		$keywords = "";
		$keywords = $this->libraryController->combineKeywords($authorName, $limit);

		$this->assertGreaterThan(0, count($keywords));
	}
}


?>