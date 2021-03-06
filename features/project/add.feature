Feature: Add project
    As a benchmarker
    In order to view my benchmarks online
    I need to be able to add projects to my account

    Background:
        Given the user "daniel" exists
        And I am logged in as user "daniel"

    Scenario: Add project
        Given I am on "/profile"
        And I follow "Add project"
        When I fill in "project_add_form[name]" with "new-project"
        And I press "Add project"
        Then I should be on "/profile/project/details/daniel/new-project"

    Scenario: Trying to add existing project
        Given user "daniel" has project "daniel" "phpbench-reports"
        Given I am on "/profile/project/add"
        When I fill in "project_add_form[name]" with "phpbench-reports"
        And I press "Add project"
        Then I should see a form error message "Project already exists"

    Scenario: Try to add project without ADD_PROJECT permission
        Given I only have roles "ROLE_USER"
        And I am logged in as user "daniel"
        And I am on "/profile"
        Then I should see "You do not have permission to add projects"
