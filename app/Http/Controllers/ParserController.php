<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parser;
use App\Models\Dom;
use App\Models\Student;
use App\Models\Subject;

class ParserController extends Controller
{
    use \App\Traits\PeculiarValidator;
    
    private $url = 'https://www.nntu.ru/frontend/web/student_info.php';
    private $zach;
    private $dip;
    private $total;
    
    public function calcMedian(Request $request) {
        $rules = [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'otc' => 'required|string|max:255',
            'n_zach' => 'required|integer',
            'learn_type' => 'required|string|max:255'
        ];
        $validator = $this->validator($request->all(), $rules);
        if ($validator) {
            return $validator;
        }
        
        $str = $this->getParser($request->all());
        
        if ($str == "﻿Студент не найден.") {
            return response()->json([
                'data' => [
                    'notFound' => [$str],
                ],
            ], 404);
        }
        
        $check = $this->calcInDom($str);
        
        if (!$check) {
            return response()->json([
                'data' => [
                    'notFound' => [$str],
                ],
            ], 404);
        }
        
           
        try {
        $id = $this->createStudent($request->all());
        $this->createSubjects($id);
        }catch (\Exception $e) {}

        return response()->json([
            'zach' => $this->zach,
            'dip' => $this->dip,
            'total' => $this->total,
        ], 200);
    }
    
    private function calcInDom($str) {
        $dom = new Dom($str);
        $check = $dom->buildDistinctList();
        
        if ($check) {
            $this->zach = $dom->getMedianFull();
            $this->dip = $dom->getMedianDistinct();
            $this->total = $dom->getTotal();
        }
        return $check;
    }
    
    private function createSubjects($id) {
        if($id) {
            $subject = new Subject();
            $subject->createMulti($id, $this->total);
        }
    }
    
    private function createStudent($data) {
        $student = new Student();
        $check = $student->check($data['n_zach']);
        $data['zach'] = $this->zach;
        $data['dip'] = $this->dip;
        $id = $student->create($data);
        if($check) {
            return false;
        }
        return $id;
         
        
    }
    
    private function getParser($data) {
        $parser = new Parser(
                $this->url,
                $data,
            );
        $str = $parser->parse();
        
        $str = $str ?? "﻿Студент не найден.";

        return $str;
    }
}
