<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 11.01.17
 * Time: 18:58
 */

namespace frontend\models;

use common\components\bases\BaseModel;
use common\components\exceptions\DeleteFileFailureException;
use common\components\exceptions\FolderCannotCreateException;
use common\components\exceptions\UploadFailureException;
use common\models\ImageUploader;
use common\traits\SimpleYiiTrait;
use yii\web\UploadedFile;

/** todo make as utils
 * Class UserFileForm
 * @package frontend\models
 */
class UserFileForm extends BaseModel
{
    use SimpleYiiTrait;
    const FORM_NAME = "inputsfile";
    /** @var $userId string|int file owner */
    public $userId;
    public $fileId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId', 'fileId'], 'integer'],
        ];
    }
    
    /**
     * @param $rootPath string path to the upload point
     * @param $userId string|int id for getting private folder, can be modified to more security alg.
     * @return string
     */
    static public function getUserPath($userId, $rootPath) {
        return $rootPath.'/'.$userId;
    }

    /**
     * @param UploadedFile $file
     * @param $rootPath
     * @return UserFileRecord
     * @throws UploadFailureException
     */
    protected function createFileRecord(UploadedFile $file, $rootPath) {
        $fileRecord = new UserFileRecord();
        $fileRecord->user_id = $this->userId;
        $fileRecord->file_name = (new ImageUploader())->upload($file, $rootPath);
        if (!$fileRecord->file_name) {
            throw new UploadFailureException("Filename was been generated wrong");
        }
        if ( !$fileRecord->save() ) {
            unlink($rootPath . '/' . $fileRecord->file_name);
            throw new UploadFailureException("Filerecord was not been saved", $fileRecord->getErrors());
        }
        return $fileRecord;
    }

    /** todo to some file helper
     * @param $path
     * @return bool
     */
    protected function rmRealFile($path) {
        if(file_exists($path))
        {
            return unlink($path);
        }
        return false;
    }

    /**
     * @param $fileId
     * @param $userId
     * @throws DeleteFileFailureException
     * @throws \Exception
     */
    public function deleteUploadedFile($fileId, $userId) {
        $this->userId = $userId;
        $this->fileId = $fileId;

        if (! $this->validate()) {
            throw new DeleteFileFailureException('Validation in UserFileForm was failed', $this->getErrors());
        }
        $rootPath = self::getUserPath($this->getUserId(), $this->getUploadRoot());
        $file = UserFileRecord::findOne(['id' => $fileId]);
        if(!$file->delete()) {
            throw new DeleteFileFailureException('UserFileRecord cant drop record');
        }
        $filePath = $rootPath .'/'. $file['file_name'];
        if(!$this->rmRealFile($filePath)) {
            throw new DeleteFileFailureException('Cant remove physical file '.$filePath);
        };
    }

    /**
     * @param $userId
     * @param $files UploadedFile|UploadedFile[]
     * @return array
     * @throws FolderCannotCreateException
     * @throws UploadFailureException
     */
    public function uploadFiles($userId, $files) {
        $this->userId = $userId;
        if (! $this->validate()) {
            throw new UploadFailureException("", $this->getErrors());
        }
        $path = self::getUserPath($userId, $this->getUploadRoot());
        if (!$this->requireFolder($path)) {
            throw new FolderCannotCreateException();
        };

        if( !is_array($files) || !isset($files[0])) {
            $files = [$files];
        }
        $results = [];
        for($i = 0, $size = count($files); $i < $size; $i++) {
            /** @var $file UploadedFile */
            $file = $files[$i];
            $results[] = $this->createFileRecord($file, $path);
        }
        return $results;
    }
}