@filter @filter_mug
Feature: Mug filter appends configured text to supported activities
  In order to extend existing activity content
  As an admin
  I need the mug filter to inject configured text when a Page activity is viewed

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "activity" exists:
      | activity | page                  |
      | course   | C1                    |
      | name     | Test page             |
      | content  | Original page content |
    And the "mug" filter is "on"
    And the following config values are set as admin:
      | page_text    | <p>Injected by mug</p> | filter_mug |
      | page_enabled | 1                       | filter_mug |

  Scenario: Viewing a Page activity shows the admin-configured injected text
    Given I log in as "admin"
    When I am on the "Test page" "page activity" page
    Then I should see "Original page content"
    And I should see "Injected by mug"
