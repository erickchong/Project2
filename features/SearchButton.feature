Feature: Search Button
	In order to browse paper word clouds
	As a user
	I need to be able to trigger the search from the search bar

	@namesearch
	Scenario: The search button is clicked with a name in the search bar
		Given the name "Rosenberg" is entered into the search bar
		And we are searching 20 papers
		And the search button is clicked
		Then a word cloud should be generated within 6 seconds

	@keywordsearch
	Scenario: The search button is clicked with a keyword in the search bar
		Given the keyword "computation" is entered into the search bar
		And we are searching 20 papers
		And the search button is clicked
		Then a word cloud should be generated within 6 seconds

	@statusbar
	Scenario: When the search button is clicked, a status bar should appear indicating generation progress
		Given the name "Rosenberg" is entered into the search bar
		And we are searching 20 papers
		And the search button is clicked
		Then a status bar should appear

	@authordne
	Scenario: An author searched for does not exist
		Given the name "AAAA" is entered into the search bar
		And we are searching 100 papers
		And the search button is clicked
		Then the word cloud title should match
		And text saying "author not found !" should appear on the screen