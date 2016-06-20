<?php

namespace Page\Element;

use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class Table extends Element {

  protected $selector = 'table';

  /**
   * Find a table cell by the heading and cell text
   * return cell text or null otherwise
   * 
   * @param $column_text
   * @param $row_text
   * @return null|string
   */
  public function getRowColumnText($column_text, $row_text) {
    if($td = $this->find('xpath', "//tbody/tr[contains(., '$row_text')]/td[count(//table/thead/tr/th[normalize-space(text())='$column_text']/preceding-sibling::th)+1]")) {
      return $td->getText();
    }
    return NULL;
  }
  
  public function getRowColumnValue($column_text, $row_text) {
    if($td = $this->find('xpath', "//tbody/tr[contains(., '$row_text')]/td[count(//table/thead/tr/th[normalize-space(text())='$column_text']/preceding-sibling::th)+1]")) {
      $input = $td->find('css', 'input');
      if ($input instanceof NodeElement) {
        return $input->getValue();
      }
    }
    return NULL;
  }

}
