<?php

/*
 * This file is part of the sfCcTesting package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class WebTestCase
 *
 * @package     sfCcTesting
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 */

namespace odino\SfCcTesting;

abstract class WebTestCase extends \PHPUnit_Framework_TestCase
{
  protected function createClient()
  {
    $this->bootstrapSymfony($this->getApplication());

    return new Browser();
  }
  
  /**
   * Includes the symfony 1.X bootstrap file for functional tests.
   * 
   * @param   string  The application to bootstrap
   * @return  void
   */
  abstract protected function bootstrapSymfony($app);
  
  /**
   * Returns the application to test.
   * 
   * @return string The application name (frontend, backend, ...)
   */
  abstract protected function getApplication();
}

