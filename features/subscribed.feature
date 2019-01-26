Feature: Subscriber users
  We have small application to list subscribed users.
  An user is identified by his email address.

  Scenario: Subscribe a first user
    Given a subscribed user with email "example@test.com"
    And a subscribed user with email "other@test.com"
    When I want see the subscriptions
    Then the email "example@test.com" appear
    And the email "other@test.com" appear