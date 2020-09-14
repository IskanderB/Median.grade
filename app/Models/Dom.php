<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use voku\helper\HtmlDomParser;

class Dom extends Model
{
    use HasFactory;
    
    private $dom;
    private $full = [];
    private $distinct = [];
    
    public function __construct($str) {
        $this->dom = HtmlDomParser::str_get_html($str);
    }
    
    public function buildFullList() {
        $elements = $this->dom->findMulti('.tr_class');

        foreach ($elements as $item) {
            $name = trim($item->firstChild->textContent);
            $grade = $item->getElementByClass('mark_exists');
            $type = trim($item->lastChild->textContent);
            
            if (count($grade)) {
                $grade = (integer)$grade[0]->textContent;
                if ($grade) {
                    $this->full[] = [
                        'name' => $name,
                        'grade' => $grade,
                        'type' => $type,
                    ];
                }               
            }
        }
    }
    
    public function buildDistinctList() {
        if (empty($this->full)) {
            $this->buildFullList();
        }
        
        for ($j=0;$j<count($this->full);$j++) {
            $duplications = [];
            for ($i=0;$i<count($this->full);$i++) {
                if ($this->full[$j]['name'] == $this->full[$i]['name'] and $this->full[$j]['type'] == $this->full[$i]['type']) {
                    $duplications[] = $this->full[$j]['grade'];
                }
            }
            $this->distinct[$this->full[$j]['name'] . ' | ' . $this->full[$j]['type']] = max($duplications);
        }
    }
    
    public function printMedian() {
        $full = $this->calcMedianFull();
        $distinct = $this->calcMedianDistinct();
        
        echo "<p>Средний балл зачётки: $full";
        echo "<p>Средний балл диплома: $distinct";
    }
    
    private function calcMedianFull() {
        $sum = 0;
        foreach ($this->full as $value) {
            $sum += $value['grade'];
        }
        return round($sum/count($this->full), 2);
    }
    
    private function calcMedianDistinct() {
        $sum = 0;
        foreach ($this->distinct as $value) {
            $sum += $value;
        }
        return round($sum/count($this->distinct), 2);
    }
    
    public function getFull() {
        return $this->full;
    }
    
    public function getDistinct() {
        return $this->distinct;
    }
}
