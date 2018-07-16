/*
 fileName: area.js
 description: process Tourist Area
 */

// Code included inside $( document ).ready() will only run once the page Document Object Model (DOM) is ready for JavaScript code to execute

var uploadCrop;
$(document).ready(function () {

    uploadCrop = $("#listing-upload1").croppie({
        enableExif: true,
        viewport: {
            width: 640,
            height: 100,
            type: 'rectangle'
        },
        boundary: {
            width: 700,
            height: 150
        }
    });
});

$('#business-listing-img').on('change', function () {
    var reader = new FileReader();
    var type = this.files[0]['type'];
    // if (type != 'image/png' && type != 'image/jpeg') {
    //     alert("图片格式错误，要求是jpg、jpeg、png格式。");
    //     return;
    // }
    reader.onload = function (e) {
        uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
            refreshListingImg();
        });
    };
    reader.readAsDataURL(this.files[0]);
});

$('#listing-upload1').on('mouseup', function () {
    refreshListingImg();
});

function refreshListingImg() {
    uploadCrop.croppie('result', {
        type: 'canvas',
        size: {
            width: 1920,
            height: 300
            }
    }).then(function (resp) {
        html = '<img id="listing-uploaded-data" src="' + resp + '" style="width:100%px; height:auto; "/>';
        $("#listingupload").html(html);
    });
}
$('#listing-upload-complete').on('click', function () {
    var data = $("#listing-uploaded-data").attr('src');
    // if (data == undefined) {
    //     alert("请选择图片并裁剪.");
    //     return;
    // }
    $('#imageDataUploading1').val(data);
    document.getElementById("business_listing_img_show").src = data;
    $('.mfp-close').trigger('click');
    // $("#business_listing_img_dialog").removeClass('fade').modal('hide')
    // document.getElementById("myupload").src = data;

});

// Main Image Upload
var uploadCropMain;
$(document).ready(function () {

    uploadCropMain = $("#main-upload1").croppie({
        enableExif: true,
        viewport: {
            width: 468,
            height: 265,
            type: 'rectangle'
        },
        boundary: {
            width: 500,
            height: 300
        }
    });
});

$('#business-main-img').on('change', function () {
    var reader = new FileReader();
    var type = this.files[0]['type'];
    // if (type != 'image/png' && type != 'image/jpeg') {
    //     alert("图片格式错误，要求是jpg、jpeg、png格式。");
    //     return;
    // }
    reader.onload = function (e) {
        uploadCropMain.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
            refreshTargetImg();
        });

    };
    reader.readAsDataURL(this.files[0]);
});

$('#main-upload1').on('mouseup', function () {
    refreshTargetImg();
});

function refreshTargetImg() {
    uploadCropMain.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        html = '<img id="uploaded-data" src="' + resp + '" style="width:100%; height:100%; "/>';
        $("#mainupload").html(html);
    });
}
$('#upload-complete-main').on('click', function () {
    var data = $("#uploaded-data").attr('src');
    // if (data == undefined) {
    //     alert("请选择图片并裁剪.");
    //     return;
    // }
    $('#imageDataUploading').val(data);
    document.getElementById("business_main_img_show").src = data;
    $('.mfp-close').trigger('click');
    // $("#business_listing_img_dialog").removeClass('fade').modal('hide')
    // document.getElementById("myupload").src = data;

});