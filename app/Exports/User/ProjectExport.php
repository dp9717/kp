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
class ProjectExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, WithEvents, WithCustomValueBinder
{
    protected $mergeCells = ['A1:J1'];
    protected $bold = ['A1:J1' => true];
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
                                $row['name'] ?? '',
                                $row['slug'] ?? '',
                                //$row['duration'] ?? '',
                                \App\Models\Project::fundedby($row['funded_by']) ?? '',
                                $row['target_number'] ?? '',
                                $row['est_fund_value'] ?? '',
                                ucwords($row['mou_signed'] ?? ''),
                                $row['mou_start_date'] ? Helper::date($row['mou_start_date'],'d m Y') : '',
                                $row['mou_end_date'] ? Helper::date($row['mou_end_date'],'d m Y') : '',
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
        $text = 'Project Data';
        $data = [
                    'Name',
                    'Code',
                   // 'Duration',
                    'Funded By',
                    'Target Number',
                    'EST Fund Value',
                    'MOU Signed',
                    'MOU State Date',
                    'MOU End Date',
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
                $event->sheet->getDelegate()->getStyle('A1:J1')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:J1')->getAlignment()->setHorizontal('center');

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
