<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Europe/London');
/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';
echo date('H:i:s') , " Load from Excel5 template" , EOL;
$file = "templates/30template.xlsx";

$inputFileType = PHPExcel_IOFactory::identify($file);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($file);

//get all day in month
$days=array();
$month = 2;
$year = 2017;

for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)   {    
        //$days[]= [date('Y-m-d-D', $time), 'ddd' ];
	    $days[] = date('m/d', $time);
	    $dayWks[] = date('D', $time);
	    $dayValues[] = date('d', $time);
	}
}
$sheet = array(
	$days,
	$dayWks,
	$dayValues,
);

//$objPHPExcel->getActiveSheet()->fromArray($sheet, null, 'A1');
$baseRow = 5;

$worksheet = $objPHPExcel->getActiveSheet();
foreach($sheet as $r => $columns) {
	$row = $baseRow + $r;
    foreach($columns as $column => $data) {

    	$cell = getNameFromNumber($column);
    	$rowNum = $row+1;

    	if($data === 'Sat' || $data === 'Sun'){
    		$rowNum2 = $row;
    		$worksheet->getStyle($cell.$rowNum)->applyFromArray(
			    array(
			        'font' => array(
			            'color' => array('rgb' => 'FF0000')
			        ),
			    )
			);

			$worksheet->getStyle($cell.$rowNum2)->applyFromArray(
			    array(
			        'font' => array(
			            'color' => array('rgb' => 'FF0000')
			        )
			    )
			);
    	}

    	$worksheet->getStyle($cell.$rowNum)->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		                'color' => array('rgb' => '000000')
		            )
		        )
		    )
		);

		//add 1 row more
		$worksheet->getStyle($cell.($rowNum+1))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		                'color' => array('rgb' => '000000')
		            )
		        )
		    )
		);

        $worksheet->setCellValueByColumnAndRow($column, $row + 1, $data);

    }
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
echo date('H:i:s') , " Done" , EOL;
//
function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}