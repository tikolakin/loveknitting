<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use Exception;


class CheckoutPage extends BasePage {

  protected $path = '/checkout/cart/';

  protected $elements = [
    'shopping_cart' => '#shopping-cart-table',
  ];

  /**
   * Verify page by it's title
   * 
   * @throws Exception
   */
  public function verifyPage() {
    $title = 'Your Knitting Basket';
    $actual = $this->find('css', 'h1')->getText();
    if (preg_match('/' . $title . '/', $actual) === 0) {
      throw new Exception(sprintf('The page title is not "%s". Current title is "%s"', $title, $actual));
    } 
  }

}
