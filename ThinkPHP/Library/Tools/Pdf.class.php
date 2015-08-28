<?php

namespace Tools;
/**
 * Tcpdf 转pdf文件类
 * @author hzd
 */
class Pdf {

	/**
	 * @param string $html 要转为pdf的内容
	 * @param string $filename 文件名
	 * @param string $type 'I'在页面中显示;'D'直接下载
	 */
	public static function pdf($html,$filename='hzd.pdf',$type='I') {
		import("Tools.TCPDF.TCPDF");
		import("Tools.TCPDF.config.tcpdf_config.php");
		$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('HZD'); 
		$pdf->SetTitle('HZD');
		$pdf->SetSubject('HZD');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false); //不显示头部
		$pdf->setPrintFooter(false); //不显示底部

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// ---------------------------------------------------------
		// set font
		$pdf->SetFont('stsongstdlight', '', 20);
		// add a page
		$pdf->AddPage();
	
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');
		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output($filename, $type);
	}
}