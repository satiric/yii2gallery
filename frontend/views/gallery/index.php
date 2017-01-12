<?php

/* @var $this yii\web\View */

$this->title = 'Gallery for Yourself';
$this->registerCssFile("/css/fileinput.min.css");

$this->registerJsFile('/js/gallery.js', ['depends' => 'frontend\assets\AppAsset']);
$this->registerJsFile('https://unpkg.com/vue/dist/vue.js', ['position'=>$this::POS_END]);
$this->registerJsFile('@web/js/plugins/canvas-to-blob.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('@web/js/plugins/sortable.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('@web/js/plugins/purify.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('@web/js/fileinput.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('@web/js/locales/ru.js',['depends'=>'frontend\assets\AppAsset']);

/**
 * @var $files object
 */
$encodedFiles = json_encode($files);
$js = <<<HEREDOC
var files = JSON.parse('$encodedFiles');
var uploadRoot = yiiConfig['userUploadLink'] || '';
HEREDOC;

$this->registerJs($js ,$this::POS_BEGIN);

?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-12 centred well well-lg">
                <h3>Your photos.</h3>
                <h4>Or not your.</h4>
                <h5> Of course, you found this photos in the Internet. </h5>
                <h6>Right?</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 centred">
                <img src="/images/watermark.png" class="watermark" /><br />
                <p class="badge">You can select more than one photo</p>

                <input id="input-44" name="inputsfile[]" type="file" multiple class="file-loading">
                <div id="errorBlock" class="help-block"></div>
            </div>
            <div class="col-lg-8 centred" id="imageTable">

                <table class="table table-hover" v-if="files.length != 0">
                    <thead>
                        <tr >
                            <th class="centred">Title</th>
                            <th class="centred">Image</th>
                            <th class="centred">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="file in files">
                            <td class="centred">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {{ file.title || file.file_name  }}
                                    </div>
                                </div>
                            </td>
                            <td style="width:30%;"><img :src="uploadRoot + '/' + file.file_name" class="img-responsive img-thumbnail" /></td>
                            <td class="centred">
                                <button class="btn btn-primary btn-sm" @click="showEditForm(file)" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#editImg">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </button>
                                <button class="btn btn-danger btn-sm remove-attr" @click="showRemoveForm(file.id, file.file_name)" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#removeImg">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="editImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="loader"></div>
                <img :src = "uploadRoot +'/' + file.file_name" class="img-responsive img-thumbnail"/>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" name="caption" @focusout="save(file.title)" v-model="file.title" placeholder="Here your title">
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="removeImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body centred">
                <div class="loader"></div>
                <p>You deleting this image: </p>
                <img :src = "img" class="img-responsive img-thumbnail"/>
                <p>Are you sure? </p>
                
                    <button class="btn btn-danger btn-sm" @click="removeImg(id)"  aria-haspopup="true" aria-expanded="false" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
                    </button>
                    <button class="btn btn-default btn-sm" aria-haspopup="true" aria-expanded="false" data-dismiss="modal">
                        Cancel
                    </button>
            </div>
        </div>
    </div>
</div>