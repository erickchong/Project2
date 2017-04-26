Feature: Paper list
	To use the app
	As a user
	I must be able to get a functional list of papers for a given word from the cloud

@pdfandbibtex
Scenario: Each paper should have links to download its pdf and bibtex
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 10 papers
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then each paper in the list should have a pdf link
	And each paper in the list should have a bibtex link

@subset
Scenario: From the paper list, the user should be able to select a subset for a new word cloud
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 10 papers
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	Then the user should be able to select a subset of the papers
	And a new word cloud should be generated

@regenerate
Scenario: From the paper list, clicking an author should generate a new cloud for that author
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 10 papers
	And the search button is clicked
	And the word "Programming" is clicked in the cloud
	And the name "Chris Jensen" is clicked from the author list
	Then we should have a matching word cloud


@conference
Scenario: Clicking on a conference name should display other papers from the conference
	Given the name "Jacob Rosenberg" is entered into the search bar
	And we are searching 10 papers
	And the search button is clicked
	And the word "Programming" is clicked in the cloud 
	And the conference "Proceedings of the 21st ACM SIGPLAN International Conference on Functional Programming" is clicked
	Then a list of papers from "Proceedings of the 21st ACM SIGPLAN International Conference on Functional Programming" should be loaded