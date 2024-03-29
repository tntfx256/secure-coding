<?php

namespace App\Controller;

use App\Util\TokenBasedSession;
use FW\App\Config;
use FW\App\Controller;
use FW\Util\Util;

class SessionController extends Controller
{
    /** @var  TokenBasedSession */
    private $tokenSession;
    private $isCookieBased = true;
    private $isAjax = false;
    const TokenKeyName = 'X-AUTH-TOKEN';
    const ServerTokenName = 'HTTP_X_AUTH_TOKEN';

    protected function init()
    {
        if ($this->action == 'index') return;
        $this->isCookieBased = $this->action == 'cookie';
        // check if the system is cookie based
        // if not, it only should check session if it is an ajax call
        $this->isAjax = $this->request->get('ajax', 0);
        if ($this->isCookieBased || (!$this->isCookieBased && $this->isAjax)) {
            $this->tokenSession = new TokenBasedSession(Config::getInstance()->security['sessionHost']);
            $storage = $this->isCookieBased ? $_COOKIE : $_SERVER;
            // obtaining token
            $token = $storage[$this->isCookieBased ? self::TokenKeyName : self::ServerTokenName] ?? null;
            // checking session validation
            if ($token) {
                $tokenIsValid = $this->tokenSession->init($token);
                if ($tokenIsValid !== true) {
                    $this->regenerateSession();
                }
            } else {
                $this->tokenSession->init();
                $this->publishToken();
            }
        }
    }

    private function regenerateSession()
    {
        if ($this->tokenSession->destroy()) {
            // todo failed to delete key from redis
        }
        $this->tokenSession->init();
        $this->publishToken();
    }

    private function publishToken()
    {
        $this->isCookieBased ? setcookie(self::TokenKeyName, $this->tokenSession->getToken()) :
            $this->response->header(self::TokenKeyName, $this->tokenSession->getToken());
    }

    function indexAction()
    {
        $this->view->set('cookie', $this->url('session', 'cookie'));
        $this->view->set('ajax', $this->url('session', 'ajax'));
        $this->view->html($this->view->render('session/index'));
    }

    function cookieAction()
    {
        // checking for delete
        if ($this->request->hasPost('delete')) {
            $this->regenerateSession();
        }
        if ($this->request->hasPost('update')) {
            $username = $this->request->post('username', '');
            $this->tokenSession->set('user', ['username' => $username]);
        }
        $this->view->set('page', $this->url('session','cookie'));
        $this->view->set('ajax', $this->url('session','ajax'));
        $this->view->set('user', $this->tokenSession->get('user'));
        $this->view->html($this->view->render('session/cookie'));
    }

    function ajaxAction()
    {
        if ($this->isAjax) {
            if ($this->request->get('delete', 0)) {
                $this->regenerateSession();
            } else {
                $username = $this->request->post('username', '');
                if ($username) {
                    $this->tokenSession->set('user', ['username' => $username]);
                }
            }
            $this->view->json(['user' => $this->tokenSession->get('user')]);
        } else {
            $this->view->set('page', Util::genUrl('session/ajax'));
            $this->view->set('cookie', Util::genUrl('session/cookie'));
            $this->view->html($this->view->render('session/ajax'));
        }
    }
}
