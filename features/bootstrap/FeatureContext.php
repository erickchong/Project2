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
    public $shareButton;

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
        $this->shareButton = $this->page->findById("shareToFacebookButton");
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
     * @Then there should be a share button
     */
    public function thereShouldBeAShareButton()
    {
        assertNotEquals(null, $this->shareButton);
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
     * @Given the surname :arg1 is entered into the search bar
     */
    public function theSurnameIsEnteredIntoTheSearchBar($arg1)
    {
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

    /**
     * @Given the search term was :arg1
     */
    public function theSearchTermWas($arg1)
    {
        $this->searchTerm = $arg1;
        $this->paperSearchBar->setValue($arg1);
        $this->searchButton->click();
    }

    /**
     * @Then the word cloud title should match
     */
    public function theWordCloudTitleShouldMatch()
    {
        $artistitle = null;
        while ($artistitle == null) {
            sleep(1);
            $artistitle = $this->page->findById("artist_title");
        }

        assertEquals(strtolower($this->searchTerm), strtolower($artistitle->getText()));
    }


}