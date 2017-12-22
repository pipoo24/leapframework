<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/16/17
 * Time: 10:24 AM
 */
use Google\Cloud\Storage\StorageClient;

class CrudPublisher extends WebService{

    function publishTofirebasejson(){

//        ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
        $model = addslashes($_REQUEST['cname']);

        $obj = new $model();
        $mainid = $obj->main_id;
//        echo $mainid;
        $syarat = $obj->publish_constraint;

//        pr($syarat);

        if($syarat['where']=="")
            $arr = $obj->getAll("","","*");
        else{
            $arr = $obj->getWhere($syarat['where']);
        }





        //pr($arr);
        $arr2 = Crud::clean2print($obj,$arr,0);
        $exp = explode(",",$obj->crud_webservice_allowed);

//        pr($arr2);
        $arrnew = array();
        foreach($arr2 as $new){
//            echo $new[$mainid];

            foreach($exp as $attr){
                if(is_numeric($new[$attr])){
//                    echo "numeric2  ";
                    $int = doubleval($new[$attr]);
                    $new[$attr] = $int;
//                    echo $attr.": ".$int."   xx<br>";
//                    $new['xx'] = 5;
                }else{
                    $new[$attr] = utf8_encode($new[$attr]);
                }
            }
            $arrnew[$new[$mainid]] = $new;
        }


        if($obj->urutan != ""){
            list($colom,$arah) = explode(",",$obj->urutan);

            if($arah == "ASC") {
                $arrnew2 = array();
                foreach ($arrnew as $key => $val) {
                    $arrnew2[$val[$colom]] = $val;
                }
            }
            else{
                $arrnew2 = array();
                foreach ($arrnew as $key => $val) {
                    $arrnew2["-".$val[$colom]] = $val;
                }
            }
            $arrnew = $arrnew2;
        }
//        pr($arrnew);



        $lokasi_model = "published/".$model.".json";


        $lp = new LeapFirebase();
        $del = $lp->delete($lokasi_model);



        if($del == "null") {
            $ret = json_decode($lp->patch($lokasi_model, $arrnew));

//            pr($ret);
            if($ret->error!=""){
                $json['status_code'] = 0;
                $json['status_message'] = $ret->error;
//                pr($lokasi_model);
//                pr($arrnew);
            }else {

//            $this->publishToElastic();

//
                if (count($ret) > 0) {
                    $json['status_code'] = 1;
                    $json['status_message'] = "Publish Successful";

                } else {
                    $json['status_code'] = 0;
                    $json['status_message'] = "Publish Failed on Update";

                }
            }

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Publish Failed on Delete";

        }

        echo json_encode($json);
        die();
    }


    function publishTofirebase(){

        $model = addslashes($_REQUEST['cname']);

        $obj = new $model();
        $mainid = $obj->main_id;
//        echo $mainid;
        $syarat = $obj->publish_constraint;

//        pr($syarat);

        if($syarat['where']=="")
            $arr = $obj->getAll();
        else{
            $arr = $obj->getWhere($syarat['where']);
        }





        //pr($arr);
        $arr2 = Crud::clean2print($obj,$arr);

//        pr($arr2);
        $arrnew = array();
        foreach($arr2 as $new){
//            echo $new[$mainid];
            $arrnew[$new[$mainid]] = $new;

        }

//        pr($arrnew);






        $lp = new LeapFirebase();
        $del = $lp->delete($model.".json");



        if($del == "null") {
            $ret = $lp->patch($model . ".json", $arrnew);

//            pr($ret);

//            $this->publishToElastic();

//
            if(count($ret)>0)
                echo " item sukses diupload";
            else
                echo "gagal update";

        }else{
            echo "failed by deleting";
        }

    }
    function uploadtoFirebase(){

        ///
        //client ID 906502449495-hui10ilv3b084udhudschkgtoqnqq7dq.apps.googleusercontent.com
//client secret RKPmNRDUQc3xeZw6WsMXyAxW

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $url = "79a156ab7255950c62a650ab81d0bb2f.jpg";

        # Includes the autoloader for libraries installed with composer
//        require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library


# Your Google Cloud Platform project ID
        $projectId = 'catalyst-176107';

# Instantiates a client
        $storage = new StorageClient([
            'projectId' => $projectId
        ]);


# The name for the new bucket
        $bucketName = 'gs://catalyst-5a033.appspot.com/my-new-bucket';

# Creates the new bucket
        $bucket = $storage->createBucket($bucketName);

        echo 'Bucket ' . $bucket->name() . ' created.';
    }

