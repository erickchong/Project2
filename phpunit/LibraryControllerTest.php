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

		$this->assertEquals($limit, count($acmPapers));

		foreach ($acmPapers as $paper)
		{
			$this->assertContains("Saito", $paper["authors"]);
		}
	}

	public function testGetIEEEPapersWithAuthor()
	{
		$authorName = "saito";
		$limit = 10;
		$ieeePapers = array();
		$ieeePapers = $this->libraryController->getIEEEPapersWithAuthor($authorName, $limit);

		$this->assertEquals($limit, count($ieeePapers));

		foreach ($ieeePapers as $paper)
		{
			$this->assertContains("Saito", $paper["authors"]);
		}
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