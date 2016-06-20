<?php


use Behat\Behat\Context\SnippetAcceptingContext;
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
   * @Given /^I take a product shade from available in stock$/
   */
  public function iTakeAProductShadeFromAvailableInStock()
  {
    $shades = $this->productPage->getProductThumbnailsShades();
    foreach ($shades as $shade) {
      if (!$shade->find('css', '.out-stock')) {
        $shade->click();
        return $this->productPage->waitAjax();
      }
    }
    throw new Exception("Can't find a product shade in stock.");
  }

  /**
   * @When /^I add the product to basket$/
   */
  public function iAddTheProductToBasket()
  {
    $this->productPage->clickAddToBasket();
    $msg = 'Added to your basket';
    Assert::assertContains($msg, $this->productPage->getElement('Popup')->getSuccessMsgText(),
      sprintf('A success message with text "%s" is not presented on the page: %s', $msg, $this->productPage->getCurrentUrl()));
  }

  /**
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
   * @Then /^"([^"]*)" should be in my basket$/
   */
  public function productShouldBeInMyBasket($productName) {
    Assert::assertNotNull($this->checkoutPage->getElement('Table')->getRowColumnText('Product Name', $productName),
      sprintf('The "%s" is not found in checkout table on the page: %s', $productName, $this->checkoutPage->getCurrentUrl()));
  }
}
