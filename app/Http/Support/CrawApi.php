<?php


namespace App\Http\Support;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class CrawApi
{
    public $url;
    public $dataAPi;
    public $tp;
    protected $client;

    public function __construct($url,$tp = 'Bắc Ninh')
    {
        $this->client = new Client(HttpClient::create([
            'verify_peer' => false,
            'verify_host' => false,
            'timeout' => 30
        ]));
        $this->url = $url;
        $this->tp = $tp;
    }

    public function Pros()
    {
        $craw = $this->client->request('GET', $this->url);
        $dta = array();
        $craw->filter('#sailorTableArea')->each(function ($node) use (&$dta) {
            $node->filter('tbody > tr')->each(function ($get) use (&$dta) {
                if (strpos($get->text(), $this->tp)) {
                    $dta[] = array(
                        'Name' => $get->filter('td')->eq(0)->text(),
                        'Age' => $get->filter('td')->eq(1)->text(),
                        'From' => $get->filter('td')->eq(2)->text(),
                        'Status' => $get->filter('td')->eq(3)->text(),
                        'Country' => $get->filter('td')->eq(4)->text(),
                    );
                }
            });
        });

        $new = [
            'Total' => count($dta),
            'Recovery' => $this->Recovery($dta),
            'Die' => $this->Díe($dta),
            'Data' => $dta
        ];
        $this->dataAPi = $new;
        return $this->dataAPi;
    }
    private function Recovery($data){
        $conut = 0;
        foreach ($data as $key => $recovery){
            if ($recovery['Status'] == 'Khỏi'){
                $conut++;
            }
        }
        return $conut;
    }
    private function Díe($data){
        $conut = 0;
        foreach ($data as $die){
            if ($die['Status'] == "Tử vong"){
                $conut++;
            }
        }
        return $conut;
    }
}



