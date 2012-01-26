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
 * Class Browser
 *
 * @package     sfCcTesting
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 */

namespace odino\SfCcTesting;

use Symfony\Component\DomCrawler\Crawler;

class Browser extends \sfBrowser
{
  public function call($uri, $method = 'get', $parameters = array(), $changeStack = true)
  {
    $browser = parent::call($uri, $method, $parameters, $changeStack);
    $crawler = new Crawler();
    $crawler->add($browser->getResponse()->getContent());
    
    return $crawler;
  }
}

