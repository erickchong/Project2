Feature: Word Cloud Title
	We need a title for our word cloud.

	Scenario: The search terms and the word cloud title should match.
		Given the name "Rosenberg" is entered into the search bar
		And the search button is clicked
		Then the word cloud title should match
		