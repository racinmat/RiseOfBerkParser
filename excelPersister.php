<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 14. 2. 2016
 * Time: 20:17
 */

require_once "Dragon.php";
require_once __DIR__ . "/vendor/autoload.php";

saveToExcel();
function saveToExcel()
{
	$dragonArray = json_decode(file_get_contents('dragon_info.json'), true);
	/** @var Dragon[] $dragons */
	$dragons = [];
	foreach ($dragonArray as $name => $dragon) {
		if (is_array($dragon)) {
			$dragons[$name] = new Dragon($dragon);
		} else {
		}
	}

	$objPHPExcel = new PHPExcel();
	$sheet = $objPHPExcel->setActiveSheetIndex(0);

	$sheet->setCellValue("A1", 'Name')
		->setCellValue("B1", 'Fish per hour')
		->setCellValue("C1", 'Wood per hour')
		->setCellValue("D1", 'Collection time')
		->setCellValue("E1", 'Iron')
		->setCellValue("F1", 'Iron collection time')
		->setCellValue("G1", 'Battle range');

	$i = 2;
	/** @var Dragon $dragon */
	foreach ($dragons as $dragon) {
		$sheet->setCellValue("A$i", $dragon->name)
			->setCellValue("B$i", $dragon->fishPerHour)
			->setCellValue("C$i", $dragon->woodPerHour)
			->setCellValue("D$i", $dragon->collectTime)
			->setCellValue("E$i", $dragon->iron)
			->setCellValue("F$i", $dragon->ironTime)
			->setCellValue("G$i", $dragon->battleType);
		$i++;
	}


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("Dragons.xlsx");
}

function loadFromExcel()
{

}