<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.01.17
 * Time: 1:54
 */

namespace common\components\bases;

/**
 * Class BaseException
 * @package common\components\bases
 */
class BaseException extends \Exception
{
    /**
     * @var array with errors messages from models validator or something else 
     */
    protected $errors = [];

    /**
     * BaseException constructor.
     * @param array $errors
     * @param string $message
     */
    public function __construct($message = "", $errors = []) {
        if ($message) {
            $this->message = $message;
        }
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

}