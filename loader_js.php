<link href="<?=_SPPATH;?>js/css/toastr.min.css" rel="stylesheet"/>
<script src="<?=_SPPATH;?>js/toastr.min.js"></script>
<script type="text/javascript">
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "1000",
    "hideDuration": "500",
    "timeOut": "500",
    "extendedTimeOut": "500",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
/*
 *  TOASTR FUNCTION
 * */
function ainfo(text){
    toastr.info(text);
}
function asuccess(text){
    toastr.success(text);
}
function awarning(text){
    toastr.warning(text);
}
function aerror(text){
    toastr.error(text);
}



function OnImageLoad(evt, sq) {


    var img = evt.currentTarget;


    // what's the size of this image and it's parent

    var w = img.width;

    var h = img.height;

    var tw = sq;

    var th = sq;


    // compute the new size and offsets

    var result = ScaleImage(w, h, tw, th, false);


    // adjust the image coordinates and size

    img.width = result.width;

    img.height = result.height;

    //alert(result.targetleft);

    img.style.marginLeft = result.targetleft + "px"

    img.style.marginTop = result.targettop + "px"

    // img.setStyle({left: result.targetleft});

    // img.setStyle({top: result.targettop});

}

function resizeAndJustify(id, sq) {


    var img = document.getElementById(id);


    // what's the size of this image and it's parent

    var w = img.width;

    var h = img.height;

    var tw = sq;

    var th = sq;


    // compute the new size and offsets

    var result = ScaleImage(w, h, tw, th, false);


    // adjust the image coordinates and size

    img.width = result.width;

    img.height = result.height;

    //alert(result.targetleft);

    img.style.marginLeft = result.targetleft + "px"

    img.style.marginTop = result.targettop + "px"

    // img.setStyle({left: result.targetleft});

    // img.setStyle({top: result.targettop});

}


function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {


    var result = {width: 0, height: 0, fScaleToTargetWidth: true};


    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {

        return result;

    }


    // scale to the target width

    var scaleX1 = targetwidth;

    var scaleY1 = (srcheight * targetwidth) / srcwidth;


    // scale to the target height

    var scaleX2 = (srcwidth * targetheight) / srcheight;

    var scaleY2 = targetheight;


    // now figure out which one we should use

    var fScaleOnWidth = (scaleX2 > targetwidth);

    if (fScaleOnWidth) {

        fScaleOnWidth = fLetterBox;

    }

    else {

        fScaleOnWidth = !fLetterBox;

    }


    if (fScaleOnWidth) {

        result.width = Math.floor(scaleX1);

        result.height = Math.floor(scaleY1);

        result.fScaleToTargetWidth = true;

    }

    else {

        result.width = Math.floor(scaleX2);

        result.height = Math.floor(scaleY2);

        result.fScaleToTargetWidth = false;

    }

    result.targetleft = Math.floor((targetwidth - result.width) / 2);

    result.targettop = Math.floor((targetheight - result.height) / 2);


    return result;

}

/*
 * pull content
 */
var w;
var anzahlInbox = 0;
var tstamp = 0;
var updateInbox = [];
var maxInboxID = [];

function pullContent2() {

    if (typeof(Worker) !== "undefined") {

        if (typeof(w) == "undefined") {

            w = new Worker("<?=_SPPATH;?>webworker.js");

        }
        // w.postMessage({'cmd': 'start', 'maxInboxID': maxInboxID});
        w.onmessage = function (event) {

            // var rres = event.data;
            var hasil = JSON.parse(event.data);
            var reload = 0;
            var mengecil = 0;
            console.log(hasil);

            var aa = parseInt(hasil.totalmsg);
            updateInbox = hasil.updateArr;
            var ts = parseInt(hasil.timestamp);
            if (tstamp != ts)reload = 1;
            tstamp = ts;

            //cek apakah mengurangi
            if (aa < anzahlInbox)mengecil = 1;
            anzahlInbox = aa;
            //$('oktop').fade().fade();

            //document.getElementById("content_utama").innerHTML = document.getElementById("content_utama").innerHTML+event.data;
            if (reload) {
                lwrefresh("Inbox");
                $('#jmlEnvBaru').html(aa);
                $("#envelopebaloon").html(aa);

                if (aa == 0) {
                    $("#envelopebaloon").hide();
                }
                else {
                    $("#envelopebaloon").fadeIn();
                }
                if (!mengecil) {
                    //update link diatas
                    $('#envelopeul').load('<?=_SPPATH;?>Inboxweb/fillEnvelope');
                    //update window chat..

                    var len = updateInbox.length;
                    for (key = 0; key < len; key++) {
                        var keyactual = "inboxView" + updateInbox[key];
                        //lwrefresh("inboxView"+updateInbox[key]);

                        // ambil id yang mungkin ada...
                        var len2 = all_lws.length;
                        for (key2 = 0; key2 < len2; key2++) {
                            if (keyactual == all_lws[key2].lid) {
                                // you got matched, no load needed
                                $('#chatInbox' + updateInbox[key]).load('<?=_SPPATH;?>Inboxweb/see?all=1&id=' + updateInbox[key]);
                                //all_lws[key].refreshe( all_lws[key].urls,all_lws[key].ani);
                                //return 1;
                            } else {
                                //hide all others
                                //all_lws[key].sendBack();
                            }
                        }
                    }

                }
            }


        };

    }

    else {
        console.log("Sorry, your browser does not support Web Workers...");
    }
}
/*
 * openMuridProfile
 */
