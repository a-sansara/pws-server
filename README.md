
# MetaTech PwsServer

PwsServer is a web application skeleton in silex2 managing web services through PwsAuth protocol


### Requirements

PHP 7.0
meta-tech\silex 2
meta-tech\silex-core
meta-tech\pws-client (to test ws)


### Install

The package can be installed using [ Composer ](https://getcomposer.org/). (not yet)
```
composer require meta-tech/pws-server
```

Or add the package to your `composer.json`.

```
"require": {
    "meta-tech/pws-server" : "1.0"
}
```

## Usage

managing controllers & routing in application  
cf [ MetaTech\Silex\Provider\ControllerServiceProvider ](https://github.com/meta-tech/silex-controller-service)

```php
namespace MetaTech\PwsServer;

use MetaTech\Silex\Application as App;
use MetaTech\Silex\Provider\ControllerServiceProvider as CtrlProvider;
use MetaTech\PwsAuth\Authenticator;
use MetaTech\PwsServer\Ctrl\Test;
use MetaTech\PwsServer\Ctrl\WebService;
use MetaTech\PwsServer\Ctrl\OtherWebService;

class Application extends App
{
    /*!
     * @method      setServices
     * @protected
     */
    protected function setServices()
    {
        $app = $this;
        $app['ws.authenticator'] = function ($app) {
            return new Authenticator($app['config']['pwsauth']);
        };
    }

    /*!
     * @method      routingDefinition
     * @protected
     */
    protected function routingDefinition()
    {
        $this->register(new CtrlProvider(Test::class           , [$this], '/'));
        $this->register(new CtrlProvider(WebService::class     , [$this], '/ws'));
        $this->register(new CtrlProvider(OtherWebService::class, [$this], '/ws/deep'));
    }
}
```

Controller example :

```php
<?php

use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use MetaTech\Silex\Ws\Controller;

class WebService extends Controller
{
    public function index(Request $request)
    {
        $done = true;
        $msg  = 'this is index';
        return $this->response($done, $msg);
    }

    public function routing(ControllerCollection $collection) : ControllerCollection
    {
        $collection = parent::routing($collection);
        $_          = $this->ns();

        $collection->match('/', "$_:index");

        return $collection;
    }
}
```

Authentication mecanism is already provided by the `MetaTech\Silex\Ws\Controller`  parent class
& the `MetaTech\Silex\Ws\Authentication` handler (in meta-tech/silex-core package)

See OtherWebService to see another controller and deep routes inside rooting /ws entry point


### Test uris :

access through web browser :  

* servername/
* servername/test

access through pws-client :  

* servername/ws
* servername/ws/deep
* servername/ws/isauth


### @todo

subclassing `MetaTech\Silex\Ws\Authentication` to give checkUser db implementation example


### License

The project is released under the MIT license, see the LICENSE file.
