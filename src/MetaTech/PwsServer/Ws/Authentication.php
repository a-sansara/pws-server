<?php
/*
 * This file is part of the silex-core package.
 *
 * (c) meta-tech.academy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MetaTech\PwsServer\Ws;

use Symfony\Component\HttpFoundation\Session\Session;
use MetaTech\PwsAuth\Authenticator;
use MetaTech\Silex\Ws\Authentication as BaseAuthentication;

/*!
 * @package     MetaTech\PwsServer\Ws
 * @class       Authentication
 * @author      a-Sansara
 * @date        2017-03-15 10:42:42 CET
 */
class Authentication extends BaseAuthentication
{
    /*! @protected @®ar MetaTech\PwsAuth\Authenticator $authenticator */
    protected $userProvider;

    /*!
     * @constructor
     * @public
     * @param       Symfony\Component\HttpFoundation\Session\Session    $session
     * @param       MetaTech\PwsAuth\Authenticator                      $authenticator
     */
    public function __construct(Session $session, Authenticator $authenticator, $userProvider)
    {
        parent::__construct($session, $authenticator);
        $this->userOrovider = $userProvider;
    }

    /*!
     * @method      checkUser
     * @public
     * @param      str      $login
     * @param      str      $password
     * @param      str      $key
     * @return      bool
     */
    public function checkUser($login, $password, $key)
    {
        // @todo implements with userProvider
        return true;
    }
}