function openProfile(mid) {
    //openLw('AccountProfile' + mid, '<?=_SPPATH;?>AccountLoginWeb/profile?acc_id=' + mid, 'fade');
    document.location='<?=_SPPATH."profile?id="; ?>'+mid;
}

function js_yyyy_mm_dd_hh_mm_ss() {
    now = new Date();
    year = "" + now.getFullYear();
    month = "" + (now.getMonth() + 1);
    if (month.length == 1) {
        month = "0" + month;
    }
    day = "" + now.getDate();
    if (day.length == 1) {
        day = "0" + day;
    }
    hour = "" + now.getHours();
    if (hour.length == 1) {
        hour = "0" + hour;
    }
    minute = "" + now.getMinutes();
    if (minute.length == 1) {
        minute = "0" + minute;
    }
    second = "" + now.getSeconds();
    if (second.length == 1) {
        second = "0" + second;
    }
    return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
}

function carousel_delete(pid) {
    $.get("<?=_SPPATH;?>CarouselWeb/carouselDelete?pid=" + pid, function (data) {
        lwrefresh("Carousel");
    });
}
function carousel_activate(pid) {
    $.get("<?=_SPPATH;?>CarouselWeb/carouselActivate?pid=" + pid, function (data) {
        lwrefresh("Carousel");
    });
}
function carousel_moveUp(pid) {
    $.get("<?=_SPPATH;?>CarouselWeb/carouselMoveUp?pid=" + pid, function (data) {
        lwrefresh("Carousel");
    });
}

function gallery_open(gid) {
    openLw("GalleryOpen", "<?=_SPPATH;?>GalleryWeb/galleryOpen?gid=" + gid, "fade");
}
function gallery_delete(gid) {
    $.get("<?=_SPPATH;?>GalleryWeb/galleryDelete?gid=" + gid, function (data) {
        lwrefresh("GalleryMenu");
    });
}
function gallery_deletephoto(pid) {
    $.get("<?=_SPPATH;?>GalleryWeb/pictureDelete?pid=" + pid, function (data) {
        lwrefresh("GalleryOpen");
    });
}

function gallery_setmainpic(pid, gid) {
    $.get("<?=_SPPATH;?>GalleryWeb/pictureSetMainPic?pid=" + pid + "&gid=" + gid, function (data) {
        lwrefresh("GalleryOpen");
        lwrefresh("GalleryMenu");

    });
}
function galleryUpdateName(gid) {
    var newname = $("#h1_" + gid).html();
    if (newname == "") {
        alert("<?=Lang::t("Please fill name");?>");
    } else {
        $.post("<?=_SPPATH;?>GalleryWeb/galleryUpdateName", {gid: gid, newname: newname}, function (data) {
            lwrefresh("GalleryMenu");
        });
    }
}
function galleryUpdateDes(gid) {
    var newname = $("#galdesc_" + gid).html();
    if (newname == "") {
        alert("<?=Lang::t("Please fill description");?>");
    } else {
        if (newname != "Click here to enter description") {
            $.post("<?=_SPPATH;?>GalleryWeb/galleryUpdateDes", {gid: gid, newname: newname}, function (data) {
                lwrefresh("GalleryMenu");
            });
        }
    }
}

function gallery_openpicture(pid, gid) {
    openLw("PictureOpen", "<?=_SPPATH;?>GalleryWeb/pictureOpen?gid=" + gid + "&pid=" + pid, "fade");
}

