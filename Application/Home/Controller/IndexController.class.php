<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$html = '<table><tr>
			<td>姓名</td>
			<td>年龄</td>
		</tr>
		<tr>
			<td>黄志东</td>
			<td>26</td>
		</tr>
		<tr>
			<td>胡涛涛</td>
			<td>24</td>
		</tr></table>';
        $pdf = new \Tools\Pdf();
        $pdf->pdf($html);
    }
}