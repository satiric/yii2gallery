<?php

/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 09.10.15
 * Time: 12:33
 */

namespace common\components\behaviors;
use yii;

/**
 * Class SessionBehavior
 * @package common\components\behaviors
 */
class SessionBehavior extends \yii\base\Behavior
{
    /** eq. $_SESSION with yii shell
     * @param null|string $key if null, return all data from session
     * @return mixed|null|\yii\web\Session
     */
    public function getSession($key = null)
    {
        $session = Yii::$app->session;
        if (!$session->isActive)
        {
            $session->open();
        }
        return (!is_null($key) && isset($session[$key]))
            ? $session[$key]
            : $session;
    }

    /** 
     * @param $key mixed in session
     * @return mixed|null
     */
    public function getFromSession($key)
    {
        $session = self::getSession(); //this is behavior, so we need use functions with self::
        if(!is_null($session))
        {
            return (isset($session[$key]))
                ? $session[$key]
                : null;
        }
        return null;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function rmFromSession($key)
    {
        $session = self::getSession();
        return $session->remove($key);
    }

    /**
     * @param $arr
     * @param bool $rewrite
     */
    public function setSessionArray($arr, $rewrite = true)
    {
        $session = self::getSession();
        foreach($arr as $k => $v)
        {
            if(!$rewrite && $session->get($k))
            {
                continue;
            }
            $session->set($k,$v);
        }
    }

    /**
     * @param $key
     * @param $value
     * @param bool $rewrite
     */
    public function setToSession($key,$value, $rewrite = true) {
        $session = self::getSession();
        if(!$rewrite && $session->get($key)) {
            return;
        }
        $session->set($key,$value);
    }

    /**
     * @param $msg
     * @param string $type
     */
    public function setFlashMsg($msg, $type='error')
    {
        Yii::$app->getSession()->setFlash($type, $msg);
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasMsg($key)
    {
        return Yii::$app->getSession()->hasFlash($key);
    }
}