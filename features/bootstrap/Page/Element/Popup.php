<?php

namespace Page\Element;

use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class Popup extends Element{

  /**
   * Element selector.
   */
  protected $selector = '#j2t_ajax_confirm';

  /**
   * Verify success message is presented
   */
  public function isSuccessMsg() {
    $msg = $this->find('css', '.success-msg');
    if ($msg instanceof NodeElement) {
      if ($msg->isVisible()) {
        return true;
      }
    }
    return false;
  }

  /**
   * Return a text of a success message
   *
   * @return null|string
   */
  public function getSuccessMsgText() {
    $msg = $this->find('css', '.success-msg');
    if ($msg instanceof NodeElement) {
      return $msg->getText();
    }
    return null;
  }

  /**
   * Click a link to checkout and return success result
   * or null instead.
   * 
   * @return null|\SensioLabs\Behat\PageObjectExtension\PageObject\Page
   */
  public function clickCheckoutLink() {
    $link = $this->find('css', '#j2t-checkout-link');
    if ($link instanceof NodeElement) {
      if ($link->isVisible()) {
        $link->click();
        return $this->getPage('CheckoutPage');
      }
    }
    return null;
  }

}