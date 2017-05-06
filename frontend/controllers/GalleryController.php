<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 11.01.17
 * Time: 16:57
 */

namespace frontend\controllers;

use common\components\bases\BaseController;
use common\components\bases\BaseException;
use common\components\exceptions\DeleteFileFailureException;
use common\traits\SimpleYiiTrait;
use frontend\models\UserFileRecord;
use frontend\models\UserFileForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * Class GalleryController
 * @package frontend\controllers
 */
class GalleryController extends BaseController
{
    use SimpleYiiTrait;

    /**
     * GalleryController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, \yii\base\Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        //regist link to user uploading root folder
        $this->jsConfig['userUploadLink'] = \yii\helpers\Url::base(true). '/images/'.$this->getUserId();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'load-file' => ['post'],
                    'delete-file' => ['post'],
                    'update-file' => ['post']
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $files = UserFileRecord::find()
            ->where(['user_id' => $this->getUserId()])
            ->asArray()
            ->all();
        return $this->render('index', [
            // result of mapping: [  $id => [ 'file_name' => $file_name, ... ]  ]
            'files' => $this->mapDataArray($files)
        ]);
    }
    
    /**
     * @return array
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLoadFile()
    {
        if( !$this->isAjax() ) {
            throw new NotFoundHttpException();
        }
        $userId = $this->getUserId();
        $preparedFiles = UploadedFile::getInstancesByName(UserFileForm::FORM_NAME);
        try  {
            //get file object as array with id, file_name etc. 
            $files = (new UserFileForm())->uploadFiles($userId, $preparedFiles);
        }
        catch (BaseException $e) {
            return $this->jsonBadResponseObj($e->getMessage(), $e->getErrors());
        }
        return $this->jsonResponseObj("success", $this->mapDataArray($files) );
    }
    
    /**
     * @param $id
     * @return array
     * @throws DeleteFileFailureException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteFile($id)
    {
        if( !$this->isAjax() ) {
            throw new NotFoundHttpException();
        }
        $userId = $this->getUserId();
        try {
            (new UserFileForm())->deleteUploadedFile($id, $userId);
        }
        catch (BaseException $e) {
            return $this->jsonBadResponseObj($e->getMessage(), $e->getErrors());
        }
        return $this->jsonResponseObj("success");
    }


    /**
     * @param $id
     * @return array
     * @throws DeleteFileFailureException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdateFile($id)
    {
        if( !$this->isAjax() ) {
            throw new NotFoundHttpException();
        }
        $userId = $this->getUserId();
        $file = UserFileRecord::findOne(['id' => $id, 'user_id' => $userId]);
        if(!$file) {
            $this->jsonBadResponseObj("Record not found");
        }
        $file->title = \Yii::$app->request->post('title');
        return ($file->save())
            ? $this->jsonResponseObj("success")
            : $this->jsonBadResponseObj("Cannot save record", $file->getErrors());
    }
}