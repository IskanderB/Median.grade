<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    public function createMulti($id, $total) {
        try{
        foreach ($total as &$value) {
            $value['student_id'] = $id;
            $value['grade_all'] = $value['grade']['all'];
            $value['grade_end'] = $value['grade']['end'];
            unset($value['grade']);
        }
        
        $this->insert($total);
        }catch (\Exception $e) {}
    }
}
