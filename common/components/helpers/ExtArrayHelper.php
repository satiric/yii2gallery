<?php

/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.01.17
 * Time: 0:32
 */

namespace common\components\helpers;

/**
 * Class ExtArrayHelper
 * @package common\components\helpers
 */
class ExtArrayHelper extends \yii\helpers\ArrayHelper
{

    /**
     * @param $element
     * @param array $keysForBody
     * @return array
     */
    protected static function getBody($element, $keysForBody = []) {
        if($keysForBody[0] === '*') {
            return $element;
        }
        $value = [];
        //many keys in result from array
        for($i = 0, $size = count($keysForBody); $i < $size; $i++) {
            $valuesKey = $keysForBody[$i];
            //then each result value saving his key
            $value[$valuesKey] = static::getValue($element, $valuesKey);
        }
        return $value;
    }
    /**
     * @inheritdoc
     *
     * +
     * 
     *  $array = [
     *     ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
     *     ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
     *     ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
     * ];
     *
     * $result = ArrayHelper::map($array, 'id', ['name', 'class']);
     * // the result is:
     * // [
     * //     '123' => ['name'=>'aaa', 'class' => 'x'],
     * //     '124' => ['name'=>'bbb', 'class' => 'x']
     * //     '345' => ['name'=>'ccc', 'class' => 'y']
     * // ]
     *  
     * also, ['*'] select all keys in array
     * 
     *  $result = ArrayHelper::map($array, 'id', ['*']);
     * // the result is:
     * // [
     * //     '123' => ['name'=>'aaa', 'class' => 'x'],
     * //     '124' => ['name'=>'bbb', 'class' => 'x']
     * //     '345' => ['name'=>'ccc', 'class' => 'y']
     * // ]
     * 
     * @param array $array
     * @param \Closure|string $from
     * @param \Closure|string|array $to
     * @param null $group
     * @return array
     */
    public static function map($array, $from, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $key = static::getValue($element, $from);
            $value = (is_array($to)) 
                ? self::getBody($element, $to) 
                : static::getValue($element, $to);

            if ($group !== null) {
                $result[static::getValue($element, $group)][$key] = $value;
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}