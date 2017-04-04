Feature: Word Cloud Title
	We need a title for our word cloud.

	Scenario: The search terms and the word cloud title should match.
		Given the search term was "Rosenberg"
		Then the word cloud title should match
		