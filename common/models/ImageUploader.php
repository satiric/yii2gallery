<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 09.01.17
 * Time: 16:20
 */

namespace common\models;

use common\components\bases\BaseModel;
use yii\imagine\Image;

/**
 * Class ImageUploader
 * @package common\models
 */
class ImageUploader extends BaseModel {

    /**
     * @var \yii\web\UploadedFile|null
     */
    public $fileObj = null;
    public $fileName;
    public $fileExt;
    public $basePath = "";
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileObj'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, gif, jpg, bmp, jpeg'],
        ];
    }
    
    /**
     * @param $root string way to the physical location of the fie. TODO check for Project Path
     * @param $ext string file extension
     * @param bool $nameOnly
     * @param int $countTries
     * @return string path or filename with random name
     */
    public static function generFilePath($root, $ext, $nameOnly = false, $countTries = 5)
    {
        $i = 0;
        do {
            if($i++ > $countTries){
                return null; //todo as exception
            }
            $name = md5(microtime() . rand(0, 9999));
            $filePath = $root . DIRECTORY_SEPARATOR. $name . "." .  $ext;
        }
        while (file_exists($filePath));
        return (!$nameOnly)
            ? $filePath
            : $name;
    }
    
    //@todo think about validating file size etc
    /**
     * @param $fileObject
     * @param $root
     * @return bool|string
     */
    public function upload($fileObject, $root)
    {
        if (!$fileObject) {
            return false;
        }
        $this->fileObj = $fileObject;
        if (!$this->validate()) //todo must trhow errors
        {
            return false;
        }
        $this->fileExt = $this->fileObj->extension;
        $this->fileName = self::generFilePath($root, $this->fileObj->extension, true);
        $this->fileObj = Image::watermark(
            $fileObject->tempName, // before saving file the system set it to cache, this is it name
            \Yii::getAlias('@webroot/images/watermark.png') //todo make as parameter? 
        );
        $fullName = $this->fileName . '.' . $this->fileExt;
        $filePath = $root . '/' . $fullName;
        $this->fileObj->save($filePath);
        chmod($filePath, 0644);
        return $fullName;
    }
}