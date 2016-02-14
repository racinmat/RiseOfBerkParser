<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 14. 2. 2016
 * Time: 20:17
 */

require_once "Dragon.php";
require_once __DIR__ . "/vendor/autoload.php";

excelToJson();

function jsonToExcel()
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
			->setCellValue("D$i", $dragon->collectionTime)
			->setCellValue("E$i", $dragon->iron)
			->setCellValue("F$i", $dragon->ironCollectionTime)
			->setCellValue("G$i", $dragon->battleType);
		$i++;
	}


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("Dragons.xlsx");
}

function excelToJson()
{
	$objPHPExcel = PHPExcel_IOFactory::load("Dragons.xlsx");
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	/** @var Dragon[] $dragons */
	$dragons = [];
	$names = array_shift($sheetData);

	//translate column names
	foreach ($sheetData as $index => $array) {
		$sheetData[$index] = [];
		foreach ($array as $key => $value) {
			$sheetData[$index][camelCase($names[$key])] = $value;
		}
	}

	foreach ($sheetData as $dragonData) {
		$dragons[$dragonData["name"]] = new Dragon($dragonData);
	}

	file_put_contents('dragonsTemp.json', json_encode($sheetData, JSON_PRETTY_PRINT));
	file_put_contents('dragon_info.json', json_encode($dragons, JSON_PRETTY_PRINT));
}

function camelCase($str, array $noStrip = [])
{
	// non-alpha and non-numeric characters become spaces
	$str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
	$str = trim($str);
	// uppercase the first character of each word
	$str = ucwords($str);
	$str = str_replace(" ", "", $str);
	$str = lcfirst($str);

	return $str;
}