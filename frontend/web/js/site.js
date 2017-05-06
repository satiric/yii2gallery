/**
 * Created by decadal on 22.01.17.
 */

// $(document).ready(function(){
//     var canvas = new fabric.Canvas('canvas');
//     var bgFabric;
//     var imgFabric;
//
//     var src = '';
//     fabric.util.loadImage(src, function(img) {
//         bgFabric = new fabric.Image(img);
//         canvas.setBackgroundImage(img.src, canvas.renderAll.bind(canvas), {
//             width: canvas.width,
//             height: canvas.height,
//             originX: 'left',
//             originY: 'top',
//             left: 0,
//             top: 0
//         });
//     });
//
//     src = '';
//     fabric.util.loadImage(src, function(img) {
//         imgFabric = new fabric.Image(img);
//         imgFabric.set({
//             left: 100,
//             top: 100,
//         });
//         canvas.add(imgFabric);
//     });
//
//     $('.dwn').click(function() {
//         var koefH = canvas.height;
//         var koefW = canvas.width;
//         canvas.setWidth(767);
//         canvas.setHeight(1654);
//         imgFabric.set({
//             left: imgFabric.left * (canvas.width / koefW),
//             top: imgFabric.top * (canvas.height / koefH),
//             width: imgFabric.width * (canvas.width / koefW),
//             height: imgFabric.height * (canvas.height / koefH),
//         });
//         canvas.clear();
//         canvas.add(imgFabric);
//         $.post(canvas.toDataURL('png'))
//         // window.open();
//     });
//
// });

