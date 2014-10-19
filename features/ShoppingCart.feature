Feature: Shopping cart
  In order to make order
  User should be able
  add elements to basket

  Scenario: Shopping Cart Should be visible
    Given I am on "/"
    Then I should see "My shopping cart" in the "div#shopping-cart" element

  Scenario: Should be visible product list header
    Given I am on "/"
    Then I should see "Available products" in the "div#product-form" element

  Scenario: Should be visible product #1 to buy
    Given I am on "/"
    Then I should see "Product name #1" in the "div#product-form" element

  Scenario: Should be visible product #2 to buy
    Given I am on "/"
    Then I should see "Product name #2" in the "div#product-form" element

  Scenario: Should be visible product #3 to buy
    Given I am on "/"
    Then I should see "Product name #3" in the "div#product-form" element

  Scenario: Should be able add product to shopping cart
    Given I am on "/"
    When I select "2" from "Product name #2"
    And I press "Submit"
    Then I should see "Product name #2" in the "div#shopping-cart" element

  Scenario: Should not be able to send empty form
    Given I am on "/"
    And I press "Submit"
    Then I should see "This value should not be blank."
