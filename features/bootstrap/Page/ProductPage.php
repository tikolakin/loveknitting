<?php

namespace Page;

use Behat\Mink\Session;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use Exception;


class ProductPage extends BasePage {

  protected $elements = [
    'thumbnails' => '.product-img-box .thumbnails',
    'add_to_basket' => '#add-to-cart',
  ];

  /**
   * Find product's shades thumbnails
   * 
   * @return \Behat\Mink\Element\NodeElement[]
   */
  public function getProductThumbnailsShades() {
    return $this->getElement('thumbnails')->findAll('css', '.child .click-thumb');
  }

  /**
   * Click the link to add a product to basket
   * 
   * @return $this
   * @throws Exception
   */
  public function clickAddToBasket() {
    $this->getElement('add_to_basket')->click();
    $this->waitAjax(5);
    return $this;
  }

}
