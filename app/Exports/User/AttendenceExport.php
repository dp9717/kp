<?php

namespace App\Exports\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Auth;
use App\Helpers\Helper;
class AttendenceExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, WithEvents, WithCustomValueBinder
{
    protected $mergeCells = ['A1:Q1'];
    protected $bold = ['A1:Q1' => true];
    protected $vertical = [];

     /**
    * @return \Illuminate\Support\Collection
    */
    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(),["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"])) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    function __construct($arrays=[])
    {
        $output = [];
        foreach ($arrays as $key => $array) {
                foreach ($array as $aryKey => $row) {
                    if($key==0){
                        if ($row['id']!='') {
                            if (isset($row['att_student']) && count($row['att_student'])) {
                                foreach ($row['att_student'] as $s_key => $s_value) {
                                    $output[] = [
                                        $row['slug'] ?? '',
                                        json_decode($row['batch']['project_ary'])->name ?? '',
                                        json_decode($row['batch']['project_ary'])->slug ?? '',
                                        json_decode($row['batch']['location_ary'])->name ?? '',
                                        json_decode($row['batch']['location_ary'])->slug ?? '',
                                        json_decode($row['batch']['trainer_ary'])->name ?? '',
                                        json_decode($row['batch']['trainer_ary'])->slug ?? '',
                                        json_decode($row['batch']['state_co_ordinator_ary'])->name ?? '',
                                        json_decode($row['batch']['state_co_ordinator_ary'])->slug ?? '',
                                        json_decode($row['batch']['module_ary'])->name ?? '',
                                        Helper::date($row['batch']['start_date'],'d m Y') ?? '',
                                        Helper::date($row['batch']['end_date'],'d m Y') ?? '',
                                        Helper::date($row['batch']['start_time'],'h:i a') ?? '',
                                        Helper::date($row['batch']['end_time'],'h:i a') ?? '',
                                        $s_value['student']['name'] ?? '',
                                        Helper::date($row['attendence_date'],'d m Y') ?? '',
                                        \App\Models\Attendence::attendenceAry($s_value['attendence']) ?? '',
                                        $s_value['student']['attendence_percent'].'%' ?? '',
                                    ];
                                }
                            }
                        }
                    }
                }
            // add an empty row before the next dataset 
            //$output[] = [''];
        } 
        //print_r($output);die();
        $this->collection = collect($output);

    }           
                    
    public function collection()
    {
        return $this->collection;
    }

    public function map($data) : array {
                return $data;
            
    }
 
    public function headings(): array
    {
        $text = 'Attendence Data';
        $data = [
                    'Batch Code',
                    'Project',
                    'Project Code',
                    'Location',
                    'Location Code',
                    'Trainer',
                    'Trainer Code',
                    'State Co-Ordinator',
                    'State Co-Ordinator Code',
                    'Module',
                    'Training Start Date',
                    'End Date',
                    'Start Time',
                    'End Time',
                    'Student',
                    'Attendence Date',
                    'Attendence',
                    'Percent'
        ];
        return [
            [$text],
            $data
        ];
           
    }

    public function dateFormate($value='')
    {
        return date('d/m/Y',strtotime($value));
    }

    public function registerEvents(): array { 
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:Q1')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:Q1')->getAlignment()->setHorizontal('center');

                foreach ($this->vertical as $region => $position) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getAlignment()
                        ->setVertical($position);
                }

                foreach ($this->bold as $region => $bool) {
                    $event->sheet->getDelegate()
                        ->getStyle($region)
                        ->getFont()
                        ->setBold($bool);
                }

                $event->sheet->getDelegate()->setMergeCells($this->mergeCells);
                if(!empty($this->sheetName)){
                    $event->sheet->getDelegate()->setTitle($this->sheetName);
                }
            }
        ];
    }

    public function setBold (array $bold)
    {
        $this->bold = array_change_key_case($bold, CASE_UPPER);
    }

    public function setMergeCells (array $mergeCells)
    {
        $this->mergeCells = array_change_key_case($mergeCells, CASE_UPPER);
    }
}

