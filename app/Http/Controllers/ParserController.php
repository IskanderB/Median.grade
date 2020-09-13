<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParserController extends Controller
{
    private $url = 'https://www.nntu.ru/frontend/web/student_info.php';
    
    public function calcMedian(Request $request) {
        $parser = new Parser(
                $this->url,
                [
                    'last_name' => 'Хуртин',
                    'first_name' => 'Александр',
                    'otc' => 'Олегович',
                    'n_zach' => '150841',
                    'learn_type' => 'bak_spec'
                ],
            );
        $srt = $parser->parse();
        
        $dom = new Dom($srt);
        $dom->buildDistinctList();
//        $dom->printMedian();
//        dd();
        $array = $dom->getDistinct();
        dd($array);
    }
}
