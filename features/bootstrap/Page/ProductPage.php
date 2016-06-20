<?php

namespace Page;

use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use Exception;


class ProductPage extends BasePage {

  protected $elements = [
    'thumbnails' => '.product-img-box .thumbnails',
    'add_to_basket' => '#add-to-cart',
    'colour' => ['xpath' => '//div[label and label[normalize-space(text())=\'Colour\']]/div[contains(concat(\' \', normalize-space(@class), \' \'), \' chosen-container \')]'],
    'qty' => ['xpath' => '//div[label and label[normalize-space(text())=\'Quantity\']]/div[contains(concat(\' \', normalize-space(@class), \' \'), \' chosen-container \')]'],
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
    $this->waitAjax();
    return $this;
  }

  /**
   * Click to open a select list
   * 
   * @param $option
   * @return $this
   * @throws Exception
   */
  public function openSelectOption($option) {
    $this->getElement($option)->click();
    $this->waitAjax();
    return $this;
  }

  /**
   * Scroll select list to find target option
   * and click on the option
   * 
   * @param $name
   * @throws Exception
   */
  public function setOption($name) {
    $this->scrollIntoView(".chosen-results", ".active-result:contains('$name')");
    $option = $this->find("css", ".active-result:contains('$name')");
    if ($option instanceof NodeElement) {
      $option->click();
      return $this->waitAjax();
    }
    throw new Exception(sprintf('Can\'t find "%s" option to select on the page ', $name, $this->getCurrentUrl()));
  }

}