    function uploadJS(){

        $url = "79a156ab7255950c62a650ab81d0bb2f.jpg";


        $path = _PHOTOPATH.$url;

        echo $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


        $b = base64_encode("https://www.famousbirthdays.com/headshots/gal-gadot-4.jpg");
        $b = base64_encode($data);
        ?>
        <html>
        <head>

            <script src="https://www.gstatic.com/firebasejs/4.2.0/firebase.js"></script>
            <script>
                // Initialize Firebase
                var config = {
                    apiKey: "AIzaSyCYo4707kBEccR6QX4Pk3kAzJ-hQ4o-Du8",
                    authDomain: "catalyst-5a033.firebaseapp.com",
                    databaseURL: "https://catalyst-5a033.firebaseio.com",
                    projectId: "catalyst-5a033",
                    storageBucket: "catalyst-5a033.appspot.com",
                    messagingSenderId: "168482730778"
                };
                firebase.initializeApp(config);
                // Get a reference to the storage service, which is used to create references in your storage bucket
                var storage = firebase.storage();

                // Create a storage reference from our storage service
                var storageRef = storage.ref();
                // Create a child reference
                var imagesRef = storageRef.child('images/halo1.jpg');
                // imagesRef now points to 'images'

                // Data URL string
                var message = '<?=$b;?>';
//                imagesRef.putString(message, 'base64').then(function(snapshot) {
//                    console.log('Uploaded a data_url string!');
//
//                });



                // Upload file and metadata to the object 'images/mountains.jpg'
                var uploadTask = imagesRef.putString(message, 'base64');

                // Listen for state changes, errors, and completion of the upload.
                uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
                    function(snapshot) {
                        // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        console.log('Upload is ' + progress + '% done');
                        switch (snapshot.state) {
                            case firebase.storage.TaskState.PAUSED: // or 'paused'
                                console.log('Upload is paused');
                                break;
                            case firebase.storage.TaskState.RUNNING: // or 'running'
                                console.log('Upload is running');
                                break;
                        }
                    }, function(error) {

                        // A full list of error codes is available at
                        // https://firebase.google.com/docs/storage/web/handle-errors
                        switch (error.code) {
                            case 'storage/unauthorized':
                                // User doesn't have permission to access the object
                                break;

                            case 'storage/canceled':
                                // User canceled the upload
                                break;



                                case 'storage/unknown':
                                // Unknown error occurred, inspect error.serverResponse
                                break;
                        }
                    }, function() {
                        // Upload completed successfully, now we can get the download URL
                        var downloadURL = uploadTask.snapshot.downloadURL;
                        alert(downloadURL);
                    });

            </script>


        </head>
        <body>
<?=$b;?>

        <img src="https://firebasestorage.googleapis.com/v0/b/catalyst-5a033.appspot.com/o/images%2Fhalo1.jpg?alt=media&token=0ada6340-7607-4661-abd3-7782ab02b36b">
        </body>
        </html>

