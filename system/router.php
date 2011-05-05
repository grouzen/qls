<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Router implements Singleton {

    private static $_instance = null;

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function encodeRoute($route)
    {
        $request = explode('/', $route);
        $query = array('controller' => null,
                       'action' => null,
                       'params' => null);

        if($request[count($request) - 1] === '') {
            unset($request[count($request) - 1]);
        }

        if(count($request) == 1) {
            $query['controller'] = $request[0];
        } else {
            $query['controller'] = $request[0];
            $query['action'] = $request[1];

            if(count($request) > 2) {
                $query['params'] = array();
                for($i = 0, $j = 2; $j < count($request); $i++, $j++) {
                    $query['params'][$i] = $request[$j];
                }
            }
        }

        return $query;
    }

    public function decodeRoute($query)
    {
        $route = '';
        
        if(!is_null($query['controller'])) {
            $route = $query['controller'];
            
            if(!is_null($query['action'])) {
                $route .= '/' . $query['action'];

                if(!is_null($query['params'])) {
                    for($i = 0; $i < count($query['params']); $i++) {
                        $route .= '/' . $query['params'][$i];
                    }
                }
            }
        }

        return $route;
    }
    
    public function process()
    {
        if(isset($_GET['route'])) {
            $route = (string) strtolower($_GET['route']);
            $query = $this->encodeRoute($route);
            
            $this->delegate($query['controller'], $query['action'], $query['params']);
        } else {
            $this->delegate();
        }            
    }

    public function delegate($controller = null, $action = null, $params = null)
    {
        $registry = Registry::getInstance();

        if(is_null($controller))
            $controller = Settings::getDefaultModule();

        if(file_exists(MODULES . $controller . '.php')) {
            include_once MODULES . $controller . '.php';

            $controller_class = 'Controller_' . ucfirst($controller);
            $obj = call_user_func(array($controller_class, 'getInstance'));
            
            if(!is_null($action)) {
                if(!method_exists($obj, $action))
                    $this->redirect(Settings::getError404());
            } else {
                $action = Settings::getDefaultAction();
            }

            if($registry->exists('body_tpl')) {
                $registry->delete('body_tpl');
            }

            $registry->set('body_tpl', $controller . '-' . $action . '.tpl');

            if(!is_null($params)) {
                $obj->$action($params);
            } else {
                $obj->$action();
            }
        } else {
            $this->redirect(Settings::getError404());
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}

?>
