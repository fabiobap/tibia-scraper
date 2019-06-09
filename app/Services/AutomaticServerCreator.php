<?php

namespace App\Services;

use App\{Server, Sightings};
use Illuminate\Support\Facades\DB;

class AutomaticServerCreator
{
    
    public function getAllServersNames(){
    
        $result = $this->scrapeWebsite();
        
        //empty array
        $worlds = [];

        /*iterate over the result to get the worlds names
        array_filter to eliminates some empty values
        */
        for($i = 0; $i<sizeof($result); $i++){

            //world names
            $world = (string)$result[$i][0];
            array_push($worlds, $world);
        }
        
        $worlds = array_filter($worlds);
        sort($worlds);
        
        //create servers based on the results
        $addedServers = $this->createServers($worlds);
        
        //return only the added servers if they exists
        return $addedServers;
    }
    
    private function scrapeWebsite(){
        
        $dom = new \DOMDocument();
        libxml_use_internal_errors( 1 );
        
        // get worlds from the website
        $data = file_get_contents( 'https://www.tibia.com/community/?subtopic=worlds');
        $data = str_replace( '&#160;', '', $data );
        
        $dom->loadHTML('<?xml encoding="UTF-8">' . $data );
        $dom->formatOutput = true;
        
        $table = $dom->getElementsByTagName( 'table' )->item(4);
        /* if tournment is up
        $table = $dom->getElementsByTagName( 'table' )->item(6);
        */
        
        $xml = '<?xml version="1.0" encoding="utf-8" ?>'.$dom->saveHTML( $table );
        $xml = new \SimpleXmlElement($xml);
        
        $result = $xml->xpath(".//a");
        
        return $result;
    }
    
    private function createServers(array $worlds){
        $added=[];
        try {
            DB::beginTransaction();
            foreach($worlds as $world){
                $server = Server::firstOrCreate(["name" => $world]);
                if ($server->wasRecentlyCreated){
                    array_push($added, $server->name);
                }
            }
            DB::commit();
            return $added;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}