<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReadLazadaProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lazada:productinfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read information of the product.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $this->readVoterInformation();
        return Command::SUCCESS;

    }
    private function readVoterInformation(){
        $xpathResult = $this->readPageWithCurl( 
            // Url
            "https://www.lazada.co.th/products/neo-hair-lotion-neohair-i4514515660-s18318349196.html?clickTrackInfo=query%253A%253Bnid%253A4514515660%253Bsrc%253ALazadaMainSrp%253Brn%253A6814d59bce2227e11052fcf893434cea%253Bregion%253Ath%253Bsku%253A4514515660_TH%253Bprice%253A269%253Bclient%253Adesktop%253Bsupplier_id%253A100215522663%253Bpromotion_biz%253A%253Basc_category_id%253A9020%253Bitem_id%253A4514515660%253Bsku_id%253A18318349196%253Bshop_id%253A3300815&fastshipping=0&freeshipping=0&fs_ab=1&fuse_fs=1&lang=en&location=Samut%20Prakan&price=269&priceCompare=&ratingscore=5.0&request_id=6814d59bce2227e11052fcf893434cea&review=9&sale=12&search=1&source=search&spm=a2o4m.searchlistcategory.list.i40.3acf1af3QMvGq5&stock=1", 
            // Classes and Tags
            "//div[@id=module_product_price_1]" , 
            // Params
            [
            //     'Activetab'=> 2 ,
            //     'province'=> '' ,
            //     'fname'=> '' ,
            //     'lname'=> '' ,
            //     'btnSearchName2'=> 0 ,
            //     'search_type'=> 'search_type_by_receiptno' ,
            //     'cardid'=>$voteIdNumber ,
            //     'id_no'=>''
            ]
        );
        dd( $xpathResult );
        // $dataColumns = preg_split(
        //     "/\r\n|\n|\r|\t/", 
        //     $xpathResult[0]->childNodes[3]->textContent
        // ) ;
        // return $dataColumns ;
        // return array_filter(array_map( function( $data ){
        //     return trim( $data);
        // } , $dataColumns ));
    }
    private function readPageWithCurl($url, $query , $postParameter ){

        libxml_use_internal_errors(true);
        $data = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParameter);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
        $data = curl_exec($ch);
        curl_close($ch);
        if( empty($data) ) return false ;
        $doc = new \DOMDocument;
        // We don't want to bother with white spaces
        $doc->preserveWhiteSpace = false;
        $doc->loadHTML($data);
        $xpath = new \DOMXPath($doc);
        return $xpath->query($query);
      }
}
