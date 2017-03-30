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

		$this->session->visit('http://localhost:80/PaperCloud/');
		$this->page = $this->session->getPage();

		$this->paperSearchBar = $this->page->find("css", "#paperSearchBar");
		$this->paperSearchTextField = $this->paperSearchBar->find("css", "#paperSearchTextField");

        $this->searchButton = $this->page->find("css", "#search");
	}

	public function __destruct()
	{
		$this->session->stop();
	}

	/**
	* @Given there is an paper search bar
	*/
	public function thereIsAnpaperSearchBar()
	{
		assertNotEquals(null, $this->paperSearchBar);
		// $this->paperSearchBar = $this->page->find("css", "#paperSearchBar");
	}

	/**
	* @Then the paper search bar should be empty
	*/
	public function thepaperSearchBarShouldBeEmpty()
	{

		assertEquals("", $this->paperSearchTextField->getValue());
	}

	/**
    * @Given there are more than three characters in the textbox
    */
    public function thereAreMoreThanThreeCharactersInTheTextbox()
    {
    	$this->paperSearchTextField->setValue('The Bea');
        sleep(3);
    }

    public $suggestions;

    /**
     * @Then the suggestions drop-down should be visible below the textbox
     */
    public function theSuggestionsDropDownShouldBeVisibleBelowTheTextbox()
    {
        $this->suggestions = $this->page->find("css", "#ui-id-1");
        assertNotEquals(null, $this->suggestions);
        assertTrue($this->suggestions->isVisible());
    }

    /**
     * @Then there should be at least three papers in the drop-down
     */
    public function thereShouldBeAtLeastThreepapersInTheDropDown()
    {
        $this->suggestions->findall('css', 'li');

        $i = 0;
        foreach ($this->suggestions as $suggestion) {
            ++$i;
        }

        assertGreaterThan($i, 2);
    }

    /**
     * @Given an paper is chosen from the drop-down
     */
    public function anpaperIsChosenFromTheDropDown()
    {
        $this->paperSearchTextField->setValue('The Bea');
        sleep(3);

        $this->suggestions = $this->page->find("css", "#ui-id-1");
        
        $firstsuggestion = $this->suggestions->find('css', 'li');

        $firstsuggestion->click();
    }

    /**
     * @Then the textbox should be updated to contain the name of the paper
     */
    public function theTextboxShouldBeUpdatedToContainTheNameOfThepaper()
    {
        sleep(0.5);

        assertEquals("The Beach Boys", $this->paperSearchTextField->getValue());
    }

    /**
     * @Given the paper Search Bar has three or fewer characters
     */
    public function thepaperSearchBarHasThreeOrFewerCharacters()
    {
        $this->paperSearchTextField->setValue('the');
    }

    /**
     * @Then the search button is not clickable
     */
    public function theSearchButtonIsNotClickable()
    {
        assertEquals('disabled', $this->searchButton->getAttribute('disabled'));
    }

    /**
     * @Given the paper Search Bar has more than three characters
     */
    public function thepaperSearchBarHasMoreThanThreeCharacters()
    {
        $this->paperSearchTextField->setValue('the ');
        sleep(3);
    }

    /**
     * @Then the search button is clickable
     */
    public function theSearchButtonIsClickable()
    {
        assertEquals(null, $this->searchButton->getAttribute('disabled'));
    }

    /**
     * @Given the search button is clicked
     */
    public function theSearchButtonIsClicked()
    {
        $this->paperSearchTextField->setValue('The Beach Boys');

        sleep(1.5);

        $this->suggestions = $this->page->find("css", "#ui-id-1");
        $firstsuggestion = $this->suggestions->find('css', 'li');
        $firstsuggestion->click();

        $this->searchButton->click();

        sleep(2);
    }

    /**
     * @Then we should be navigated to the Word Cloud Page for the paper
     */
    public function weShouldBeNavigatedToTheWordCloudPageForThepaper()
    {
        assertNotEquals(null, $this->page->find("css", "#wordCloudPage"));
    }
}