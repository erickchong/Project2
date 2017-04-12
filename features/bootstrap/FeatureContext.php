<?php

require_once "vendor/autoload.php";
require_once "vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
	public $driver;
	public $session;
	
	public $page;

	public $paperSearchBar;
	public $paperSearchTextField;
    public $searchButton;

    public $searchTerm;

	/**
	* Initializes context.
	*
	* Every scenario gets its own context instance.
	* You can also pass arbitrary arguments to the
	* context constructor through behat.yml.
	*/
	public function __construct()
	{
		$this->driver = new \Behat\Mink\Driver\Selenium2Driver();
		$this->session = new \Behat\Mink\Session($this->driver);

		$this->session->start();

		$this->session->visit('http://localhost:80/Project2/');
		$this->page = $this->session->getPage();

		$this->paperSearchBar = $this->page->findById("inputBox");

        $this->searchButton = $this->page->findById("submitButton");
	}

	public function __destruct()
	{
		$this->session->stop();
	}

    /**
     * @Given the main page is loaded
     */
    public function theMainPageIsLoaded()
    {
        assertNotEquals(null, $this->page);
    }

    /**
     * @Then the title of the page should be :arg1
     */
    public function theTitleOfThePageShouldBe($arg1)
    {
        $title = $this->page->findById("header");
        assertNotEquals(null, $title);
        assertEquals($arg1, $title->getText());
    }

    /**
     * @Then there should be a search button
     */
    public function thereShouldBeASearchButton()
    {
        assertNotEquals(null, $this->searchButton);
    }

	/**
	* @Given there is a paper search bar
	*/
	public function thereIsAPaperSearchBar()
	{
		assertNotEquals(null, $this->paperSearchBar);
	}

	/**
	* @Then the paper search bar should be empty
	*/
	public function thepaperSearchBarShouldBeEmpty()
	{

		assertEquals("", $this->paperSearchBar->getValue());
	}

    /**
     * @Given the name :arg1 is entered into the search bar
     */
    public function theNameIsEnteredIntoTheSearchBar($arg1)
    {
        $this->searchTerm = $arg1;
        $this->paperSearchBar->setValue($arg1);
    }

    /**
     * @Given the search button is clicked
     */
    public function theSearchButtonIsClicked()
    {
        $this->searchButton->click();
    }

    /**
     * @Then a word cloud should be generated within :arg1 seconds
     */
    public function aWordCloudShouldBeGeneratedWithinSeconds($arg1)
    {
        sleep($arg1);
        $wordcloud = $this->page->find("css", "#cloudBox");
        assertNotEquals(null, $wordcloud);
    }

    // /**
    //  * @Given the search term was :arg1
    //  */
    // public function theSearchTermWas($arg1)
    // {
    //     $this->searchTerm = $arg1;
    //     $this->paperSearchBar->setValue($arg1);
    //     $this->searchButton->click();
    // }

    /**
     * @Then the word cloud title should match
     */
    public function theWordCloudTitleShouldMatch()
    {
        sleep(10);
        $artistitle = $this->page->findById("author_title")->getText();
        assertEquals(strtolower($this->searchTerm), strtolower($artistitle));
    }

    /**
     * @Then text saying :arg1 should appear on the screen
     */
    public function textSayingShouldAppearOnTheScreen($arg1)
    {
        sleep(6);
        $text = $this->page->findById("cloudResult")->getText();
        assertEquals($text, $arg1);
    }



    /**
     * @Given the word :arg1 is clicked in the cloud
     */
    public function theWordIsClickedInTheCloud($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then each paper in the list should have a pdf link
     */
    public function eachPaperInTheListShouldHaveAPdfLink()
    {
        throw new PendingException();
    }

    /**
     * @Then each paper in the list should have a bibtex link
     */
    public function eachPaperInTheListShouldHaveABibtexLink()
    {
        throw new PendingException();
    }

    /**
     * @Then clicking the title of each paper in the list should download a PDF and load the abstract
     */
    public function clickingTheTitleOfEachPaperInTheListShouldDownloadAPdfAndLoadTheAbstract()
    {
        throw new PendingException();
    }

    /**
     * @Then the user should be able to select a subset of the papers
     */
    public function theUserShouldBeAbleToSelectASubsetOfThePapers()
    {
        throw new PendingException();
    }

    /**
     * @Then a new word cloud should be generated
     */
    public function aNewWordCloudShouldBeGenerated()
    {
        throw new PendingException();
    }

    /**
     * @Given the name :arg1 is clicked from the author list
     */
    public function theNameIsClickedFromTheAuthorList($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the word cloud should contain the words :arg1
     */
    public function theWordCloudShouldContainTheWords($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then a list of papers containing the word :arg1 should be loaded
     */
    public function aListOfPapersContainingTheWordShouldBeLoaded($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the user should be able to download an image of the word cloud
     */
    public function theUserShouldBeAbleToDownloadAnImageOfTheWordCloud()
    {
        throw new PendingException();
    }

    /**
     * @Given the conference :arg1 is clicked
     */
    public function theConferenceIsClicked($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then a list of papers from :arg1 should be loaded
     */
    public function aListOfPapersFromShouldBeLoaded($arg1)
    {
        throw new PendingException();
    }
}
