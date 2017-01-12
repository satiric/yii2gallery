<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 11.01.17
 * Time: 17:03
 */
namespace common\traits;
use common\components\helpers\ExtArrayHelper;
use yii;

trait SimpleYiiTrait
{
    /**
     * @return bool|int|string
     */
    public function getUserId() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        return Yii::$app->user->identity->getId();
    }

    /** get parameters from yii application
     * @param null|string $param
     * @return mixed
     */
    public function getParams($param = null)
    {
        if(is_null($param))
        {
            return Yii::$app->params;
        }
        return (isset(Yii::$app->params[$param]))
            ? Yii::$app->params[$param]
            : null;
    }

    /**
     * @param $path string path to target file  
     * @param int $mode oct file perms
     * @return bool file exists now or not
     */
    protected function requireFolder($path, $mode = 0777)
    {
        return file_exists($path) ||
        // if i haven't perms, then what i can do? just signaling about fail.
        ( @mkdir($path,$mode,true) && chmod($path, $mode) );
    }
    
    /**
     * @param string $diffWay taking care about valid diffWay
     * @return string
     */
    public function getUploadRoot($diffWay = '') {
        return (!$diffWay) 
            ? Yii::getAlias('@webroot')."/images"
            : Yii::getAlias('@webroot').$diffWay;
    }

    /**
     * @param $data array, example : [ ['id' => 1, 'caption' => 'capt', 'position' => 'pos' ] ]
     * @param string $key main key, example: 'id'
     * @param array $fields, example: ['caption']
     * @return array, example: [ 1 => ['caption' => 'capt ] ]  
     */
    public function mapDataArray($data, $key = "id", $fields = []) {
        if (empty($fields)) { 
            $fields = ['*'];
        }
        return ExtArrayHelper::map($data, $key, $fields);
    }
}