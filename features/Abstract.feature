Feature: Abstract
	In order to use the app
	As a user
	I should be able to access the abstract of the paper

	Scenario: A paper's abstract should be viewable by clicking the paper name
		Given I go to "http://localhost/Project2/getPapersForWord.php?author=Rosenberg&word=optical&limit=20"
		And I wait for 10 seconds
		And I click on the first paper's name
		Then I should be navigated to the abstract for the paper

	Scenario: A paper's abstract should have the word I selected highlighted
		Given I go to "http://localhost/Project2/getPapersForWord.php?author=Rosenberg&word=optical&limit=20"
		And I wait for 10 seconds
		And I click on the first paper's name
		Then the word "optical" should be highlighted
