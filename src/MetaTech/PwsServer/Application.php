<?php
/*
 * This file is part of the pws-server package.
 *
 * (c) meta-tech.academy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MetaTech\PwsServer;

use MetaTech\Silex\Application as App;
use MetaTech\Silex\Provider\ControllerServiceProvider as CtrlProvider;
use MetaTech\PwsAuth\Authenticator;
use MetaTech\PwsServer\Ctrl\Test;
use MetaTech\PwsServer\Ctrl\WebService;
use MetaTech\PwsServer\Ctrl\OtherWebService;

/*!
 * @package     MetaTech\PwsServer
 * @class       Application
 * @extends     Silex\Application
 * @author      a-Sansara
 * @date        2017-03-12 21:46:43 CET
 */
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