        <?

    }



    function UploadJS2(){


        $model = addslashes($_REQUEST['cname']);

        $obj = new $model();
        $mainid = $obj->main_id;
//        echo $mainid;
        $syarat = $obj->publish_constraint;

//        pr($syarat);

        if($syarat['where']=="")
            $arr = $obj->getAll();
        else{
            $arr = $obj->getWhere($syarat['where']);
        }


        if(count($arr)<1){
            ?>
            <script>
                alert("Nothing to publish, make sure element is activated");
                window.close();
            </script>
            <?
        }
        ?>
        <html>
        <head>
            <title>Publish</title>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

            <!-- jQuery library -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

            <!-- Latest compiled JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <?=LeapFirebase::getWebSetup();?>

            <script>

                // Get a reference to the storage service, which is used to create references in your storage bucket
                var storage = firebase.storage();

                // Create a storage reference from our storage service
                var storageRef = storage.ref();
                // Create a child reference



                firebase.auth().signInAnonymously().catch(function(error) {
                    // Handle Errors here.
                    var errorCode = error.code;
                    var errorMessage = error.message;
                    // ...
                    console.log(errorCode+' '+errorMessage);
                });
            </script>
            <style>
                .foto100 {
                    width: 80px;
                    height: 80px;
                    overflow: hidden;
                }

                .foto100 img {
                    width: 100%;
                }
            </style>

        </head>
        <body>

        <div class="container">
            <? if(count($syarat['photo'])<1 && count($syarat['gallery'])<1){
                ?>

                <div class="container" style="text-align: center; margin-top: 100px; margin-bottom: 100px;">
                    <h3>Please wait while publish..</h3>
                    <div id="loadingDiv">
                        <img src="<?=_SPPATH;?>images/tbs-hor-ajax-loader.gif">
                    </div>

                </div>
                <script>
                    $(document).ready(function(){
                        updatefirebase();
                    });
                </script>

            <?}else{



            ?>

            <div class="container" style="text-align: center; ">
                <h3>Upload Files For <?=Lang::t($model);?></h3>
                <h5>Please wait while uploading files..</h5>
                <div id="loadingDiv2">
                    <img src="<?=_SPPATH;?>images/tbs-hor-ajax-loader.gif">
                </div>
                <h5>After upload finished, make sure all images uploaded, click the "Publish To User" button below</h5>
            </div>

            <?
            if(count($syarat['gallery'])>0){

                $this->kerjakanGallery($obj,$arr,$mainid,$syarat,$model);
            }

            if(count($syarat['photo'])>0){

                $this->kerjakanPhotos($obj,$arr,$mainid,$syarat,$model);
            }
            ?>

            <div style="text-align: center; margin-top: 50px; margin-bottom: 100px; ">
            <button id="upload" style="display: none;font-size: 30px;" class="btn btn-large btn-danger">
                Publish To User
            </button>
                <div id="loadingDiv">
                    <img src="<?=_SPPATH;?>images/tbs-hor-ajax-loader.gif">
                </div>
            </div>

            <script>
                var $loading = $('#loadingDiv').hide();
                $(document)
                    .ajaxStart(function () {
                        $loading.show();
                    })
                    .ajaxStop(function () {
                        $loading.hide();
                    });
            </script>
        </div>


        <script>
            $('#upload').click(function(){
                $('#upload').prop('disabled', true);
                updatefirebase();
            });
        </script>
            <? } ?>

        <script>
            function updatefirebase(){
                $.post("<?=_SPPATH;?>CrudPublisher/publishTofirebasejson",{cname:"<?=$model;?>"},function(data){
                    alert(data.status_message);
                    $('#upload').prop('disabled', false);
                    if(data.status_code){
                        window.close();
                    }

                },'json');

            }
        </script>
        </body>
        </html>
        <?
    }

    function kerjakanPhotos($obj,$arr,$mainid,$syarat,$model){
        ?>
        <b>Upload Pictures</b>
        <table width="100%" class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>Object ID</th>
                <th>Progress</th>
            </tr>
            </thead>

        <? foreach($arr as $n=>$obj){?>
            <tr id="wadah_<?=$n;?>">
                <td>
                    <?=$obj->$mainid;?>
                </td>
                <td>
                    <?if(count($syarat['photo'])>0){
                        foreach($syarat['photo'] as $colom){
                            $url = $obj->$colom;
                            if($url=="")continue;
                            ?>
                            <div class="col-md-3">
                                <div id="path_<?=$n;?>_<?=$colom;?>" class="foto_100"></div>
                                <div id="status_<?=$n;?>_<?=$colom;?>"></div>
                            </div>
                        <? }} ?>
                    <div class="clearfix"></div>
                </td>

            </tr>
        <? } ?>
        </table>

            <script>

                function uploadkan(url,b,id,clm,n,flag_selesai){

                    var imagesRef = storageRef.child('images/'+url);
                    // imagesRef now points to 'images'

                    // Data URL string
                    var message = b;
                    //                imagesRef.putString(message, 'base64').then(function(snapshot) {
                    //                    console.log('Uploaded a data_url string!');
                    //
                    //                });



                    // Upload file and metadata to the object 'images/mountains.jpg'
                    var uploadTask = imagesRef.putString(message, 'base64');

                    // Listen for state changes, errors, and completion of the upload.
                    uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
                        function(snapshot) {
                            // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                            var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                            console.log('Upload is ' + progress + '% done');
                            var x = document.getElementById("status_"+n+'_'+clm);
                            x.innerHTML =  progress + '% done';
                            switch (snapshot.state) {
                                case firebase.storage.TaskState.PAUSED: // or 'paused'
                                    console.log('Upload is paused');
                                    break;
                                case firebase.storage.TaskState.RUNNING: // or 'running'
                                    console.log('Upload is running');
                                    break;
                            }
                        }, function(error) {

                            // A full list of error codes is available at
                            // https://firebase.google.com/docs/storage/web/handle-errors
                            switch (error.code) {
                                case 'storage/unauthorized':
                                    // User doesn't have permission to access the object
                                    break;

                                case 'storage/canceled':
                                    // User canceled the upload
                                    break;



                                case 'storage/unknown':
                                    // Unknown error occurred, inspect error.serverResponse
                                    break;
                            }
                        }, function() {
                            // Upload completed successfully, now we can get the download URL
                            var downloadURL = uploadTask.snapshot.downloadURL;
//                        alert(downloadURL);

                            $('#path_'+n+'_'+clm).html("<img src='"+downloadURL+"' width='200px'>");

                            $.get("<?=_SPPATH;?>CrudPublisher/updatePhotopath?add_firebase=1&cname=<?=$model;?>&id="+id+"&clm="+clm+"&path="+btoa(downloadURL),function(data){

                                console.log(data);
                                if(flag_selesai) {
                                    $('#upload').show();
                                    $('#loadingDiv2').hide();
                                }

                            },'json');



                        });
                }

                var flag_selesai = 0;
                <?
                $yangadafoto = array();
                foreach($arr as $n=>$obj){

                if(count($syarat['photo'])>0){

                        foreach($syarat['photo'] as $colom){
                            $url = $obj->$colom;
                            if($url=="")continue;
                            $yangadafoto[] = $obj;
                        }
                        }
                        }?>
                <? foreach($yangadafoto as $n=>$obj){

                if(count($syarat['photo'])>0){
                        foreach($syarat['photo'] as $colom){

                        $url = $obj->$colom;
                        if($url=="")continue;

                        $path = _PHOTOPATH.$url;
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $b = base64_encode($data);

                        $id = $obj->$mainid;
                        ?>
                <?  if($n==count($yangadafoto)-1){?>
                flag_selesai = 1;
                <? }?>

                uploadkan("<?=$url;?>","<?=$b;?>","<?=$id;?>","<?=$colom;?>","<?=$n;?>",flag_selesai);


                <? }}} ?>
            </script>
            <?
    }
    function kerjakanGallery($obj,$arr,$mainid,$syarat,$model){



        ?>
        <b>Upload Galleries</b>
        <table width="100%" class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>Object ID</th>
                <th>Progress</th>
            </tr>
            </thead>

            <? foreach($arr as $n=>$obj){?>
                <tr id="wadah_<?=$n;?>">
                    <td>
                        <?=$obj->$mainid;?>
                    </td>
                    <td>
                        <?if(count($syarat['gallery'])>0){
                            foreach($syarat['gallery'] as $colom){
                                $url = $obj->$colom;
//                                $exp = explode(",",$url);
                                if($url=="")continue;
                                $exp = array_unique(explode(",",$url));

                                ?>
                                <input type="hidden" id="input_<?=$n;?>_<?=$colom;?>">
                                <?
                                foreach($exp as $m=>$e){
                                    $info = pathinfo($e);
                                    $file_name =  basename($e,'.'.$info['extension']);
                                    $m = $file_name;
                                ?>
                                <div class="col-md-3">
                                    <div id="path_<?=$n;?>_<?=$m;?>_<?=$colom;?>" class="foto_100"></div>
                                    <div id="status_<?=$n;?>_<?=$m;?>_<?=$colom;?>"></div>

                                </div>
                            <? }}} ?>
                        <div class="clearfix"></div>
                    </td>

                </tr>
            <? } ?>
        </table>

        <script>

            function uploadkan2(url,b,id,clm,n,flag_selesai,mko,filename_asli){

                var imagesRef = storageRef.child('gallery/'+url);
                // imagesRef now points to 'images'

                // Data URL string
                var message = b;
                //                imagesRef.putString(message, 'base64').then(function(snapshot) {
                //                    console.log('Uploaded a data_url string!');
                //
                //                });



                // Upload file and metadata to the object 'images/mountains.jpg'
                var uploadTask = imagesRef.putString(message, 'base64');

                // Listen for state changes, errors, and completion of the upload.
                uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
                    function(snapshot) {
                        // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        console.log('Upload is ' + progress + '% done');
                        var x = document.getElementById("status_"+n+'_'+mko+'_'+clm);
                        x.innerHTML =  progress + '% done';
                        switch (snapshot.state) {
                            case firebase.storage.TaskState.PAUSED: // or 'paused'
                                console.log('Upload is paused');
                                break;
                            case firebase.storage.TaskState.RUNNING: // or 'running'
                                console.log('Upload is running');
                                break;
                        }
                    }, function(error) {

                        // A full list of error codes is available at
                        // https://firebase.google.com/docs/storage/web/handle-errors
                        switch (error.code) {
                            case 'storage/unauthorized':
                                // User doesn't have permission to access the object
                                break;

                            case 'storage/canceled':
                                // User canceled the upload
                                break;



                            case 'storage/unknown':
                                // Unknown error occurred, inspect error.serverResponse
                                break;
                        }
                    }, function() {
                        // Upload completed successfully, now we can get the download URL
                        var downloadURL = uploadTask.snapshot.downloadURL;
//                        console.log(downloadURL);
                        console.log(n+'_'+mko+'_'+clm+'  '+downloadURL);
//                        alert(downloadURL);

                        $('#path_'+n+'_'+mko+'_'+clm).html("<img src='"+downloadURL+"' width='200px'>");
                        var xx = $('#input_'+n+'_'+clm).val();
                        if(xx!='')xx += '|';
                        var gab = filename_asli+","+downloadURL;
                        $('#input_'+n+'_'+clm).val(xx+gab);

                        $.get("<?=_SPPATH;?>CrudPublisher/updateGallerypath?add_firebase=1&cname=<?=$model;?>&fname="+filename_asli+"&id="+id+"&clm="+clm+"&path="+btoa(downloadURL),function(data){
//
//                            console.log(data);
                            if(flag_selesai) {
                                $('#upload').show();
                                $('#loadingDiv2').hide();
                            }
//
                        },'json');



                    });
            }

            var flag_selesai = 0;
            <?
            $yangadafoto = array();
            foreach($arr as $n=>$obj){

            if(count($syarat['gallery'])>0){

                    foreach($syarat['gallery'] as $colom){
                        $url = $obj->$colom;
                        if($url=="")continue;
                        $yangadafoto[] = $obj;
                    }
                    }
                    }?>
            <? foreach($yangadafoto as $n=>$obj){

            if(count($syarat['gallery'])>0){
                    foreach($syarat['gallery'] as $colom){

                    $url = $obj->$colom;
                    if($url=="")continue;

                    $exp = array_unique(explode(",",$url));

                    foreach($exp as $m=>$e){
                                $url = $e;
                                $info = pathinfo($e);
                                    $file_name =  basename($e,'.'.$info['extension']);
                                    $ms = $file_name;
                                    $fname = basename($e);

$dc = new InputFileModel();
$uploaddir = $dc->upload_location;

                    $path = $uploaddir.$url;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $b = base64_encode($data);

                    $id = $obj->$mainid;
                    ?>
            <?  if($n==count($yangadafoto)-1&&$m==count($exp)-1){?>
            flag_selesai = 1;
            <? }?>
            console.log("<?=$path;?>");
            uploadkan2("<?=$url;?>","<?=$b;?>","<?=$id;?>","<?=$colom;?>","<?=$n;?>",flag_selesai,"<?=$ms;?>","<?=$fname;?>");


            <? }}}} ?>
        </script>

        <?
    }

    function updatePhotopath(){
        $model = addslashes($_REQUEST['cname']);
        $id = addslashes($_REQUEST['id']);
        $path = base64_decode(addslashes($_REQUEST['path']));
        $clm = addslashes($_REQUEST['clm']);

        if($_REQUEST['add_firebase']=="1")
            $newclm = $clm."_firebase";
        else $newclm = $clm;

        $obj = new $model();
        $mainid = $obj->main_id;
//        echo $mainid;
        $syarat = $obj->publish_constraint;


        $obj->getById($id);
        $obj->lock("READ");
        $obj->$newclm = $path;
        $succ = $obj->save(1);
        $obj->unlock();

        $json['bool'] = $succ;

        echo json_encode($json);
        die();
    }

    function updateGallerypath(){
        $model = addslashes($_REQUEST['cname']);
        $id = addslashes($_REQUEST['id']);
        $path = base64_decode(addslashes($_REQUEST['path']));
        $clm = addslashes($_REQUEST['clm']);
        $fname = addslashes($_REQUEST['fname']);

        if($_REQUEST['add_firebase']=="1")
            $newclm = $clm."_firebase";
        else $newclm = $clm;

        $obj = new $model();
        $mainid = $obj->main_id;
//        echo $mainid;
        $syarat = $obj->publish_constraint;


        $obj->getById($id);
        $obj->lock("READ");

        if($obj->$newclm == "")$exp = array();
        else {
            $exp = explode("|", $obj->$newclm);

            foreach ($exp as $n => $e) {
                $exp2 = explode(",", $e);
                if ($exp2[0] == $fname) {
                    unset($exp[$n]);
                }
            }
        }

        $exp[] = $fname.",".$path;

        $obj->$newclm = implode("|",$exp);
        $succ = $obj->save(1);
        $obj->unlock();

        $json['bool'] = $succ;

        echo json_encode($json);
        die();
    }

    function dummy(){

        ?>
    <img src="https://firebasestorage.googleapis.com/v0/b/catalyst-5a033.appspot.com/o/images%2F741233d8fb000f7dd38add55788aae9c.jpg?alt=media&token=ce9c3391-6c7e-431f-ae34-16db9794d66c">
        <img src="https://firebasestorage.googleapis.com/v0/b/catalyst-5a033.appspot.com/o/images%2F79a156ab7255950c62a650ab81d0bb2f.jpg?alt=media&token=0bb242e9-2d71-43bc-8b94-f99b86cd5672">
        <?
    }


    function publishToElastic(){

        $model = addslashes($_REQUEST['cname']);

        $obj = new $model();
        $mainid = $obj->main_id;
//        echo $mainid;
        $syarat = $obj->publish_constraint;

//        pr($syarat);

        if($syarat['where']=="")
            $arr = $obj->getAll();
        else{
            $arr = $obj->getWhere($syarat['where']);
        }

        //isi ke elasticsearch
        global $elastic;



        //pr($arr);
        $arr2 = Crud::clean2print($obj,$arr);

//        pr($arr2);
        $arrnew = array();
        foreach($arr2 as $new){
//            pr($new);
//            echo $new[$mainid];
            $arrnew[$new[$mainid]] = $new;


            //upload foto ke firebase storage
//            if(count($syarat['photo'])>0){
//                foreach($syarat['photo'] as $colom){
//                    $colomygdipakai = _BPATH._PHOTOURL.$arrnew[$colom];
//                }
//            }
            $new2 = array();
            foreach($new as $key=>$val){
                if(is_numeric($val)){
//                    echo "int : ".$key;
                    $new2[$key]= (int)$val;
                }else{
                    $new2[$key] = $val;
                }
            }
//            pr($new2);
            $r = $elastic->index("catalyst",$model,$new2,$new2[$mainid]);
//            pr($r);
        }

//        pr($arrnew);


//        $elastic->delete("catalyst",$model,"AV3qBFkILFk9qr_nOaw-");
//
//        $elastic->delete("catalyst",$model,"AV3qBDRmLFk9qr_nOaw8");
//        $elastic->delete("catalyst",$model,"AV3qBO-aLFk9qr_nOaxD");
//        $elastic->delete("catalyst",$model,"AV3qBDSCLFk9qr_nOaw9");
//        $elastic->delete("catalyst",$model,"AV3qBKUwLFk9qr_nOaxA");



    }


    function publishTofirebasejsonTree(){

        $model = addslashes($_REQUEST['cname']);
        $tags = addslashes($_REQUEST['tags']);

        $obj = new $model();
        $mainid = $obj->main_id;


//        pr($model);

//
////        echo $mainid;
//        $syarat = $obj->publish_constraint;
//
////        pr($syarat);
//
//        if($syarat['where']=="")
//            $arr = $obj->getAll("","","*");
//        else{
//            $arr = $obj->getWhere($syarat['where']);
//        }
//
//
//
//
//
//        //pr($arr);
//        $arr2 = Crud::clean2print($obj,$arr,0);
//        $exp = explode(",",$obj->crud_webservice_allowed);
//
////        pr($arr2);
//        $arrnew = array();
//        foreach($arr2 as $new){
////            echo $new[$mainid];
//
//            foreach($exp as $attr){
//                if(is_numeric($new[$attr])){
////                    echo "numeric2  ";
//                    $int = doubleval($new[$attr]);
//                    $new[$attr] = $int;
////                    echo $attr.": ".$int."   xx<br>";
////                    $new['xx'] = 5;
//                }
//            }
//            $arrnew[$new[$mainid]] = $new;
//        }

//        pr($arrnew);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


        $lokasi_model = "published/".$model.".json";


        $lp = new LeapFirebase();
        $del = $lp->delete($lokasi_model);

        $tree = $_POST['tags'];
        $arrnew = json_decode($tree);
//        pr($arrnew);

        $arrnew = $this->saveTree($obj,"no");
//        pr($arrnew);

        if($del == "null") {
            $ret = $lp->patch($lokasi_model, $arrnew);
//            pr($ret);

            //isikan product dlm category
            $pg = new Product2Category();
            $arrpg = $pg->getAll();
            $arrnew = array();
            foreach($arrpg as $pg2){
                $arrnew[$pg2->pc_cat_id][$pg2->pc_prod_id] = true;
            }
//            pr($arrnew);
            $lokasi_model = "published/Product2Category.json";
            $lp = new LeapFirebase();
            $del = $lp->delete($lokasi_model);
            if($del == "null") {
                $ret = $lp->patch($lokasi_model, $arrnew);
//                pr($ret);
            }

            //TODO masukan elastic
            //$this->publishToElastic();

            if(count($ret)>0) {
                $json['status_code'] = 1;
                $json['status_message'] = "Publish Successful";

            }else {
                $json['status_code'] = 0;
                $json['status_message'] = "Publish Failed on Update";

            }

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Publish Failed on Delete";

        }

        echo json_encode($json);
        die();
    }

    var $arrIds = array();
    function saveTree($object,$webClass){
        $tree = $_POST['tags'];
        $arr = json_decode($tree);
        $hasil = array();

//        echo "in";
//        pr($arr);
        foreach($arr as $n=>$obj){
            //cek apakah array
            if(is_array($obj)){
                //if yes
                //get the first col as name and the res as children
                $id = $obj[0];
                //echo "adalah array dengan element pertama adalah $id <br>";

                //pr($obj);
                $hasil[$id] = $this->saveTreeRecursive($obj[1],$id,$object,$webClass,$hasil);
            }else{
                $id = $obj;
                //di skip aja krn tidak disave juga
            }


        }
        return $hasil;
//        exit();
    }
    function saveTreeRecursive($arr,$parent_id,$object,$webClass,$hasil){
//         echo "masuk save tree recursive <br> ";
//        echo "parent id : ".$parent_id."<br>";
//        echo "obj id : ".$obj;
//        pr($obj);
        /*if($parent_id == "non-active-menu" ||$parent_id == "active-menu" )
            return "";
        */
        $new = array();
        foreach($arr as $n=>$obj){
            //cek apakah array
            if(is_array($obj)){
                //if yes
                //get the first col as name and the res as children
                $id = $obj[0];
                $explode = explode("_",$id);
                $object->getByID($explode[1]);
                $this->arrIds[] = $explode[1];
                $new[$object->cat_id]['name'] = $object->cat_name;
                //$this->saveToObj($id,$parent_id,$object,$webClass);
                $new[$object->cat_id]['subcategory'] = $this->saveTreeRecursive($obj[1],$id,$object,$webClass,$new);
//                return $new;
            }else{
                $id = $obj;
                $explode = explode("_",$id);
                $object->getByID($explode[1]);
                $this->arrIds[] = $explode[1];
                //kalo bukan array di save
//                $this->saveToObj($id,$parent_id,$object,$webClass);
                $new[$object->cat_id]['name'] = $object->cat_name;
//                return $new;
            }
        }
        return $new;
    }


    function UploadJS2Flat(){

$model = addslashes($_REQUEST['cname']);

$obj = new $model();
$mainid = $obj->main_id;
//        echo $mainid;
$syarat = $obj->publish_constraint;

//        pr($syarat);

if($syarat['where']=="")
    $arr = $obj->getAll();
else{
    $arr = $obj->getWhere($syarat['where']);
}


if(count($arr)<1){
    ?>
    <script>
        alert("Nothing to publish, make sure element is activated");
        window.close();
    </script>
<?
}
?>
<html>
<head>
    <title>Publish</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <?=LeapFirebase::getWebSetup();?>

    <script>

        // Get a reference to the storage service, which is used to create references in your storage bucket
        var storage = firebase.storage();

        // Create a storage reference from our storage service
        var storageRef = storage.ref();
        // Create a child reference



        firebase.auth().signInAnonymously().catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // ...
            console.log(errorCode+' '+errorMessage);
        });
    </script>
    <style>
        .foto100 {
            width: 80px;
            height: 80px;
            overflow: hidden;
        }

        .foto100 img {
            width: 100%;
        }
    </style>

