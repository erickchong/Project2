Feature: Paper Search Bar
	In order to browse paper word clouds
	As a user
	I need to be able to search for artists in an paper search bar

	Scenario: Observing an empty paper search bar
		Given there is an paper search bar
		Then the paper search bar should be empty

	Scenario: There are more than three characters in the textbox
		Given there are more than three characters in the textbox
		Then the suggestions drop-down should be visible below the textbox
		And there should be at least three artists in the drop-down

	Scenario: An paper is chosen from the drop-down
		Given an paper is chosen from the drop-down
		Then the textbox should be updated to contain the name of the paper
