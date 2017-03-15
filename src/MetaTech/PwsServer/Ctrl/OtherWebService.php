<?php
/*
 * This file is part of the pws-server package.
 *
 * (c) meta-tech.academy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MetaTech\PwsServer\Ctrl;

use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use MetaTech\PwsServer\Ws\Controller;
/*!
 * @package     MetaTech\PwsServer\Ctrl
 * @class       OtherWebService
 * @extends     MetaTech\Silex\Ws\Controller
 * @author      a-Sansara
 * @date        2017-03-12 15:39:30 CET
 */
class OtherWebService extends Controller
{
    /*!
     * @method      index
     * @public
     * @return      Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $done = true;
        $msg  = 'this is deep index';
        return $this->response($done, $msg);
    }

    /*!
     * @method      routing
     * @public
     * @param       Silex\ControllerCollection   $collection
     * @return      Silex\ControllerCollection
     */
    public function routing(ControllerCollection $collection) : ControllerCollection
    {
        //~ $collection = parent::routing($collection);
        $_          = $this->ns();

        $collection->match('/', "$_:index");

        return $collection;
    }
}
