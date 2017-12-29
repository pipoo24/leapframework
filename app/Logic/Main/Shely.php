<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/17
 * Time: 10:18 AM
 */

class Shely extends WebApps{

    function index(){

        ?>
        <h1>Daftar Pustaka</h1>
        <?

        $buku = new Buku();
        $arr = $buku->getWhere("stok >0");

//        pr($arr);
        ?>
        <ol>
        <?
        foreach($arr as $key=>$val){

            ?>
            <li><a href="<?=_SPPATH;?>detail?id=<?=$val->id;?>"><?=$val->title;?></a> <?=$val->stok;?></li>
            <?
        }

        ?>
        </ol>
        <?
    }
    function detail(){
        $id = $_GET['id'];
        $buku = new Buku();
        $buku->getByID($id);


        ?>
        <h1><?=$buku->title;?></h1>
        <h3>Stok adalah <?=$buku->stok;?></h3>
        <?

        $this->index();
    }
    function addBuku(){



        ?>

        <form method="post" action="<?=_SPPATH;?>isikeDB">
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Buku</label>
                <input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Stok</label>
                <input name="stok" type="number" class="form-control" id="exampleInputPassword1" placeholder="Stok">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <?

    }
    function isikeDB(){

        $title = $_POST['title'];
        $stok = $_POST['stok'];

        $buku = new Buku();
        $buku->title = $title;
        $buku->stok = $stok;
        if($buku->save()){

            ?>
        <script>
            alert("insert sukses");
            window.location = "<?=_SPPATH;?>addBuku";
        </script>
            <?
        }else{

            echo "input gagal";
        }

    }
    function editBuku(){

        $buku = new Buku();
        $buku->getByID(2);
        $buku->title = "Tentang HTML";
        $buku->stok = 1000;
        echo $buku->save();



    }


    //jquery contoj

    function single(){


        ?>
        <a id="klik1">data</a> <a id="klik2">buku</a> <a id="klik3">lucu</a>
        <div id="contentklik" class="draggable">
            Hallo
        </div>
        <script>
            $("#klik1").click(function(){
                $.get("<?=_SPPATH;?>shely/data",function(data){
                   $("#contentklik").html(data);
                });
            });

            $("#klik2").click(function(){
                $.get("<?=_SPPATH;?>shely/buku",function(data){
                    $("#contentklik").html(data);
                });
            });

            $("#klik3").click(function(){
                $.get("<?=_SPPATH;?>ws/daftarguru",function(data){
                    $("#contentklik").html(data);
                });
            });
        </script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
//            $( function() {
//                $( ".draggable" ).draggable();
//            } );
        </script>
        <?

    }


    function data(){

        ?>
        <h1>Data adalah bla bla bla</h1>
        <h3>Bagus sekali</h3>
        <?
        exit();
    }

    function buku(){

        ?>
        <h1>Daftar Pustaka</h1>
        <?

        $buku = new Buku();
        $arr = $buku->getWhere("stok >0");

//        pr($arr);
        ?>
        <ol>
            <?
            foreach($arr as $key=>$val){

                ?>
                <li><a href="<?=_SPPATH;?>detail?id=<?=$val->id;?>"><?=$val->title;?></a> <?=$val->stok;?></li>
            <?
            }

            ?>
        </ol>
    <?
        exit();
    }

    function lucu(){

        ?>
        <h3>Ini LUCU SEKALI</h3>
        <?
        exit();
    }

} 