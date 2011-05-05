<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Controller_Admin implements Singleton {

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
        $this->_tpl->view();

        exit;
    }

    public function adv($params = null)
    {
        if($_SESSION['role'] === 'admin') {
            $do = is_null($params) ? '' : $params[0];

            if($do === 'add') {
                if(!empty($_POST)) {
                    $advname = trim($this->_db->escapeString($_POST['advname']));
                    $advurl = trim($this->_db->escapeString($_POST['advurl']));
                    $date_end_year = (int) $_POST['date_end_year'];
                    $date_end_month = (int) $_POST['date_end_month'];
                    $date_end_day = (int) $_POST['date_end_day'];

                    $date_end = strtotime("$date_end_year-$date_end_month-$date_end_day");

                    $assert = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND advname = '" . $advname . "'");
                    if($this->_db->num_rows($assert)) {
                        new SetError('adv-add-error', 'Реклама с таким именем уже существует');
                    } else if(empty($advname) || empty($_FILES['advfile'])) {
                        new SetError('adv-add-error', 'Одно из обязательных полей не заполнено');
                    } else {
                        $files = $_FILES['advfile'];
                        $error = $files['error'];
                        if($error == UPLOAD_ERR_OK) {
                            $type = $files['type'];
                            $tmp_name = $files['tmp_name'];
                            $uname = md5($tmp_name);
                            $suffix = substr($type, strpos($type, '/') + 1);
                            $name = $uname . '.' . $suffix;

                            move_uploaded_file($tmp_name, 'files/adv/' . $name);

                            $this->_db->query("INSERT INTO adv (advname, advfile, date_end, advurl) VALUES ('" . $advname . "', '" . $name . "', " . $date_end . ", '" . $advurl . "')");
                            new SetMessage('adv-add-message', 'Реклама успешно добавлена');
                        } else if($error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE) {
                            new SetError('adv-add-error', 'Ошибка(превышен допустипый размер файла): файл не был загружен: ' . $files['name']);
                        }
                    }
                }
            } else if($do === 'delete') {
                $id = (int) $params[1];

                $assert = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND id = $id");
                if($this->_db->num_rows($assert)) {
                    $this->_db->query("UPDATE adv SET deleted = 0 WHERE id = $id");

                    new SetMessage('adv-delete-message', 'Реклама успешно удалена');
                } else {
                    new SetError('adv-delete-error', 'Такой рекламы не существует');
                }
            } else if($do === 'avoid') {
                $id = (int) $params[1];

                $assert = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND id = $id");
                if($this->_db->num_rows($assert)) {
                    $this->_db->query("UPDATE adv SET nuniq_show_count = 0, nuniq_click_count = 0 WHERE id = $id");
                    $this->_db->query("DELETE FROM adv_uniq_click WHERE adv_id = $id");
                    $this->_db->query("DELETE FROM adv_uniq_show WHERE adv_id = $id");

                    new SetMessage('adv-avoid-message', 'Счетчики рекламы успешно обнулены');
                } else {
                    new SetError('adv-avoid-error', 'Такой рекламы не существует');
                }
            } else if($do === 'edit') {
                if(!empty($_POST)) {
                    $id = (int) $_POST['id'];
                    $advname = trim($this->_db->escapeString($_POST['advname']));
                    $advurl = trim($this->_db->escapeString($_POST['advurl']));
                    $date_end_year = (int) $_POST['date_end_year'];
                    $date_end_month = (int) $_POST['date_end_month'];
                    $date_end_day = (int) $_POST['date_end_day'];

                    $date_end = strtotime("$date_end_year-$date_end_month-$date_end_day");
                    
                    $assert = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND id = $id");
                    if(!$this->_db->num_rows($assert)) {
                        new SetError('adv-edit-error', 'Такой рекламы не существует');
                    } else if(empty($advname) || empty($_FILES['advfile'])) {
                        new SetError('adv-edit-error', 'Одно из обязательных полей не заполнено');
                    } else {
                        $files = $_FILES['advfile'];

                        if(!empty($files['name'])) {
                            $error = $files['error'];
                            if($error == UPLOAD_ERR_OK) {
                                $type = $files['type'];
                                $tmp_name = $files['tmp_name'];
                                $uname = md5($tmp_name);
                                $suffix = substr($type, strpos($type, '/') + 1);
                                $name = $uname . '.' . $suffix;

                                move_uploaded_file($tmp_name, 'files/adv/' . $name);

                                $this->_db->query("UPDATE adv SET advname = '" . $advname . "', advfile = '" . $name . "', date_end = " . $date_end . ", advurl = '" . $advurl . "' WHERE id = $id");
                                new SetMessage('adv-add-message', 'Реклама успешно отредактирована');
                            } else if($error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE) {
                                new SetError('adv-add-error', 'Ошибка(превышен допустипый размер файла): файл не был загружен: ' . $files['name']);
                            }
                        } else {
                            $this->_db->query("UPDATE adv SET advname = '" . $advname . "', date_end = " . $date_end . ", advurl = '" . $advurl . "' WHERE id = $id");
                        }
                    }
                } else {
                    $id = (int) $params[1];

                    $res = $this->_db->query("SELECT * FROM adv WHERE deleted = 0 AND id = $id");
                    if($this->_db->num_rows($res)) {
                        $this->_tpl->adv = $this->_db->fetch_array($res);
                    } else {
                        new SetError('adv-edit-error', 'Такой рекламы не существует');
                    }
                }
            }
        }

        $users_advs = array();
        $res_users_adv = $this->_db->query("SELECT * FROM users_adv WHERE user_id = " . $_SESSION['id']);
        if($this->_db->num_rows($res_users_adv)) {
            while($fetch_users_adv = $this->_db->fetch_array($res_users_adv)) {
                $users_advs[] = $fetch_users_adv['adv_id'];
            }
        }
        
        $advs = array();
        $res = $this->_db->query("SELECT * FROM adv WHERE deleted = 0");
        if($this->_db->num_rows($res)) {
            for($i = 0; $fetch = $this->_db->fetch_array($res); $i++) {
                if($_SESSION['role'] === 'admin' ||
                   ($_SESSION['role'] === 'user' && array_search($fetch['id'], $users_advs) !== false)) {
                    $advs[$i] = $fetch;
                    
                    $res_uniq_show = $this->_db->query("SELECT * FROM adv_uniq_show WHERE adv_id = " . $advs[$i]['id']);
                    $advs[$i]['uniq_show_count'] = $this->_db->num_rows($res_uniq_show);

                    $res_uniq_click = $this->_db->query("SELECT * FROM adv_uniq_click WHERE adv_id = " . $advs[$i]['id']);
                    $advs[$i]['uniq_click_count'] = $this->_db->num_rows($res_uniq_click);
                }
            }
        }
        
        $this->_tpl->advs = $advs;

        $this->_tpl->view();

        exit;
    }
    
    public function news($params = null)
    {
        if($_SESSION['role'] !== 'admin') {
            Router::getInstance()->redirect(Settings::getAddressSite() . 'admin/');
        }
        
        $do = is_null($params) ? '' : $params[0];
        
        if($do === 'add') {
            
            if(!empty($_POST)) {
                $title = trim($this->_db->escapeString($_POST['title']));
                //$enable_comments = (int) $_POST['enable_comments'];
                $body = trim($_POST['body']);
                //$body = preg_replace("/\r\n/", '<br>', $body);
                $body = $this->_db->escapeString($body);
                                
                if(empty($title) || empty($body)) {
                    new SetError('news-add-error', 'Одно из обязательных полей не заполнено');
                } else {
                    $assert = $this->_db->query("SELECT * FROM news WHERE master = 1 AND deleted = 0");
                    if($this->_db->num_rows($assert)) {
                        $this->_db->query("INSERT INTO news (title, body, date, author_id) VALUES ('" . $title . "', '" . $body . "', " . time() . ", " . $_SESSION['id'] . ")");
                    } else {
                        $this->_db->query("INSERT INTO news (title, body, master, enable_comments, date, author_id) VALUES ('" . $title . "', '" . $body . "', 1, " . $enable_comments . ", " . time() . ", " . $_SESSION['id'] . ")");
                    }
                    
                    new SetMessage('news-add-message', 'Новость успешно добавлена');
                }
            }
            
            //echo var_dump($_POST);
        } else if($do === 'delete_image') {
            $id = (int) $params[1];

            $assert = $this->_db->query("SELECT * FROM files WHERE id = " . $id);
            if(!$this->_db->num_rows($assert)) {
                new SetError('news-delete_image-error', 'Такого изображения не существует');
            } else {
                $fetch = $this->_db->fetch_array($assert);
                $this->_db->query("DELETE FROM files WHERE id = " . $id);
                unlink('files/' . $fetch['path']);

                new SetMessage('news-delete_image-message', 'Изображение успешно удалено');
            }
        } else if($do === 'delete') {
            $id = (int) $params[1];

            $assert = $this->_db->query("SELECT * FROM news WHERE id = " . $id);
            if(!$this->_db->num_rows($assert)) {
                new SetError('news-delete-error', 'Такой новости не существует');
            } else {
                $this->_db->query("UPDATE news SET deleted = 1 WHERE id = " . $id);
                
                $assert = $this->_db->query("SELECT * FROM news WHERE master = 1 AND deleted = 0");
                if(!$this->_db->num_rows($assert)) {
                    $this->_db->query("UPDATE news SET master = 1 WHERE NOT id = " . $id . " AND deleted = 0 LIMIT 1");
                }
                
                new SetMessage('news-delete-message', 'Новость успешно удалена');
            }
        } else if($do === 'master') {
            $id = (int) $params[1];
            
            $assert = $this->_db->query("SELECT * FROM news WHERE id = " . $id);
            if(!$this->_db->num_rows($assert)) {
                new SetError('news-master-error', 'Такой новости не существует');
            } else {
                $this->_db->query("UPDATE news SET master = 0 WHERE master = 1");
                $this->_db->query("UPDATE news SET master = 1 WHERE id = " . $id);

                new SetMessage('news-master-message', 'Новость успешно стала главной');
            }
        } else if($do == 'edit') {
            if(!empty($_POST)) {
                $id = (int) $_POST['id'];
                $title = trim($this->_db->escapeString($_POST['title']));
                //$enable_comments = (int) $_POST['enable_comments'];
                $body = trim($_POST['body']);
                //$body = preg_replace("/\r\n/", '<br>', $body);
                $body = $this->_db->escapeString($body);
                
                $assert = $this->_db->query("SELECT * FROM news WHERE deleted = 0 AND id = " . $id);
                if(!$this->_db->num_rows($assert)) {
                    new SetError('news-edit-error', 'Такой новости не существует');
                } else if(empty($title) || empty($body)) {
                    new SetError('news-edit-error', 'Одно из обязательных полей не заполнено');
                } else {
                    /*
                    $error = '';
                    
                    foreach($_FILES['files']['error'] as $k => $e) {
                        $type = $_FILES['files']['type'][$k];
                        if($e == UPLOAD_ERR_OK && strstr($type, 'image')) {
                            $tmp_name = $_FILES['files']['tmp_name'][$k];
                            $uname = md5($tmp_name);
                            $suffix = substr($type, strpos($type, '/') + 1);
                            $name = $uname . '.' . $suffix;
                            
                            move_uploaded_file($tmp_name, 'files/' . $name);

                            $this->_db->query("INSERT INTO files (news_id, path) VALUES (" . $id . ", '" . $name . "')");
                        } else if($e == UPLOAD_ERR_INI_SIZE || $e == UPLOAD_ERR_FORM_SIZE) {
                            $name = $_FILES['files']['name'][$k];

                            $error .= 'Ошибка(превышен допустимый размер файла): файл не был загружен: ' . $name . '<br />';
                        }
                    }
                 
                    if(!empty($error)) {
                        new SetError('news-edit-error', $error);
                    }
                    */
                    $this->_db->query("UPDATE news SET title = '" . $title . "', body = '" . $body . "' WHERE id = " . $id);
                    new SetMessage('news-edit-message', 'Новость успешно отредактирована');
                }
            } else {
                $id = (int) $params[1];
                                    
                $res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 AND id = " . $id);
                if($this->_db->num_rows($res)) {
                    $onenews = $this->_db->fetch_array($res);
                    $onenews['files'] = array();
                    
                    $res = $this->_db->query("SELECT * FROM files WHERE news_id = " . $id . " ORDER BY id");
                    if($this->_db->num_rows($res)) {
                        while($fetch = $this->_db->fetch_array($res)) {
                            $onenews['files'][] = $fetch;
                        }
                    }
                    
                    $this->_tpl->onenews = $onenews;
                } else {
                    new SetError('news-edit-error', 'Такой новости не существует');
                }
            }
        }
        
        $news = array();
        $main_news = array();
        $res = $this->_db->query("SELECT * FROM news WHERE deleted = 0 ORDER BY id DESC");
        if($this->_db->num_rows($res)) {
            while($fetch = $this->_db->fetch_array($res)) {
                $n = $fetch;
                
                $body = $n['body'];
                if(mb_strlen($body) > 200) {
                    $body = mb_substr($body, 0, 200);
                    $body .= '...';
                }
                $n['body'] = $body;

                $image = $this->_db->query("SELECT * FROM files WHERE news_id = " . $n['id'] . " ORDER BY id LIMIT 1");
                if($this->_db->num_rows($image)) {
                    $n['image'] = $this->_db->fetch_array($image);
                }

                if($n['master'] == 1) {
                    $main_news = $n;
                } else {
                    $news[] = $n;
                }
            
            }
        }
        
        $this->_tpl->news = $news;
        $this->_tpl->main_news = $main_news;

        $this->_tpl->view();

        exit;
    }

    public function admins($params = null)
    {
        if($_SESSION['role'] !== 'admin') {
            Router::getInstance()->redirect(Settings::getAddressSite() . 'admin/');
        }
        
        $do = is_null($params) ? '' : $params[0];

        if($do === 'add') {
            $login = $_POST['login'];
            $name = trim($this->_db->escapeString($_POST['name']));
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = isset($_POST['role']) ? 'admin' : 'user';

            if(!Email::getInstance()->isEmail($email)) {
                new SetError('admins-add-error', 'Неверный формат поля "E-mail"');
            } else if(!Sessions::getInstance()->isLogin($login)) {
                new SetError('admins-add-error', 'Неверный формат поля "Логин"');
            } else if(!Sessions::getInstance()->isPassword($password)) {
                new SetError('admins-add-error', 'Неверный формат поля "Пароль"');
            } else if(empty($name)) {
                new SetError('admins-add-error', 'Поле "Отображаемое имя" не заполнено');
            } else {
                $assert = $this->_db->query("SELECT * FROM users WHERE login = '" . $login . "'");
                if($this->_db->num_rows($assert)) {
                    new SetError('admins-add-error', 'Администратор с таким логином уже существует');
                } else {
                    $this->_db->query("INSERT INTO users (login, name, password, email, role) VALUES " .
                                      "('" . $login . "', '" . $name . "', '" . md5($password) . "', '" . $email . "', '" . $role . "')");

                    new SetMessage('admins-add-message', 'Администратор успешно добавлен');
                }
            }
        } else if($do === 'delete') {
            $id = (int) $params[1];

            $assert = $this->_db->query("SELECT * FROM users WHERE id = " . $id);
            if(!$this->_db->num_rows($assert)) {
                new SetError('admins-delete-error', 'Такого администратора не существует');
            } else {
                $this->_db->query("UPDATE users SET deleted = 1 WHERE id = " . $id);
                new SetMessage('admins-delete-message', 'Администратор успешно удален');
            }
        } else if($do === 'edit') {
            if(!empty($_POST)) {
                $id = (int) $_POST['id'];
                $login = $_POST['login'];
                $name = trim($this->_db->escapeString($_POST['name']));
                $password = $_POST['password'];
                $email = $_POST['email'];
                $role = isset($_POST['role']) ? 'admin' : 'user';
                $advs = $_POST['advs'];

                $assert = $this->_db->query("SELECT * FROM users WHERE deleted = 0 AND id = " . $id);
                if(!$this->_db->num_rows($assert)) {
                    new SetError('admins-edit-error', 'Такого редактора не существует');
                } else if(!Email::getInstance()->isEmail($email)) {
                    new SetError('admins-edit-error', 'Неверный формат поля "E-mail"');
                } else if(!Sessions::getInstance()->isLogin($login)) {
                    new SetError('admins-edit-error', 'Неверный формат поля "Логин"');
                } else if(!Sessions::getInstance()->isPassword($password)) {
                    new SetError('admins-edit-error', 'Неверный формат поля "Пароль"');
                } else if(empty($name)) {
                    new SetError('admins-edit-error', 'Поле "Отображаемое имя" не заполнено');
                } else {
                    $this->_db->query("UPDATE users SET login = '" . $login . "', name = '" . $name . "', " .
                                      (empty($password) ? '' : "password = '" . md5($password) . "', ") . "email = '" . $email . "', role = '" . $role . "' WHERE id = " . $id);
                    $this->_db->query("DELETE FROM users_adv WHERE user_id = $id");
                    foreach($advs as $adv) {
                        $this->_db->query("INSERT INTO users_adv (user_id, adv_id) VALUES ($id, $adv)");
                    }
                    
                    new SetMessage('admins-edit-message', 'Администратор успешно отредактирован');
                }

            } else {
                $id = (int) $params[1];

                $assert = $this->_db->query("SELECT * FROM users WHERE deleted = 0 AND id = " . $id);
                if($this->_db->num_rows($assert)) {
                    $admin = $this->_db->fetch_array($assert);

                    $this->_tpl->admin = $admin;
                    
                    $users_advs = array();
                    $res_users_adv = $this->_db->query("SELECT * FROM users_adv WHERE user_id = " . $id);
                    if($this->_db->num_rows($res_users_adv)) {
                        while($fetch_users_adv = $this->_db->fetch_array($res_users_adv)) {
                            $users_advs[] = $fetch_users_adv['adv_id'];
                        }
                    }
                    $this->_tpl->users_advs = $users_advs;
                } else {
                    new SetError('admins-edit-error', 'Такого администратора не существует');
                }
            }
        }
        
        $advs = array();
        $res = $this->_db->query("SELECT * FROM adv WHERE deleted = 0");
        if($this->_db->num_rows($res)) {
            while($fetch = $this->_db->fetch_array($res)) {
                $advs[] = $fetch;
            }
        }
        $this->_tpl->advs = $advs;
        
        $admins = array();
        $res = $this->_db->query("SELECT * FROM users WHERE deleted = 0 ORDER BY id");
        if($this->_db->num_rows($res)) {
            while($fetch = $this->_db->fetch_array($res)) {
                $admins[] = $fetch;
            }
        }
        $this->_tpl->admins = $admins;

        $this->_tpl->view();

        exit;
    }
    
    public function login($params = null)
    {
        $login = $this->_db->escapeString($_POST['login']);
        $password = $this->_db->escapeString($_POST['password']);
        $remember = isset($_POST['remember']);
        
        $res = $this->_db->query("SELECT * FROM users WHERE " .
                                 "login = '" . $login . "' AND password = '" . md5($password) . "' AND deleted = 0");
        if($this->_db->num_rows($res)) {
            $fetch = $this->_db->fetch_array($res);

            $_SESSION['id'] = $fetch['id'];
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $fetch['role']; // 'user' || 'admin'
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

        Sessions::getInstance()->login(array('controller' => 'admin', 'action' => 'index', 'params' => null));

        exit;
    }

    public function logout($params = null)
    {
        Sessions::getInstance()->logout(array('controller' => 'admin', 'action' => 'index', 'params' => null));

        exit;
    }
}

?>
