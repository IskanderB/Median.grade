<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parser;
use App\Models\Dom;

class ParserController extends Controller
{
    use \App\Traits\PeculiarValidator;
    
    private $url = 'https://www.nntu.ru/frontend/web/student_info.php';
    
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
        
        $parser = new Parser(
                $this->url,
                $request->all(),
            );
        $srt = $parser->parse();
        
        $str = $str ?? "﻿Студент не найден.";
        

        if ($srt == "﻿Студент не найден.") {
            return response()->json([
                'data' => [
                    'notFound' => [$str],
                ],
            ], 404);
        }
        
        $dom = new Dom($srt);
        $check = $dom->buildDistinctList();
        
        if (!$check) {
            return response()->json([
                'data' => [
                    'notFound' => [$str],
                ],
            ], 404);
        }
        
        $zach = $dom->getMedianFull();
        $dip = $dom->getMedianDistinct();
        $total = $dom->getTotal();
        
        return response()->json([
            'zach' => $zach,
            'dip' => $dip,
            'total' => $total,
        ], 200);
    }
}
