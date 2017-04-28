Feature: Paper Search Bar
	In order to browse paper word clouds
	As a user
	I need to be able to search for artists in a paper search bar

	Scenario: Observing an empty paper search bar
		Given there is a paper search bar
		Then the paper search bar should be empty

	Scenario: Observing an empty paper number field
		Given there is a paper number field
		Then the paper number field should be empty