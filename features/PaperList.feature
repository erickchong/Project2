Feature: Paper list
	To use the app
	As a user
	I must be able to get a functional list of papers for a given word from the cloud

Scenario: Each paper should have links to download its pdf and bibtex
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then each paper in the list should have a pdf link
	And each paper in the list should have a bibtex link

Scenario: Clicking on a paper's title should download a PDF of the paper and load the abstract
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then clicking the title of each paper in the list should download a PDF and load the abstract

Scenario: From the paper list, the user should be able to select a subset for a new word cloud
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then the user should be able to select a subset of the papers
	And a new word cloud should be generated

Scenario: From the paper list, clicking an author should generate a new cloud for that author
	Given the name "Jacob Rosenberg" is entered into the search bar
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	And the name "Chris Jensen" is clicked from the author list
	Then the word cloud title should match