<?php

namespace HsBremen\WebApi\Tests;

use HsBremen\WebApi\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase {
  /**
   * @test
   */
  public function classExists() {
    self::assertInstanceOf(Application::class, new Application());
  }
}
