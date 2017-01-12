/**
 * Created by decadal on 11.01.17.
 */

// REQUIRED loadedFile EVENT variable
// REQUIRED: files variable

if ( typeof files !== 'undefined' ) {
    if (files.length == 0) {
        files = {};//cause - bad rendering Vuejs
    }
} else {
    var files = {};
}

var loadedFile = new Event('loaded');
var uploadRoot = uploadRoot || 'images/2';

document.addEventListener('loaded', function () {
//if needed catch loaded file
}, false);

function createFileInput(id, app) {
    var id = id || "#input-44";
    $( id ).fileinput({
        language : 'en',
        'allowedFileExtensions' : ['jpg', 'jpeg', 'png','gif'],
        uploadUrl: '/gallery/load-file', //todo make point for load
        maxFilePreviewSize: 10240,

    });
    $(id).on('fileuploaded', function(event, data, previewId, index) {
        var resp = data.response.data;

        for (var idFile in resp) {

            if(!resp.hasOwnProperty(idFile)) {
                continue;
            }
            Vue.set(app.files, idFile, resp[idFile]);
        }
        $("#input-44").fileinput("disable").fileinput("refresh");
        $("#input-44").fileinput("enable").fileinput("refresh");
        document.dispatchEvent(loadedFile);
    });

}

$(document).ready(function(){

//todo make as components
    var rmImagePopup = new Vue({
        el: '#removeImg',
        data: {
            img: '',
            id: '',
            uploadRoot: uploadRoot
        },
        methods: {
            removeImg: function (id) {
                $.ajax({
                    method: 'POST',
                    url: '/gallery/delete-file/'+id,
                    success: function() {
                        appImages.$delete(files, id);
                    }
                });
            }
        }
    });

    var editImagePopup = new Vue({
        el: '#editImg',
        data: {
            file: {
                'id': '',
                'file_name': '',
                'title': ''
            },
            uploadRoot: uploadRoot
        },
        methods: {
            save : function (title) {
                $.ajax({
                    method: 'POST',
                    data: {
                        'title' : title
                    },
                    url: '/gallery/update-file/'+this.file.id,
                });
            }

        }
    });
    var appImages = new Vue({
        el: '#imageTable',
        data: {
            files: files,
            uploadRoot: uploadRoot
        },
        methods: {
            showRemoveForm: function (id, fileName) {
                rmImagePopup.id = id;
                rmImagePopup.img = uploadRoot + '/' + fileName
            },
            showEditForm: function (file) {
                editImagePopup.file = file;
            }
        }
    });


    createFileInput("#input-44", appImages);

});