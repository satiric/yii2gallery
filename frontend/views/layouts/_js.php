<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.04.16
 * Time: 18:15
 */

$gClientId = isset(Yii::$app->params["googleClientID"])
    ? Yii::$app->params["googleClientID"]
    : '';
$gApiKey = isset(Yii::$app->params["googleAPIKey"])
    ? Yii::$app->params["googleAPIKey"]
    : '';
?>

<script type="text/javascript">
        var GOOGLE_CLIENT_ID = '<?=$gClientId?>',
            GOOGLE_API_KEY = '<?=$gApiKey?>';
        var yiiConfig = <?= (isset($jsConfig) && $jsConfig &&(!empty($jsConfig))) ? yii\helpers\Json::encode($jsConfig) : '{}' ?>,
            apiPoint = (typeof yiiConfig["apiUrl"] !== 'undefined') ? yiiConfig["apiUrl"] : '';
</script>