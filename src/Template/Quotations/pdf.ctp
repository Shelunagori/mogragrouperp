<?php //pr($quotation->employee->signature); exit;
use Cake\Mailer\Email;

require_once(ROOT . DS  .'vendor' . DS  . 'dompdf' . DS . 'autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Lato-Hairline');
$dompdf = new Dompdf($options);

$dompdf = new Dompdf();


$html = '
<html>
<head>
  <style>
    @page { margin: 130px 15px 120px 30px; }
    #header { position: fixed; left: 0px; top: -130px; right: 0px; height: 130px;}
	#footer { position: fixed; left: 0px; bottom: -120px; right: 0px; height: 120px;text-align:center;}
    #footer .page:after { content: content: counter(page); }
	#content{
		position: relative; 
	}
	.img-height{
		height:15;
		text-align:center;
	}
	
	@font-face {
		font-family: Lato;
		src: url("https://fonts.googleapis.com/css?family=Lato");
	}
	p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 1.1;
	}
	table td{
		margin:0;font-family: Lato;font-weight: 100;padding:0;line-height: 1.1;
	}
	table.table_rows tr.odd{
		page-break-inside: avoid;
	}
	
	.table_rows, .table_rows th.main, .table_rows td.main {
	   border: 1px solid  #000;border-collapse: collapse;padding:2px; 
	}
	.itemrow tbody td{
		border-bottom: none;border-top: none;
	}

	.table_rows th{
		font-size:14px;
	}
	.avoid_break{
		page-break-inside: avoid;
	}
	</style>
<body>
  <div id="header">
		<table width="100%">
			<tr>
				<td width="35%" rowspan="2" valign="bottom">
				<img src='.ROOT . DS  . 'webroot' . DS  .'logos/'.$quotation->company->logo.' height="80px" style="height:80px;"/>
				</td>
				<td colspan="2" align="right">
				<span style="font-size: 20px;">'. h($quotation->company->name) .'</span>
				</td>
			</tr>
			<tr>
				<td width="30%" valign="bottom">
				<div align="center" style="font-size: 28px;font-weight: bold;color: #0685a8;">QUOTATION</div>
				</td>
				<td align="right" width="35%" style="font-size: 12px;">
				<span>'. $this->Text->autoParagraph(h($quotation->company->address)) .'</span>
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/telephone.gif height="11px" style="height:11px;margin-top:5px;"/> '. h($quotation->company->mobile_no).'</span> | 
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/email.png height="15px" style="height:15px;margin-top:4px;"/> '. h($quotation->company->email).'</span>
				</td>
			</tr>
			<tr>
				<td colspan="3" >
					<div style="border:solid 2px #0685a8;margin-top: 5px; margin-top:15px;"></div>
				</td>
			</tr>
		</table>
  </div>
  <div id="footer">
	<hr style="width:100%"/>
	<table width="100%" style="text-align:center;font-size:10px;">
		<tr>
			<td  width="100%" colspan="7" align="center"><b style="font-size:12px;"><u>:: Authorised Dealer for Rajasthan ::</u></b></td>
		</tr>
		<tr>
			<td width="25%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/tushaco_pumps.png" class="img-height" />
				<br/>Gear / Screw Pumps
			</td>
			<td width="25%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/johnson_pump.png" class="img-height"/>
				<br/>Centrifugal/Multistage Pumps
			</td>
			<td width="25%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/antico.png" class="img-height" />
				<br/>Non Metallic Pumps
			</td>
			<td width="25%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/darling_pump.png" class="img-height" />
				<br/>Submersible Pumps
			</td>
			<td width="33%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/allweler.png" class="img-height"  />
				<br/>Screw Pumps
			</td>
			<td width="33%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/lightnin.png" class="img-height" />
				<br/>Mixers / Agitators
			</td>
			<td width="34%">
				<img src="'.ROOT . DS  . 'webroot' . DS  .'img/quotation/positive.png" class="img-height" />
				<br/>Dosing / Diaphragm Pumps
			</td>
		</tr>
	</table>
  </div>
	<div id="content"> ';
  
$html .= '
<table width="100%">
		<tr>
			<td width="50%">
				<table width="100%">
					
					<tr>
						<td style="font-size:'. h(($quotation->pdf_font_size)) .';">
							<span>'. h(($quotation->customer->customer_name)) .'</span>
							'.$this->Text->autoParagraph(h($quotation->customer_address)) .'</span>
							
						</td>
					</tr>
				</table>
			</td>
			<td style="font-size:'. h(($quotation->pdf_font_size)) .';" valign="top" width="60%">
				<table width="100%">
					<tr>
						<td >Date</td>
						<td>: '. h($quotation->created_on->format("d-m-Y")) .'</td>
					</tr>
					<tr>
						<td >Ref no</td>
						<td >: '. h(($quotation->qt1.'/QT-'.str_pad($quotation->qt2, 3, '0', STR_PAD_LEFT).'/'.$quotation->qt3.'/'.$quotation->qt4)) .'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<table width="100%">
		<tr>
			<td >
				<table width="100%">
					<tr>
						<td style="font-size:'. h(($quotation->pdf_font_size)) .';"><br/>
							<table>
								<tr>
									<td valign="top" width="10%" >Kind Attn.<br/></td>
									<td valign="top" width="2%">:</td>
									<td>'. h(($quotation->customer_for_attention)) .'<br/></td>
								</tr>
								
								<tr>
									<td valign="top" width="10%">Reference</td>
									<td valign="top"width="2%">:</td>
									<td>'. h($quotation->enquiry_no) .'</td>
								</tr>
								<tr>
									<td valign="top" width="10%">Subject</td>
									<td valign="top" width="2%">:</td>
									<td>'. h(($quotation->subject)) .'</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<br/>
	<table>
		<tr>
				<td style="font-size:'. h(($quotation->pdf_font_size)) .';">Dear Sir,<br/><br/></td>
		</tr>
		<tr>
			<td style="font-size:'. h(($quotation->pdf_font_size)) .';">'. $this->Text->autoParagraph(h($quotation->text)) .'</td>
		</tr>
	</table>
