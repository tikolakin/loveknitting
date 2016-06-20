<?php
/**
 * @file
 * Helper context.
 */

use Behat\MinkExtension\Context\RawMinkContext;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Element\NodeElement;

/**
 * Helper context class.
 */
class HelpContext extends RawMinkContext implements SnippetAcceptingContext {

  private $parameters;

  /**
   * Constructor.
   */
  public function __construct($parameters) {
    $this->parameters = $parameters;
  }

  /**
   * Get scenario.
   *
   * @BeforeScenario
   */
  public function registerScenario(BeforeScenarioScope $scope) {
    $this->scenario = $scope->getScenario();
  }

  /**
   * Resize window and set page timeout before running scenarios.
   *
   * @BeforeScenario
   */
  public function tuneSeleniumBeforeScenario() {
    $driver = $this->getSession()->getDriver();
    if ($driver instanceof Behat\Mink\Driver\Selenium2Driver) {
      $driver->resizeWindow(1600, 1200);
    }
  }

  /**
   * Take screenshot of a page where step fails.
   *
   * @AfterStep
   */
  public function afterFailedStepsTakeScreenshot(AfterStepScope $scope) {
    if (\Behat\Testwork\Tester\Result\TestResult::FAILED === $scope->getTestResult()->getResultCode()) {
      $driver = $this->getSession()->getDriver();
      if ($driver instanceof Behat\Mink\Driver\Selenium2Driver) {
        $feature_name = strtolower(
          str_replace(
            array(' ', '"', '<', '>', '\''),
            array('-', '', '', '-'),
            $scope->getFeature()->getTitle())
        );
        $step_name = strtolower(
          str_replace(
            array(' ', '"', '<', '>', '\'', '/'),
            array('-', '', '', '-', '-'),
            $scope->getStep()->getText())
        );
        system('mkdir -p ' . escapeshellarg($this->parameters['screens']));
        $file_name = date_format(new DateTime(), "-Y-m-d-H-i-s") . $feature_name . '_' . $step_name . '.png';
        file_put_contents($this->parameters['screens'] . $file_name, $this->getSession()->getScreenshot());
        $message = '';
        if (getenv('BUILD_URL')) {
          $message .= getenv('BUILD_URL');
        }
        echo $message, 'artifact/behat_tests/build/html/assets/screenshots/', $file_name, PHP_EOL;
      }
      echo 'Failure at the ', $this->getSession()->getCurrentUrl(), ' .', PHP_EOL;
    }
  }
  

}
