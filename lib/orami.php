<?php
/**
 * orami product detail class
 * Author : Farindra Eka Putra 
 * Email : ekaputra@farindra.com
 * repo : 
 */


class Product {

    /**
     * products master data
     *
     * @var array
     */
    protected $productData;

    /**
     * products stock data
     *
     * @var array
     */
    protected $stockData;

    /**
     * products location data
     *
     * @var array
     */
    protected $locationData;

    /**
     * cache folder location pathe
     *
     * @var string
     */
    protected $cache_path = 'cache/';


    public function __construct ( $productData, $stockData, $locationData ) {
        $this->productData = $productData;
        $this->stockData = $stockData;
        $this->locationData = $locationData;
    }

    /**
     * Product Detail Read Execution Command
     *
     * @param boolean $refresh Set TRUE If re-new data to cached
     * @return object
     */
    public function run( $refresh = FALSE){

        /* refresh cached data ? and  check is cached file exist ? */
        $productDetail = $this->readCache( $this->cache_path . 'products.cache');
        if(!$refresh &&  $productDetail){
            echo  $productDetail;
        }else{
            echo json_encode($this->getProductDetail( $this->productData, $this->stockData, $this->locationData) );
        }

    }

    /**
     * GET Products Detail and create/update to cached file function
     *
     * @param array $productData
     * @param array $stockData
     * @param array $locationData
     * @param boolean $refresh
     * @return array
     */
    private function getProductDetail($productData, $stockData, $locationData, $refresh = FALSE){

        $result = [];
        
        /* read product detail */
        foreach($productData as $products ){
            $detail = [];
            $detail['productName'] = $products['productName'];
    
            /* read product stock */
            foreach( $stockData as $stock ){
    
                if($products['productId'] == $stock['productId'] ){
                    $detail['stock']['total']  = (int) $detail['stock']['total'] + (int) $stock['stock'];
    
                    /* read location */
                    foreach($locationData as $location){
                        if($stock['locationId'] == $location['locationId'] ){
                             $detail['stock']['detail'][] = [
                                 'locationName' =>  $location['locationName'],
                                 'stock' =>  (int) $stock['stock']
                             ];
                        }
                    }
                }
            }
    
            $result[]= $detail ;
    
        }
        
        $this->writeCache($result);

        return $result;
    }
    
    /**
     * write data to cache file
     *
     * @param object $data | 
     * @return boolean
     */
    private function writeCache($data){
        
        try{
            /* create cache file */
            $filename =  $this->cache_path . 'products.cache';
            $filew = fopen( $filename, 'w');
            fwrite($filew, json_encode($data) );
            fclose($filew);
    
            return TRUE;
         }catch(Exception $e){
            return FALSE;
         }
         
    }
    
    /**
     * read data from cached
     *
     * @param string $filename
     * @return object || boolean
     */
    private function readCache($filename){
       
        try{
            if (!file_exists($filename))
                return FALSE;
            
            $filer = fopen( $filename, 'r');
            $data = fread($filer, filesize( $filename));
            fclose($filer);
    
            return $data;
            
        }catch(Exception $e){
            return FALSE;
        }
    }
    
}


