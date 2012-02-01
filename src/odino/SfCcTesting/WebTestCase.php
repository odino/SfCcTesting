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
    
    public function setup()
    {
      $this->bootstrapSymfony($this->getApplication());
    }
    
    /**
     * Checks that the node identified with the $selector exists.
     * 
     * @param Crawler $crawler
     * @param string $selector
     * @return boolean 
     */
    protected function assertElementExists(Crawler $crawler, $selector)
    {
        if ($crawler->filter($selector)->count()) {
            return true;
        }
        else {
            $this->fail($this->getClientResponse() . sprintf("\nUnable to find %s in the current DOM", $selector));
        }
    }
    
    /**
     * Checks the status code of the response.
     * 
     * @param  int $code
     * @return boolean 
     */
    protected function assertStatusCode($code)
    {
        if ($response = $this->getResponse()) {
          $this->assertEquals($code, $response->getStatusCode(), sprintf("Status code %d was expected", $code));
          
          return true;
        }
      
        $this->fail("No response");
    }
    
    /**
     * Creats a new client.
     * 
     * @return \odino\SfCcTesting\Browser 
     */
    protected function createClient()
    {
      return new Browser();
    }
    
    /**
     * Mark the test failed and outputs the HTTP response's body.
     *
     * @param string $selector 
     */
    protected function debugResponse($selector = "body")
    {
        if ($this->getResponseBody()) {
          $crawler = new Crawler();
          $crawler->add($this->getResponseBody());
          $message = "Response debug:\n";
          $message .= $crawler->filter($selector)->text();
          
          $this->fail($message);
        }
        
        $this->fail("No response to debug");
    }

    /**
     * Returns the internal client.
     * 
     * @return \odino\SfCcTesting\Browser 
     */
    protected function getClient()
    {
        return $this->client;
    }
  
    /**
     * Returns the body of the last HTTP response the client received.
     * 
     * @return type 
     */
    protected function getResponseBody()
    {
        return $this->getResponse() ? $this->getResponse()->getContent() : null;
    }
    
    /**
     * Returns the last HTTP response the client received.
     * 
     * @return sfWebResponse
     */
    protected function getResponse()
    {
      return $this->getClient() ? $this->getClient()->getResponse() : null;
    }
}