</head>
<body>

<div class="container">
    <? if(count($syarat['photo'])<1 && count($syarat['gallery'])<1){
    ?>

    <div class="container" style="text-align: center; margin-top: 100px; margin-bottom: 100px;">
        <h3>Please wait while publish..</h3>
        <div id="loadingDiv">
            <img src="<?=_SPPATH;?>images/tbs-hor-ajax-loader.gif">
        </div>

    </div>
    <script>
        $(document).ready(function(){
            updatefirebase();
//            updatefirebase_testing();
        });
    </script>

        <script>
            function updatefirebase_testing(){
                $.post("<?=_SPPATH;?>CrudPublisher/publishTofirebasejson_flat",{cname:"<?=$model;?>"},function(data){
                    console.log(data);

                });

            }

            function updatefirebase(){
                $.post("<?=_SPPATH;?>CrudPublisher/publishTofirebasejson_flat",{cname:"<?=$model;?>"},function(data){
                    alert(data.status_message);
//                    $('#upload').prop('disabled', false);
                    if(data.status_code){
                        window.close();
                    }

                },'json');

            }
        </script>

    <? }else{?>
    <script>alert('Contain photo or Gallery, please use publish not flat');</script>
            <?}?>
        </div>
        </body>
        </html>
    <?
    }

    function publishTofirebasejson_flat(){

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $model = addslashes($_REQUEST['cname']);

        $obj = new $model();
        $mainid = $obj->main_id;
        $mainvalue = $obj->main_value;
//        echo $mainid;
        $syarat = $obj->publish_constraint;

//        pr($syarat);

        if($syarat['where']=="")
            $arr = $obj->getAll("","","*");
        else{
            $arr = $obj->getWhere($syarat['where']);
        }

        $new = array();
        //hanya bisa dgn gawe_id dan gawe_value
        foreach($arr as $objx){
            if(is_numeric($objx->$mainvalue))$objx->$mainvalue = doubleval($objx->$mainvalue);
            elseif($objx->$mainvalue == "true")$objx->$mainvalue = true;
            else if($objx->$mainvalue ==  "false")$objx->$mainvalue = false;

            $new[$objx->$mainid] = $objx->$mainvalue;
        }







        $lokasi_model = "published/".$model.".json";


        $lp = new LeapFirebase();
        $del = $lp->delete($lokasi_model);



        if($del == "null") {
            $ret = $lp->patch($lokasi_model, $new);

//            pr($ret);

            //flat cannot be push to elastic
//            $this->publishToElastic();

//
            if(count($ret)>0) {
                $json['status_code'] = 1;
                $json['status_message'] = "Publish Successful";

            }else {
                $json['status_code'] = 0;
                $json['status_message'] = "Publish Failed on Update";

            }

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Publish Failed on Delete";

        }

        echo json_encode($json);
        die();
    }
} 