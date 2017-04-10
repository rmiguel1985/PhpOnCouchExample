<?php
/**
 * User: rmiguel
 * Date: 22/07/2015
 * Time: 20:00
 */

//-----------------------
require_once "lib/couch.php";
require_once "lib/couchClient.php";
require_once "lib/couchDocument.php";
require_once "config.php";
//-----------------------------------

class CouchWrapper {

    public $client;
    public $couch_dns;
    public $couch_db;

    /**
     * Constructor
     */
    function __construct(){

        $couch_dsn ="".$GLOBALS['COUCHDB_HOST'].":".$GLOBALS['COUCHDB_PORT'];
        $couch_db = $GLOBALS['COUCHDB_TABLE'];

        try{
            $this->client = new couchClient($couch_dsn,$couch_db);
        } catch (Exception $e) {
            echo "Error:".$e->getMessage()." (errcode=".$e->getCode().")\n";

        }

    }


    /**
     * @param $id
     * @return document values
     */
    function get_doc($id){

        try{
            $doc = $this->client->getDoc($id);
        } catch (Exception $e) {
            if ( $e->code() == 404 ) {
                echo "Document \"some_doc\" not found\n";
            } else {
                echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
            }
            exit(1);
        }
        return $doc;
    }


    /**
     * @param $resolution
     * @param $id_document
     * @return chart image tag
     */
    function chart($resolution,$id_document){

        $doc = $this->get_doc($id_document);

        $green = $doc->ie;
        $orange = $doc->firefox;
        $yellow = $doc->chrome;

        $chart = "<p align='center'><img src='http://chart.apis.google.com/chart?cht=p3&chs=$resolution".
            "&chd=t:$green,$orange,$yellow&chco=3cd629|FF8C00|FFFF00&chdl=Internet Explorer|Firefox|Chrome".
            "&chl=$green|$orange|$yellow&chdlp=bv&chma=0,0,0,0' /></p>";

        return $chart;
    }
}