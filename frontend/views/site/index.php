<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$this->registerJsFile("@web/js/fabric.min.js",['position'=> yii\web\View::POS_HEAD]);
$this->registerJsFile("@web/js/site.js",['depends'=> 'frontend\assets\AppAsset']);
?>
<style>
    #canvas {
        background: #413f46;
        border: solid 3px #141217;
    }
</style>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success dwn" href="#">dwn</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <canvas width="274px" height="547px" id="canvas"></canvas>
               </div>
        </div>

    </div>
</div>
