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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use MetaTech\PwsAuth\Authenticator;
use MetaTech\Silex\Ws\Authentication as BaseAuthentication;
use MetaTech\Silex\Provider\UserProvider;

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
     * @param       Symfony\Component\HttpFoundation\Session\Session                    $session
     * @param       MetaTech\PwsAuth\Authenticator                                      $authenticator
     * @param       Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface    $passEncoder
     * @param       MetaTech\Silex\Provider\UserProvider                                $userProvider
     */
    public function __construct(Session $session, Authenticator $authenticator, PasswordEncoderInterface $passEncoder = null, UserProvider $userProvider)
    {
        parent::__construct($session, $authenticator, $passEncoder);
        $this->userProvider = $userProvider;
    }

    /*!
     * @method      checkUser
     * @public
     * @param       str                                                                 $login
     * @param       str                                                                 $password
     * @param       str                                                                 $key
     * @param       Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface    $passEncoder
     * @return      bool
     */
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
