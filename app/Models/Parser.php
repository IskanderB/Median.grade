<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    use HasFactory;
    
    private $url;
    private $data = [];
    
    public function __construct($url, $data) {
        $this->url = $url;
        $this->data = $data;
    }
    
    public function parse() {
        $myCurl = curl_init();
        curl_setopt_array($myCurl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($this->data)
        ));
        $response = curl_exec($myCurl);
        curl_close($myCurl);
        
        return $response;
    }
}
