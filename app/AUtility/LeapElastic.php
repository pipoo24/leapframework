<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/4/17
 * Time: 10:45 AM
 */

class LeapElastic {

    var $client;
    var $hosts;

    function __construct() {
        $exp = explode(",",SystemSetting::getData('elasticsearch_host'));
        $this->hosts = $exp;
    }

    function init($hosts){


        $client = Elasticsearch\ClientBuilder::create()           // Instantiate a new ClientBuilder
        ->setHosts($hosts)      // Set the hosts
        ->build();

        $this->client = $client;
        return $client;
    }

    function index($index,$type,$body,$id=""){
        $params = array();
        $params['body']  = $body;
//        array(
//            'name' => 'Brock',
//            'age' => 15,
//            'badges' => 0
//        );

        $params['index'] = $index;
        $params['type']  = $type;

        if($id!="")
        $params['id'] = $id;

        $result = $this->client->index($params);
        return $result;
    }
    function getByID($index,$type,$id,$fields = "*"){
        $params = array();


        $params['index'] = $index;
        $params['type']  = $type;
        $params['id'] = $id;

        if($id=="") return "no id";

        //TODO jika fields != *

        $result = $this->client->get($params);
        return $result;
    }

    function delete($index,$type,$id){
        $params = array();


        $params['index'] = $index;
        $params['type']  = $type;
        $params['id'] = $id;

        if($id=="") return "no id";


        $result = $this->client->delete($params);
        return $result;
    }


    function getAll($index,$type,$size =10,$from = 0){
        $params = array();
        $params['index'] = $index;
        $params['type']  = $type;

        $json = '{
  "query": { "match_all": {} },
  "from": '.$from.',
  "size": '.$size.'
}';


        $params['body'] = json_decode($json);


        return $this->client->search($params);

    }

    function query($index,$type,$body,$size =10,$from = 0){
        $params = array();
        $params['index'] = $index;
        $params['type']  = $type;

        $json = '{
  "query": { "match_all": {} },
  "from": '.$from.',
  "size": '.$size.'
}';


        $params['body'] = json_decode($body);


        return $this->client->search($params);

    }

    //"sort": { "balance": { "order": "desc" } }
    //,"sort": {"balance":{"order":"desc"}}

    function getAllSort($index,$type,$arrOrder = array(),$size =10,$from = 0){
        $params = array();
        $params['index'] = $index;
        $params['type']  = $type;

        $sort = "";

        $sor = array();
        foreach($arrOrder as $col_name=>$arahorder){
            $arr = array();
            $arr[$col_name] = array("order"=>$arahorder);
            $sor[] = $arr;

            if(count($arrOrder)==1)$sor = $arr;
        }

//        print_r($sor);

        if(count($sor)>0){
            $sor2 = array();
            $sor2['sort'] = $sor;
            $sort = ', "sort" : '. json_encode($sor);
        }
        echo $sort;


        $json = '{
  "query": { "match_all": {} },
  "from": '.$from.',
  "size": '.$size.'
  '.$sort.'
}';


        $params['body'] = json_decode($json);
//        print_r($params);

        return $this->client->search($params);

    }
} 