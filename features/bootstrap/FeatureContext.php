<?php


use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;
use Page\CheckoutPage;
use Page\ProductPage;
use PHPUnit_Framework_Assert as Assert;


class FeatureContext extends MinkContext implements SnippetAcceptingContext{

  private $productPage;

  private $checkoutPage;

  public function __construct(ProductPage $productPage, CheckoutPage $checkoutPage)
  {
    $this->productPage = $productPage;
    $this->checkoutPage = $checkoutPage;
  }

  /**
   * Click a product's thumbnail image without "Out of stock" label
   * then add the product to basket
   * 
   * @Given /^I take a (?:product|yarn) shade from available in stock to basket$/i
   */
  public function iTakeAProductShadeFromAvailableInStock()
  {
    $shades = $this->productPage->getProductThumbnailsShades();
    foreach ($shades as $shade) {
      if (!$shade->find('css', '.out-stock')) {
        $shade->click();
        $this->productPage->waitAjax();
        $this->iAddTheProductToBasket();
        return;
      }
    }
    throw new Exception("Can't find a product shade in stock.");
  }

  /**
   * Select product's color in select-list
   * select product's qty in select-list
   * and add the product to basket
   * 
   * @Given /^I take (\d+) (?:products|yarns) in "([^"]*)" colour to basket$/i
   */
  public function iTakeYarnsInColorToBasket($number, $colorName) {
    $this->productPage->openSelectOption('colour')->setOption($colorName);
    $this->productPage->openSelectOption('qty')->setOption($number);
    $this->iAddTheProductToBasket();
  }

  /**
   * Click "Add to basket button"
   * and assert success message
   * 
   * @When /^I add the (?:product|yarn) to basket$/i
   */
  public function iAddTheProductToBasket()
  {
    $this->productPage->clickAddToBasket();
    $msg = 'Added to your basket';
    Assert::assertContains($msg, $this->productPage->getElement('Popup')->getSuccessMsgText(),
      sprintf('Can\'t add a product to the basket. Success message with text "%s" is not presented on the page: %s', $msg, $this->productPage->getCurrentUrl()));
  }

  /**
   * Click "Go to Checkout" button
   * and verify that page is opened
   * 
   * @Given /^I follow to checkout$/
   */
  public function iFollowToCheckout() {
    if(!is_null($this->productPage->getElement('Popup')->clickCheckoutLink()))  {
      $this->productPage->getPage('CheckoutPage')->verifyPage();
      return;
    }
    throw new Exception(sprintf("Link to checkout is not presented on the page: %s", $this->productPage->getCurrentUrl()));
  }

  /**
   * Assert given product name is presented in basket table's column
   * 
   * @Then /^"([^"]*)" should be in my basket$/
   */
  public function productShouldBeInMyBasket($productName) {
    Assert::assertNotNull($this->checkoutPage->getElement('Table')->getRowColumnText('Product Name', $productName),
      sprintf('The "%s" is not found in checkout table on the page: %s', $productName, $this->checkoutPage->getCurrentUrl()));
  }

  /**
   * Assert given number matches input value in table cell
   * 
   * @Then /^(\d+) "([^"]*)" should be in my basket$/
   */
  public function shouldBeInMyBasket($number, $productName) {
    Assert::assertEquals($number, $this->checkoutPage->getElement('Table')->getRowColumnValue('Quantity', $productName),
      sprintf('The "%s %s" is not found in checkout table on the page: %s', $number, $productName, $this->checkoutPage->getCurrentUrl()));
  }
}
