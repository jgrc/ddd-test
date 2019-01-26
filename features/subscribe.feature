Feature: Subscriber users
  We have small application to subscribe users.
  An user is identified by his email address.

  Scenario: Subscribe a first user
    When I subscribe a user with email "example@test.com"
    Then the user should be subscribed

  Scenario: Subscribe more users
    Given a subscribed user with email "example@test.com"
    When I subscribe a user with email "other@test.com"
    Then the user should be subscribed

  Scenario: Subscribe fails with a previously subscribed user
    Given a subscribed user with email "example@test.com"
    When I subscribe a user with email "example@test.com"
    Then the subscription fails

  Scenario: Subscribe fails with a user email with bad format
    When I subscribe a user with email "bad-format-email"
    Then the subscription fails