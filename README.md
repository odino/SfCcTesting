# SfCcTesting: Symfony 1.X Client-Crawler Testing

A small library that brings the [Symfony2](http://symfony.com/doc/2.0/book/testing.html)
functional testing mechanism into [symfony 1.X](http://www.symfony-project.org).

## Installation 

Clone the repository under the `lib/vendor/odino` directory: you can change
the location of the library, although this one is the recommended one.

Move into the library's root, download composer and install the dependencies:

``` bash 
cd lib/vendor/odino/SfCcTesting
wget http://getcomposer.org/composer.phar
php composer.phar install
```

Make a symbolic link from the root of your application to the default
`phpunit.xml.dist` configuration file:

``` bash
ln -s lib/vendor/odino/SfCcTesting/phpunit.xml.dist phpunit.xml
```

(this is just a hint, you can use your specific configuration file)

Write your first test:

``` bash touch test/phpunit/HomepageTest.php
<?php

use Symfony\Component\DomCrawler\Crawler;
use odino\SfCcTesting\WebTestCase;

class HomepageTest extends WebTestCase
{  
  public function testHelloWorld()
  {    
    $client = $this->createClient();
    $crawler = $client->get('/');
    
    $this->assertEquals("Hello world", $crawler->filter('h1')->text());
  }
  
  protected function getApplication()
  {
    return 'frontend';
  }
  
  protected function bootstrapSymfony($app)
  {
    include(dirname(__FILE__).'/../../test/bootstrap/functional.php');
  }
}
```

and run it with a simple `phpunit test/phpunit` from the root of your
symfony 1.X project.

{% img center http://odino.github.com/images/phpunit.symfony.png %}
