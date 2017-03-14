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
use Symfony\Component\HttpFoundation\Response;
use MetaTech\Silex\Ctrl\Base;

/*!
 * @package     MetaTech\PwsServer\Ctrl
 * @class       Test
 * @extends     MetaTech\Silex\Ctrl\Base
 * @author      a-Sansara
 * @date        2017-03-12 15:39:30 CET
 */
class Test extends Base
{
    public function __construct(Application $app)
    {
    }

    public function index()
    {
        return new Response('index');
    }

    public function test()
    {
        return new Response('test');
    }

    public function routing(ControllerCollection $collection): ControllerCollection
    {
        $_ = $this->ns();

        $collection->match('/'    , "$_:index");
        $collection->match('/test', "$_:test");

        return $collection;
    }
}
