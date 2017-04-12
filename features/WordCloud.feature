Feature: Word cloud
	In order for the app to work properly, 
	we need a word cloud with certain behavior

Scenario: The word cloud should contain words from the author's paper
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	Then the word cloud should contain the words "blockly media computation programming expert systems object oriented reliability data analysis processing"

Scenario: Clicking on a word in the word cloud should return a list of papers that mention that word
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then a list of papers containing the word "Programming" should be loaded

Scenario: The user should be able to download an image of the word cloud
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	Then the user should be able to download an image of the word cloud

Scenario: Clicking on a conference name should display other papers from the conference
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	And the conference "Proceedings of the IEEE" is clicked
	Then a list of papers from "Proceedings of the IEEE" should be loaded