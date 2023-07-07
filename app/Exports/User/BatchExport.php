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
class BatchExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, WithEvents, WithCustomValueBinder
{
    protected $mergeCells = ['A1:P1'];
    protected $bold = ['A1:P1' => true];
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
                            $output[] = [
                                $row['slug'] ?? '',
                                json_decode($row['project_ary'])->name ?? '',
                                json_decode($row['project_ary'])->slug ?? '',
                                json_decode($row['location_ary'])->name ?? '',
                                json_decode($row['location_ary'])->slug ?? '',
                                json_decode($row['trainer_ary'])->name ?? '',
                                json_decode($row['trainer_ary'])->slug ?? '',
                                json_decode($row['state_co_ordinator_ary'])->name ?? '',
                                json_decode($row['state_co_ordinator_ary'])->slug ?? '',
                                json_decode($row['module_ary'])->name ?? '',
                                Helper::date($row['start_date'],'d m Y') ?? '',
                                Helper::date($row['end_date'],'d m Y') ?? '',
                                Helper::date($row['start_time'],'h:i a') ?? '',
                                Helper::date($row['end_time'],'h:i a') ?? '',
                                ($row['status']==1) ? 'Active' : 'Inactive',
                                $row['additional_information'] ?? ''
                            ];
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
        $text = 'Batch Data';
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
                    'Status',
                    'Additional Info'
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
                $event->sheet->getDelegate()->getStyle('A1:P1')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:P1')->getAlignment()->setHorizontal('center');

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

