Feature: Upload suite results
    As a benchmarker
    I want my results to be imported
    In order that I can archive them

    Background:
        Given the user "daniel" exists
        And user "daniel" has project "daniel" "leech" with API key "1234"

    Scenario: Upload suite result with valid API key
        When I post the suite "worse_reflection.xml" with API key "1234"
        Then the HTTP status should be 200
        And I receive confirmation with the URL "http://localhost/p/leech/daniel/worse-uuid"

    Scenario: Upload suite result with an invalid API key
        When I post the suite "worse_reflection.xml" with API key "4321"
        Then the HTTP status should be 401
