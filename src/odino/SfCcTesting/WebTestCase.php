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

use Symfony\Component\DomCrawler\Crawler;

abstract class WebTestCase extends \PHPUnit_Framework_TestCase
{
    protected $client;

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

    protected function getClient()
    {
        return $this->client;
    }
  
    protected function getClientResponse()
    {
        $client = $this->getClient();

        return $client ? $client->getResponse()->getContent() : null;
    }
    
    protected function getResponse()
    {
      return $this->getClient() ? $this->getClient()->getResponse() : null;
    }
    
    protected function assertElementExists(Crawler $crawler, $selector)
    {
        if ($crawler->filter($selector)->count()) {
            return true;
        }
        else {
            $this->fail($this->getClientResponse() . sprintf("\nUnable to find %s in the current DOM", $selector));
        }
    }
    
    protected function assertStatusCode($code)
    {
        if ($response = $this->getResponse()) {
          $this->assertEquals($code, $response->getStatusCode(), sprintf("Status code %d was expected", $code));
          
          return true;
        }
      
        $this->fail("No response");
    }
}

