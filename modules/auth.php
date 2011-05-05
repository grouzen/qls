<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_Auth implements Singleton {

    private static $_instance = null;

    private $_db;
    private $_tpl;
    
    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    function __construct()
    {
        $this->_db = DB::getInstance();
        $this->_tpl = Templater::getInstance();
    }

    public function index($params = null)
    {
        Router::getInstance()->delegate('auth', 'registration');

        exit;
    }
    
    public function login($params = null)
    {
        $login = $this->_db->escapeString($_POST['login']);
        $password = $this->_db->escapeString($_POST['password']);
        $remember = isset($_POST['remember']);
        
        $res = $this->_db->query("SELECT * FROM users WHERE " .
                                 "login = '" . $login . "' AND password = '" . md5($password) . "'");
        if($this->_db->num_rows($res)) {
            $fetch = $this->_db->fetch_array($res);

            $_SESSION['id'] = $fetch['id'];
            $_SESSION['login'] = $fetch['login'];
            $_SESSION['role'] = 'member';
            $_SESSION['name'] = $fetch['name'];

            $cookie_expire = 0;
            if($remember) {
                $cookie_expire = 7 * 24 * 3600;
            } else {
                $cookie_expire = Settings::getCookieExpire();
            }
            setcookie('remember', 1, time() + $cookie_expire);
        } else {
            new SetError('login-error', 'Неверный логин или пароль');
        }

        Sessions::getInstance()->login('', '');

        exit;
    }

    public function logout($params = null)
    {
        Sessions::getInstance()->logout('', '');

        exit;
    }

    public function registrate($params = null)
    {
        $login = $this->_db->escapeString($_POST['login']);
        $name = $this->_db->escapeString($_POST['name']);
        $email = $this->_db->escapeString($_POST['email']);
        $password = $_POST['password'];

        $assert_users = $this->_db->query("SELECT * FROM users WHERE " .
                                          "login = '" . $login . "'");
        $assert_activation = $this->_db->query("SELECT * FROM activation WHERE " .
                                               "login = '" . $login . "' AND deleted = 0");
        if(empty($login) || empty($email) || empty($password)) {
            new SetError('registrate-error', 'Не заполнено обязательное поле');
        } else if($this->_db->num_rows($assert_users) || $this->_db->num_rows($assert_activation)) {
            new SetError('registrate-error', 'Пользователь с таким логином уже существует');
        } else if(!Email::getInstance()->isEmail($email)) {
            new SetError('registrate-error', 'Неверный формат e-mail');
        } else {
            $uid = md5(time() . $login);
            $subject = 'Confirmation of registration on ' . Settings::getAddressSite();
            $body = 'Please confirm your registration: ' . Settings::getAddressSite() . 'auth/activation/' . $uid;
            
            if(!Email::getInstance()->send($email, $subject, $body)) {
                new SetError('registrate-error', 'Ошибка при отправлении уведомления');
            } else {
                $this->_db->query("INSERT INTO activation (uid, login, password, email, name) " .
                                  "VALUES ('" . $uid . "', '" . $login .
                                  "', '" . md5($password) . "', '" . $email . "', '" . $name . "')");
                new SetMessage('registrate-message', 'Successful registration. Please check your e-mail for account activation');
            }
            
        }
        
        Router::getInstance()->delegate('auth', 'registration');
        exit;
    }

    public function registration($params = null)
    {
        $this->_tpl->view();

        exit;
    }

    public function activation($params = null)
    {
        $uid = $params[0];

        $res = $this->_db->query("SELECT * FROM activation WHERE " .
                                 "uid = '" . $uid . "' AND deleted = 0");
        if($this->_db->num_rows($res)) {
            $fetch = $this->_db->fetch_array($res);
            
            $this->_db->query("INSERT INTO users (login, password, email, name) " .
                              "VALUES ('" . $fetch['login'] . "', '" . $fetch['password'] .
                              "', '" . $fetch['email'] . "', '" . $fetch['name'] . "')");

            $this->_db->query("UPDATE activation SET deleted = 1 WHERE " .
                              "uid = '" . $uid . "'");

            new SetMessage('registrate-message', 'Successful activation. Now you can login!');
        } else {
            new SetError('registrate-error', 'Activation error');
        }
        
        Router::getInstance()->delegate('auth', 'registration');

        exit;
    }
}

?>
