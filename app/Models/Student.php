<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    public function create($data) {
        try{
        return $this->insertGetId($data);
        }catch (\Exception $e) {}
    }
    
    public function check($n_zach) {
       try{
       $res = $this->select()
               ->where('n_zach', '=', $n_zach)
               ->get()
               ->toArray();
       
       if($res) {
           return true;
       }
       else{
           return $res;
       }
       }catch (\Exception $e) {}
    }
}