';
 

$html.='<br/>
<table width="100%" class="table_rows itemrow">
	<thead>
		<tr>
			<th style="white-space: nowrap;" class="main">S No</th>
			<th class="main">Item Description</th>
			<th class="main">Unit</th>
			<th class="main">Quantity</th>
			<th class="main">Rate</th>
			<th class="main">Amount</th>
		</tr>
	</thead>
	<tbody id="item_row_body">
';

$sr=0; foreach ($quotation->quotation_rows as $quotationRows): $sr++; 
$html.='
	<tr>
		<td style="font-size:'. h(($quotation->pdf_font_size)) .';" style="padding-top:8px;padding-bottom:5px;" valign="top" align="center" class="main">'. h($sr) .'</td>
		<td style="font-size:'. h(($quotation->pdf_font_size)) .';" style="padding-top:8px;padding-bottom:5px; font-size:16px;" valign="top" width="100%" class="main">'. $quotationRows->description .'<div style="height:'.$quotationRows->height.'"></div></td>
		<td style="font-size:'. h(($quotation->pdf_font_size)) .';" style="padding-top:8px;padding-bottom:5px;" align="center" valign="top"class="main">'. h($quotationRows->item->unit->name) .'</td>
		<td style="font-size:'. h(($quotation->pdf_font_size)) .';" style="padding-top:8px;padding-bottom:5px;" align="center" valign="top" class="main">'. h($quotationRows->quantity) .'</td>
		<td style="font-size:'. h(($quotation->pdf_font_size)) .';" style="padding-top:8px;padding-bottom:5px;" align="right" valign="top"class="main">'. $this->Number->format($quotationRows->rate,[ 'places' => 2]).'</td>
		<td style="font-size:'. h(($quotation->pdf_font_size)) .';" style="padding-top:8px;padding-bottom:5px;" align="right" valign="top" class="main">'. $this->Number->format($quotationRows->amount,[ 'places' => 2]) .'</td>
	</tr>';
endforeach;


$html.='
	</tbody>
	<tfoot>
			<tr>
				<td colspan="5" style="text-align:right;border-top: 1px solid #000;">Total</td>
				<td style="text-align:right;border-top: 1px solid #000;" >'. $this->Number->format($quotation->total,[ 'places' => 2]) .'</td>
			</tr>
		</tfoot>
	</table>';
if(!empty($quotation->additional_note)){
	$html.='
	<div class="avoid_break">
		
		'. $this->Text->autoParagraph('<b>Note:</b><br/>'.h($quotation->additional_note)) .'
	</div><br/>';
}
$html.='
<br/><div class="" style="font-size:'. h(($quotation->pdf_font_size)) .';">
	
		<b><u>Commercial Terms & Conditions:</u></b><br/>
		'. $quotation->terms_conditions .'
	<br/>
	<b>I hope above is to your requirement and in case of any clarification kindly revert back.</b><br/>
	<b>Thanks and Regards,</b><br/>';
	
$html.='
		<div align="left" class="">
			<img src='.ROOT . DS  . 'webroot' . DS  .'signatures/'.$quotation->employee->signature.' height="50px" style="height:50px;"/>
			<br/>
			<span>'. h($quotation->employee->name) .'</span><br/>
			<span>'. h($quotation->employee->designation->name) .'</span><br/>
			<span>'. h($quotation->employee->mobile) .'</span><br/>
			<span>'. h($quotation->employee->email) .'</span>
			</div>
		';
		

	
$html.='</div>'; 

$html .= '</div>
</body>
</html>';

//echo $html; exit;



$name='Quotation-'.h(($quotation->qt1.'_QO'.str_pad($quotation->qt2, 3, '0', STR_PAD_LEFT).'_'.$quotation->qt3.'_'.$quotation->qt4));
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

if($send_email=='true'){
	$to=$emailRecord->send_to;
	$send_to_array=explode(',',$to);
	$to_emails=[];
	foreach($send_to_array as $data){
		$to_emails[$data]='q';
	}
	
	$subject=$emailRecord->subject;
	$message=$emailRecord->message;
	
	$output = $dompdf->output();
	file_put_contents($name, $output);


	$email = new Email();
	$email->transport('SendGrid');

	try {
		$res = $email->from(['ashishbohara1008@gmail.com' => 'ashish'])
			  ->to($to_emails)
			  ->subject($subject)
			  ->attachments([
			$name.'.pdf' => [
				'file' => $name
			]
		])
		->send($message);
			  
	} catch (Exception $e) {

		echo 'Exception : ',  $e->getMessage(), "\n";

	}
}




$dompdf->stream($name,array('Attachment'=>0));
exit(0);

?>