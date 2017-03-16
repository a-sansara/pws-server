
# MetaTech PwsServer

PwsServer is a web application skeleton in silex2 managing web services through PwsAuth protocol


### Requirements

* PHP 7.0
* meta-tech/silex 2
* meta-tech/silex-core
* meta-tech/pws-client (to test ws)


### Install

The package can be installed using [ Composer ](https://getcomposer.org/).
```
composer require meta-tech/pws-server
```

Or add the package to your `composer.json`.

```
"require": {
    "meta-tech/pws-server" : "^1.0"
}
```

### Usage

see [ MetaTech\Silex\Provider\ControllerServiceProvider ](https://github.com/meta-tech/silex-controller-service) 
to managing controllers & routing in application

```php
namespace MetaTech\PwsServer;

use MetaTech\Silex\Application as App;
use MetaTech\Silex\Provider\ControllerServiceProvider as CtrlProvider;
use MetaTech\Silex\Provider\UserProvider;
use MetaTech\Db\PdoWrapper;
use MetaTech\Db\Profile;
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
        $app['pdo'] = function ($app) {
            return new PdoWrapper(new Profile($app['config']['db']['default']));
        };
        $app['user.provider'] = function ($app) {
            return new UserProvider($app['pdo']);
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
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use MetaTech\PwsServer\Ws\Controller;

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

check `OtherWebService` to see another controller and deep routes inside rooting /ws entry point.
(the main différence consist in no calling the parent routing method)

`pwsAuth` Authentication mecanism is already provided by the `MetaTech\Silex\Ws\Controller`  parent class
& the `MetaTech\Silex\Ws\Authentication` handler (in [ meta-tech/silex-core](https://github.com/meta-tech/silex-core) package)

The project now implement the `checkUser` method via a `userProvider`  
It use a `MetaTech\Silex\Ws\Authentication` and `MetaTech\Silex\Ws\Controller` subclasses :

```php
namespace MetaTech\PwsServer\Ws;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use MetaTech\PwsAuth\Authenticator;
use MetaTech\Silex\Ws\Authentication as BaseAuthentication;
use MetaTech\Silex\Provider\UserProvider;

class Authentication extends BaseAuthentication
{
    protected $userProvider;

    public function __construct(Session $session, Authenticator $authenticator, PasswordEncoderInterface $passEncoder = null, UserProvider $userProvider)
    {
        parent::__construct($session, $authenticator, $passEncoder);
        $this->userProvider = $userProvider;
    }

    public function checkUser($login, $password, $key, PasswordEncoderInterface $passEncoder = null)
    {
        $done = false;
        try {
            if (!is_null($passEncoder)) {
                $user = $this->userProvider->loadUserByUsername($login);
                $salt = $this->authenticator->getUserSalt($login);
                $done = $user->key == $key && $passEncoder->encodePassword($password, $salt) == $user->getPassword();
            }
        }
        catch(\Exception $e) {
            //~ var_dump($e->getTraceAsString());
        }
        return $done;
    }
}
```


### Test uris :

access through web browser :  

* servername/
* servername/test

access through pws-client :  

* servername/ws
* servername/ws/deep
* servername/ws/isauth


### License

The project is released under the MIT license, see the LICENSE file.
