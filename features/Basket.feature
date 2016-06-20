Feature: Basket
  In order to buy a product on the site
  User needs to add the product to the basked
  So they will be able to make a order for chosen products

  @javascript
  Scenario: Added product with options is shown on the basket page
    Given I am on "us/millamia-naturally-soft-merino/"
    Given I take a product shade from available in stock
    When I add the product to basket
    And I follow to checkout
    Then "MillaMia Naturally Soft Merino Yarn" should be in my basket
