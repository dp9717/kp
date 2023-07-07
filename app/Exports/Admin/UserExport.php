<?php

namespace App\Exports\Admin;


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

class UserExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, WithEvents, WithCustomValueBinder
{
    protected $mergeCells = ['A1:L1'];
    protected $bold = ['A1:L1' => true];
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
                            $add ='';
                            if(isset($row['user_address']['full_address']) && $row['user_address']['full_address']){
                                $add = json_Decode($row['user_address']['full_address']);
                                if($add)
                                {  
                                    $add = ($add->address ?? '').', '. ($add->taluk ?? '') .', '. ($add->city ?? '') .', '.  ($add->state ?? '') .', '.  $add->pincode ?? '';
                                }
                            }
                            $output[] = [
                                $row['name'] ?? '',
                                $row['slug'] ?? '',
                                $row['email'] ?? '',
                                $row['mobile'] ?? '',
                                $row['office_no'] ?? '',
                                $row['office_email'] ?? '',
                                 $row['user_role']['role']['name'] ?? '',
                                $add,
                                $row['designation'] ?? '',
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
        $text = 'User Data';
        $data = [
                    'Name',
                    'Code',
                    'Email',
                    'Contact',
                    'Office No',
                    'Office Email',
                    'System Role',
                    'Address',
                    'Designation',
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
                $event->sheet->getDelegate()->getStyle('A1:L1')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:L1')->getAlignment()->setHorizontal('center');

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
