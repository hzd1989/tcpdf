<?php
// +------------------------------------------------+
// | http://www.cjango.com                          |
// +------------------------------------------------+
// | 修复BUG不是一朝一夕的事情，等我喝醉了再说吧！  |
// +------------------------------------------------+
// | Author: 小陈叔叔 <Jason.Chen>                  |
// +------------------------------------------------+
namespace Tools;
/**
 * Excel 读取生成工具类
 * @author 小陈叔叔 <Jason.Chen[cjango.com]>
 */
class Excel {

	/**
	 * 读取Excel
	 */
	public static function reader($file) {
		import("Tools.Excel.PHPExcel");
		if (self::_getExt($file) == 'xls') {
			import("Tools.Excel.PHPExcel.Reader.Excel5");
			$PHPReader = new \PHPExcel_Reader_Excel5();
		} elseif (self::_getExt($file) == 'xlsx') {
			import("Tools.Excel.PHPExcel.Reader.Excel2007");
			$PHPReader = new \PHPExcel_Reader_Excel2007();
		} else {
			return false;
		}

		$PHPExcel     = $PHPReader->load($file);
		$currentSheet = $PHPExcel->getSheet(0);
		$allColumn    = $currentSheet->getHighestColumn();
		$allRow       = $currentSheet->getHighestRow();
		for($currentRow = 1; $currentRow <= $allRow; $currentRow++){
			for($currentColumn='A'; $currentColumn <= $allColumn; $currentColumn++){
				$address = $currentColumn.$currentRow;
				$arr[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
			}
		}
		return $arr;
	}

	/**
	 * 获取文件后缀名
	 */
	private static function _getExt($file) {
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	/**
	 * 生成Excel
	 */
	public static function writer($header, $data, $settitle = 'cjango.data', $type = 0) {
		import("Tools.Excel.PHPExcel");
		import("Tools.Excel.PHPExcel.Writer.Excel2007");
		import("Tools.Excel.PHPExcel.IOFactory.php");
		$objPHPExcel = new \PHPExcel();
		$objProps = $objPHPExcel->getProperties();
		//设置表头
		$key = ord("A");
		foreach($header as $v){
			$colum = chr($key);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum.'1', $v);
			$key += 1;
		}
		$column = 2;
		$objActSheet = $objPHPExcel->getActiveSheet();
		foreach($data as $key => $rows){ //行写入
			$span = ord("A");
			foreach($rows as $keyName=>$value) {// 列写入
				$j = chr($span);
				$objActSheet->setCellValue($j.$column, $value);
				$span++;
			}
			$column++;
		}
		$objPHPExcel->getActiveSheet()->setTitle($settitle);
		$objPHPExcel->setActiveSheetIndex(0);
		$fileName = iconv("utf-8", "gb2312", './Data/excel/'.date('Y-m-d_', time()).time().'.xlsx');
		$saveName = iconv("utf-8", "gb2312", '新建数据表.xlsx');
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		if ($type == 0) {
			header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=\"$saveName\"");
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
		} else {
			$objWriter->save($fileName);
			return $fileName;
		}
	}
}