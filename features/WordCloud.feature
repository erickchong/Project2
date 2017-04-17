Feature: Word cloud
	In order for the app to work properly, 
	we need a word cloud with certain behavior

@containwords
Scenario: The word cloud should contain words from the author's paper
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 10 papers
	And the search button is clicked
	Then the word cloud should contain the words "programming expert systems object oriented reliability data analysis"

@paperlist
Scenario: Clicking on a word in the word cloud should return a list of papers that mention that word
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 100 papers
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then a list of papers containing the word "Programming" should be loaded

@image
Scenario: The user should be able to download an image of the word cloud
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 10 papers
	And the search button is clicked
	Then the user should be able to download an image of the word cloud
	