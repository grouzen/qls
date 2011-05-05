<?php

/*
 * Based on "QLS" framework <http://bitbucket.org/grouzen/qls>.
 * 2010 (c) Nedokushev Michael <grouzen.hexy@gmail.com>.
 */

if(!defined('QLS'))
	die("Are you hacker?! NO WAY!");

class Email implements Singleton {

    private static $_instance = null;

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function send($to, $subject, $body)
    {
        /* Without authorisation. */

        return mail($to, $subject, $body);
        
        /*
        $headers = array('From' => Settings::getMailFrom(),
                         'To' => $to,
                         'Subject' => $subject);
        $smtp = Mail::factory(Settings::getMailBackend(),
                              array('host' => Settings::getMailHost(),
                                    'auth' => Settings::getMailAuth(),
                                    'username' => Settings::getMailUsername(),
                                    'password' => Settings::getMailPassword()));
        $mail = $smtp->send($to, $headers, $body);

        if(PEAR::isError($mail)) {
            echo $mail->getMessage();
            return false;
        }

        return true;
        */
    }

    public function isEmail($email)
    {
        return preg_match('/^.+\@[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{2,4})$/', $email);
    }
}

?>
