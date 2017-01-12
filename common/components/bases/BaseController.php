<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 11.01.17
 * Time: 16:59
 */

namespace common\components\bases;
use yii;

/**
 * Class BaseController
 * @package common\components\bases
 */
abstract class BaseController extends \yii\web\Controller
{
    const POINT_ENTRY = '/site/login';

    /**
     * @var $jsConfig array with data for transfer to view
     */
    public $jsConfig = [];

    /**
     * @inheritdoc
     */
    public function __construct($id, yii\base\Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        // subscribe to event for transfer data from jsConfig to View params when View is rendering
        $this->view->on( yii\web\View::EVENT_BEFORE_RENDER, [$this,"exportToViewParams"] );
    }

    /** 
     * @param $route string|array
     * @return $this
     */
    protected function redirectTo($route)
    {
        return Yii::$app->getResponse()->redirect($route);
    }
    
    /**
     * procedure to set response headers for allow any origin
     */
    protected function allowAllOrigins()
    {
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
    }

    /**
     * @return $this redirect to login page.
     */
    protected function goLogin()
    {
        return $this->redirectTo(self::POINT_ENTRY);
    }

    /**
     * set format for ajax request, procedure
     */
    protected function returnFormatJson()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /** 
     * @return bool|mixed
     */
    protected function isAjax() {
        return Yii::$app->request->isAjax;
    }

    /** return array with states like status and data, for json response
     * @param $status
     * @param array $data
     * @param null $code
     * @return array
     */
    protected function jsonResponseObj($status, $data = [], $code = null) {
        $this->returnFormatJson();
        return [
            'status' => $status, 
            'code' => $code,
            'data' => $data
        ];
    }

    /** like jsonResponseObj, but with "error" binding
     * @param $msg
     * @param array $errors
     * @param string $status
     * @return array
     */
    protected function jsonBadResponseObj($msg, $errors = [], $status = "error") {
        return $this->jsonResponseObj($status, [
            'message' => $msg,
            'errors' => $errors
        ], 500);
    }

    /**
     * function was binding to BEFORE_RENDER_EVENT and set parameters to view
     */
    protected function exportToViewParams()
    {
        $this->view->params['jsConfig'] = $this->jsConfig;
    }
}