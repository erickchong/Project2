Feature: Main page
	In order to use the app
	As a user
	I need a main page

	Scenario: The main page is loaded
		Given the main page is loaded
		Then the title of the page should be "NerdEngine"
		And there should be a search button