function galleryUpdateDesPic(pid) {
    var newname = $("#picdesc_" + pid).html();
    if (newname == "") {
        alert("<?=Lang::t("Please fill description");?>");
    } else {
        if (newname != "Click here to enter description") {
            $.post("<?=_SPPATH;?>GalleryWeb/galleryUpdateDesPic", {pid: pid, newname: newname}, function (data) {
                //lwrefresh("GalleryMenu");
            });
        }
    }
}

function files_delete(pid) {
    $.get("<?=_SPPATH;?>FilesWeb/filesDelete?pid=" + pid, function (data) {
        lwrefresh("Files");
    });
}


function ads_delete(pid) {
    $.get("<?=_SPPATH;?>AdsWeb/adsDelete?pid=" + pid, function (data) {
        lwrefresh("Ads");
    });
}
function ads_activate(pid) {
    $.get("<?=_SPPATH;?>AdsWeb/adsActivate?pid=" + pid, function (data) {
        lwrefresh("Ads");
    });
}
function ads_moveUp(pid) {
    $.get("<?=_SPPATH;?>AdsWeb/adsMoveUp?pid=" + pid, function (data) {
        lwrefresh("Ads");
    });
}

//new 22 agustus 2016
function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);

    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }

    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

function openInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}

//firebase
function refreshFirebase(id,cname,id_lwrefresh){

    $.post("<?=_SPPATH;?>FetchFirebase/refresh",{id:id,cname:cname},function(data){
        alert(data);
        lwrefresh(id_lwrefresh);
    });

}

function verifyEmployee(id,yob_id){
//check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/verifyEmployee",{id:id,thn:$('#'+yob_id).val()},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function unverifyEmployee(id){
//check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/unverifyEmployee",{id:id},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function suspendEmployee(id){
//check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/suspendEmployee",{id:id},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function unsuspendEmployee(id){
//check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/unsuspendEmployee",{id:id},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function sendPushEmployee(id){


//    openLw("sendPush"+id,"<?//=_SPPATH;?>//FetchFirebase/sendPushForm","fade");

    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else openLw("sendPush"+id,"<?=_SPPATH;?>FetchFirebase/sendPushForm?mode=ee&id="+id,"fade");
//    $.post("<?//=_SPPATH;?>//FetchFirebase/sendPushEmployee",{id:id},function(data){
//        alert(data);
//        lwrefresh(selected_page);
//    });
}

function addCredit(id){

//    openLw("sendPush"+id,"<?//=_SPPATH;?>//FetchFirebase/sendPushForm","fade");

    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else openLw("addCreditForm"+id,"<?=_SPPATH;?>FetchFirebase/addCreditForm?mode=ee&id="+id,"fade");
//    $.post("<?//=_SPPATH;?>//FetchFirebase/sendPushEmployee",{id:id},function(data){
//        alert(data);
//        lwrefresh(selected_page);
//    });
}



function suspendEmployer(id){

    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/suspendEmployer",{id:id},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function unsuspendEmployer(id){
//check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/unsuspendEmployer",{id:id},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function sendPushEmployer(id){
    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else openLw("sendPush"+id,"<?=_SPPATH;?>FetchFirebase/sendPushForm?mode=er&id="+id,"fade");
//    $.post("<?//=_SPPATH;?>//FetchFirebase/sendPushEmployer",{id:id},function(data){
//        alert(data);
//        lwrefresh(selected_page);
//    });
}


function tidakLengkapEe(id){
    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/tidakLengkapEmployee",{id:id},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function deleteUser(id){
    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
        $.post("<?=_SPPATH;?>FetchFirebase/deleteUser",{id:id},function(data){
            alert(data);
            lwrefresh(selected_page);
        });
}

function setYOB(id,id_input){
    //check ID kl kosong jangan lanjut
    if(id == '')alert("No ID defined");
    else
    $.post("<?=_SPPATH;?>FetchFirebase/isiYOB",{id:id,thn:$('#'+id_input).val()},function(data){
        alert(data);
        lwrefresh(selected_page);
    });
}

function setAlasanReport(job_id,id_input,status){
    //check ID kl kosong jangan lanjut
    if(job_id == '')alert("No ID defined");
    else
        $.post("<?=_SPPATH;?>FetchFirebase/setAlasanReport",{job_id:job_id,alasan:$('#'+id_input).val(),status:status},function(data){
            alert(data);
            lwrefresh(selected_page);
        });
}


function imgError(image) {
    console.log("on error");
    image.onerror = "";
    image.src = "<?=_SPPATH;?>images/noimage.jpg";
    return true;
}

</script><?php

/* 
 * Leap System eLearning
 * Each line should be prefixed with  * 
 */

