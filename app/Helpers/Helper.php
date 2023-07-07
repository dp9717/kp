<?php 

namespace App\Helpers;
use Request;
use Str;
use Carbon\Carbon;
use Auth;
use Form;
class Helper{
	public static function removetag($value='')
	{
        return $data = strip_tags(trim($value));
	}
	
	public static function userCode($value='')
	{
		$count=strlen($value);
		$num='';
		return 'UC'.date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function ProcessUniqueCode($value='',$process='',$fst='')
	{

		$count=strlen($value);
		$num='';
		if ($process==1) {
			return 'PRJ'.date('d').date('m').date('y').'-'.str_pad($value, 3, '0', STR_PAD_LEFT);
		}
		if ($process==2) {
			return 'CC'.date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
		}
		if ($process==4) {
			return 'VD'.date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
		}
		if ($process==5) {
			return 'PT'.date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
		}
		if ($process==3) {
			$fst =strtoupper($fst);
			return $fst.date('d').date('m').date('y').'-'.str_pad($value, 3, '0', STR_PAD_LEFT);
		}
		if ($process==10) {
			$fst =strtoupper($fst);
			return 'C-'.$fst.date('y').date('m').date('d').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
		}
		
	}


	public static function getDocType($file_url, $value) {
    	$data = explode('.', $value);
    	$ext = isset($data[1]) ? $data[1] : '';
    	$doctype = '';
	    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'svg') {
	      $doctype = "<img src='".url($file_url.$value)."' width='70' height='70' />";
	    } else if($ext == 'doc' || $ext == 'docx') {
	      $doctype = "<img src='".url('public/images/doc.png')."' width='70' height='70' />";
	    } else if($ext == 'xls' || $ext == 'xlsx') {
	      $doctype = "<img src='".url('public/images/excel.png')."' width='70' height='70' />";
	    } else if($ext == 'csv') {
	      $doctype = "<img src='".url('public/images/csv.png')."' width='70' height='70' />";
	    } else if($ext == 'ppt' || $ext == 'pptx') {
	      $doctype = "<img src='".url('public/images/ppoint.png')."' width='70' height='70' />";
	    } else if($ext == 'pdf' || $ext == 'PDF') {
	      $doctype = "<img src='".url('public/images/pdf.png')."' width='70' height='70' />";
	    } else if($ext == 'zip') {
	      $doctype = "<img src='".url('public/images/zip.png')."' width='70' height='70' />";
	    } else if($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg') {
	      $doctype = "<img src='".url('public/images/video.png')."' width='70' height='70' />";
	    } else if($ext == 'mp3') {
	      $doctype = "<img src='".url('public/images/audio.png')."' width='70' height='70' />";
	    } else {
	      $doctype = "<img src='".url('public/images/file.png')."' width='70' height='70' />";
	    }
    	return $doctype;
  	}

  	public static function process($value=null)
    {
        $data = [
				    1 => 'Project', 
				    2 => 'Centre',
				    3 => 'Batch',
				    4 => 'Vendor',
				    5 => 'Partner',
				    6 => 'User',
				    7 => 'Billing/Expenses',
				    8 => 'Attendence',
				    9 => 'Assesment',
				    10 => 'Certificate'

				];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function permission($value='')
    {
    	$data = [
				    1 => 'Add', 
				    2 => 'Edit',
				    3 => 'Status',
				    4 => 'Remove',
				    5 => 'View'
				];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }
  	
  	public static function date($value='',$format=null)
	{
		if ($value) {
			$d_format='d M Y';
			if ($format) {
				$d_format=$format;
			}
			return date($d_format,strtotime($value));
		}else{
			return '';
		}
		
	}

	public static function classActiveByRouteName($routeName) {
		$curRoute=\Request::route()->getName(); 
		$class='';
		foreach($routeName as $route) {
			if ($curRoute==$route) {
				$class = 'active';
			}
		}
		return $class;
	}

	public static function classOpenByRouteName($routeName) {
		$curRoute=\Request::route()->getName(); 
		$class='';
		foreach($routeName as $route) {
			if ($curRoute==$route) {
				$class = 'open';
			}
		}
		return $class;
	}

	public static function classMenuOpenByRouteName($routeName) {
		$curRoute=\Request::route()->getName(); 
		$class='';
		foreach($routeName as $route) {
			if ($curRoute==$route) {
				$class = 'show';
			}
		}
		return $class;
	}

	public static function processStatusLevel($process_id='',$value='')
	{
		if ($process_id==2) {//centre creation
			$data = [
					    1 => 'Create', 
					    3 => 'Approve'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==4) {//vendor
			$data = [
					    1 => 'Create', 
					    3 => 'Approve'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==5) {//partner
			$data = [
					    1 => 'Create', 
					    3 => 'Approve'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==1) {//partner
			$data = [
					    1 => 'Create', 
					    3 => 'Approve'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==3) {//Batch Creation
			$data = [
					    1 => 'Create', 
					    3 => 'Second Level Approval',
					    4 => 'Third Level Approval',
					    5 => 'Final Approval'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==8) { // attendence
			$data = [
					    1 => 'Create', 
					    2 => 'Update'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==9) { // assesment
			$data = [
					    1 => 'Create', 
					    2 => 'Update'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==10) { // Certificate
			$data = [
					    1 => 'Create', 
					    2 => 'View/Download'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
		else if ($process_id==7) {//billing expense
			$data = [
					    1 => 'Create', 
					    3 => 'Second Level Approval',
					    4 => 'Third Level Approval',
					    5 => 'Final Approval'
					];
	        if ($value) {
	            return $data[$value];
	        }else{
	            return $data;
	        }
		}
	}

	public static function diffInDays($from='',$to='') {
		$from = \Carbon\Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
		$to = \Carbon\Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
		return $diff_in_days = $to->diffInDays($from, false);
	}

	public static function filterPrjType($value='')
    {
    	$data = [
		    'Completed' => 'Completed', 
		    'Extended' => 'Extended'
		];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function randtoken($len=64,$value='')
    {
    	$value = $value ? time() : $value;
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.$value;
	    $randomString = '';
	 
	    for ($i = 0; $i < $len; $i++) {
	        $index = rand(0, strlen($characters) - 1);
	        $randomString .= $characters[$index];
	    }
	 
	    return $randomString;
    }
}