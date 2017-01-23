/**
 * Created by decadal on 22.01.17.
 */

$(document).ready(function(){

    var canvas = new fabric.Canvas('canvas');
    var src = '/images/1.svg';

    var img = new Image();
    img.onload = function(){
        canvas.setBackgroundImage(img.src, canvas.renderAll.bind(canvas), {
            width: canvas.width,
            height: canvas.height,
            originX: 'left',
            originY: 'top',
            left: 0,
            top: 0
        });
    };
    img.src = "/images/25.png";


    fabric.util.loadImage(src, function(img) {
        var oImg = new fabric.Image(img);
        oImg.scale(0.2).set({
            left: 100,
            top: 100,
        });
        canvas.add(oImg);



        $('.dwn').click(function() {
            var file = canvas.toSVG(
                // Multiplier appears to accept decimals
                // width: '200mm',
                // height: '300mm'
            );
            window.location = '/site/svg?data=' + file;
        });
        // proceed();
        //$http.post('/postVendor', { filename: 'myfile.svg', file: file }).success(function (data) {...}
    });

});

