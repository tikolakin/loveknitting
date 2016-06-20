Feature: Basket
  In order to buy a product on the site
  User needs to add the product to the basked
  So they will be able to make an order for chosen products

  @javascript
  Scenario: Added product with options is shown on the basket page
    Given I am on "us/millamia-naturally-soft-merino/"
    When I take a yarn shade from available in stock to basket
    And I follow to checkout
    Then "MillaMia Naturally Soft Merino Yarn" should be in my basket

  @javascript
  Scenario: User can add to basket some quantity of a specific product color
    Given I am on "us/millamia-naturally-soft-merino/"
    Given I take 10 yarns in "Midnight" colour to basket
    And I follow to checkout
    Then 10 "MillaMia Naturally Soft Merino Yarn - Midnight" should be in my basket
