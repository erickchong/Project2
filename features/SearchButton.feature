Feature: Search Button
	In order to browse paper word clouds
	As a user
	I need to be able to trigger the search from the search bar

	Scenario: The search button is clicked with a search term in the search bar
		Given the surname "Rosenberg" is entered into the search bar
		And the search button is clicked
		Then a word cloud should be generated within 6 seconds
