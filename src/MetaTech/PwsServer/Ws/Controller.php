<?php
/*
 * This file is part of the pws-server package.
 *
 * (c) meta-tech.academy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MetaTech\PwsServer\Ws;

use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use MetaTech\Silex\Ws\Controller as BaseController;
use MetaTech\PwsServer\Ws\Authentication;

/*!
 * @package     MetaTech\PwsServer\Ctrl
 * @class       Controller
 * @extends     MetaTech\Silex\Ws\Controller
 * @author      a-Sansara
 * @date        2017-03-15 10:41:57 CET
 */
class Controller extends BaseController
{
    /*!
     * @constrcutor
     * @public
     * @param       Silex\Application   $app
     */
    public function __construct(Application $app = null)
    {
        $this->session = $app['session'];
        $this->handler = new Authentication($this->session, $app['ws.authenticator'], $app['user.provider']);
    }
}
