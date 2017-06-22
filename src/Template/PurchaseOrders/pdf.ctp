<?php 
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
  @page { margin: 150px 15px 10px 30px; }

  body{
    line-height: 20px;
	}
	
    #header { position:fixed; left: 0px; top: -150px; right: 0px; height: 150px;}
    
	#content{
    position: relative; 
	}
	
	@font-face {
		font-family: Lato;
		src: url("https://fonts.googleapis.com/css?family=Lato");
	}
	p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 1;
	}
	table td{
		margin:0;font-family: Lato;font-weight: 100;padding:0;line-height: 1;
	}
	table.table_rows tr.odd{
		page-break-inside: avoid;
	}
	.table_rows, .table_rows th, .table_rows td {
	   border: 1px solid  #000;border-collapse: collapse;padding:2px; 
	}
	.itemrow tbody td{
		border-bottom: none;border-top: none;
	}
	
	.table2 td{
		border: 0px solid  #000;font-size: 14px;padding:0px; 
	}
	.table3 {
		margin-top:-5px; border-top: none; 
	}
	
	.table-amnt td{
		border: 0px solid  #000;padding:0px; 
	}
	.table_rows th{
		font-size:14px;
	}
	.avoid_break{
		page-break-inside: avoid;
	}
	tr.noBorder > td {
		border:0;
		
	}
	tr.Borderbottom > td {
		border-bottom:0;
		
	}
	</style>
<body>
  <div id="header" ><br/>	
		<table width="100%">
			<tr>
				<td width="35%" rowspan="2" valign="bottom">
				<img src='.ROOT . DS  . 'webroot' . DS  .'logos/'.$purchaseOrder->company->logo.' height="80px" style="height:80px;"/>
				</td>
				<td colspan="2" align="right">
				<span style="font-size: 20px;">'. h($purchaseOrder->company->name) .'</span>
				</td>
			</tr>
			<tr>
				<td width="30%" valign="bottom">
				<div align="center" style="font-size: 20px;font-weight: bold;color: #0685a8;">PURCHASE ORDER</div>
				</td>
				<td align="right" width="35%" style="font-size: 12px;">
				<span>'. $this->Text->autoParagraph(h($purchaseOrder->company->address)) .'</span>
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/telephone.gif height="11px" style="height:11px;margin-top:5px;"/> '. h($purchaseOrder->company->mobile_no).'</span> | 
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/email.png height="15px" style="height:15px;margin-top:4px;"/> '. h($purchaseOrder->company->email).'</span>
				</td>
			</tr>
			<tr>
				<td colspan="3" >
					<div style="border:solid 2px #0685a8;margin-top: 5px; margin-top:15px;"></div>
				</td>
			</tr>
		</table>
  </div>
 
<div id="content"> ';
  

$html.='

<table width="100%" class="table_rows table3">
		<tr>
			<td colspan=2 width="300" align="" >
					<table >
						<tr>
							<td style="border-left:none; border-right:none; border-top:none; border-bottom:none;" width="45%" style="font-size:13px";> 
								<table class="table2" >
									<tr>
										<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">
											<span><b>'. h($purchaseOrder->vendor->company_name) .'</b></span><br/>
											<div style="height:5px;"></div>
											'. $this->Text->autoParagraph(h($purchaseOrder->vendor->address)) .'
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
			<td colspan=4 align="" >
					<table class="table2">
						<tr>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';"  width="55" valign="top" style="vertical-align: top;">PO No.</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" width="25" valign="top">:</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';"  valign="top">'. h(($purchaseOrder->po1.'/PO-'.str_pad($purchaseOrder->po2, 3, '0', STR_PAD_LEFT).'/'.$purchaseOrder->po3.'/'.$purchaseOrder->po4)) .'</td>
						</tr>
						<tr>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top" style="vertical-align: top;">Date</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">:</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">'. h(date("d-m-Y",strtotime($purchaseOrder->date_created))) .'</td>
						</tr>
						<tr>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top" style="vertical-align: top;">TIN</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">:</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">'. h($purchaseOrder->company->tin_no) .'</td>
						</tr>
						<tr>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top" style="vertical-align: top;">PAN</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">:</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">'. h($purchaseOrder->company->pan_no) .'</td>
						</tr>
						<tr>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top" style="vertical-align: top;">CIN</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">:</td>
							<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" valign="top">'. h($purchaseOrder->company->cin_no) .'</td>
						</tr>
					</table>
			</td>
		</tr>
		
		<tr>
			<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" colspan=6 style="border-top:1px solid #000;  text-align: justify;">
			'. $this->Text->autoParagraph(h($purchaseOrder->descryption)) .'
			</td>
		</tr>
	</table>
	<table width="100%" class="table_rows table3">
		<tr>
			<th style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">S No</th>
			<th style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">Item</th>
			<th style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">Unit</th>
			<th style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">Quantity</th>
			<th style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">Rate</th>
			<th style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">Amount</th>
		</tr>

';
$sr=0; foreach ($purchaseOrder->purchase_order_rows as $purchase_order_rows): $sr++; 
$html.='
	<tr class="odd Borderbottom">
		<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" style="padding-top:10px;" valign="top" align="center" width="5%">'. h($sr) .'</td>
		<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';"  style="padding-top:10px;" width="100%">'. h($purchase_order_rows->item->name) .
		'<br/><br/>'.$purchase_order_rows->description.'<div style="height:'.$purchase_order_rows->height.'"></div></td>
		<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" style="padding-top:10px;" valign="top" align="center">'. h($purchase_order_rows->item->unit->name) .'</td>
		<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" style="padding-top:10px;" valign="top" align="center">'. h($purchase_order_rows->quantity) .'</td>
		<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" style="padding-top:10px;" align="right" valign="top">'. $this->Number->format($purchase_order_rows->rate,[ 'places' => 2]) .'</td>
		<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" style="padding-top:10px;" align="right" valign="top">'. $this->Number->format($purchase_order_rows->amount,[ 'places' => 2]) .'</td>
	</tr>';
	
endforeach; 

$total=explode('.',$purchaseOrder->total);
$rupees=$total[0];
$paisa_text="";
if(sizeof($total)==2){
	$total[1]=str_pad($total[1], 2, '0', STR_PAD_RIGHT);
	$paisa=(int)$total[1];
	$paisa_text=' and'. h(ucwords($this->NumberWords->convert_number_to_words($paisa))) .' Paisa';
}else{ $paisa=""; }

$html.='</table>';


	$html.='
	<table width="100%" class="table_rows">
		<tbody>
				<tr>
					
					<td  width="100%" style="text-align:right; font-size:'. h(($purchaseOrder->pdf_font_size)) .';">Total</td>
					<td  style="text-align:right; font-size:'. h(($purchaseOrder->pdf_font_size)) .';">'. $this->Number->format($purchaseOrder->total,[ 'places' => 2]).'</td>
				</tr>
					
				
				<tr>
					<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" colspan="2"><b>Amount in words :   </b> '.  h(ucwords($this->NumberWords->convert_number_to_words($rupees))) .'  Rupees  '. h($paisa_text) .'</td>
				</tr>
			</tbody>
		</table>';

$html .= '	<table width="100%" class="table_rows table3">
  <tr>
    <td valign="top"  width="39%" rowspan="2" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>Material to be transported to :</b><br/>'. h(($purchaseOrder->material_to_be_transported)) .'</td>
    <td valign="top" rowspan="2" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>Sale Tax :</b><br/>'. h(($purchaseOrder->sale_tax_description)) .'</td>
    <td valign="top" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"> <p><b>Discount : </b><span style="padding-left:7px;">'. h($purchaseOrder->discount) .''. h(($purchaseOrder->discount_type)).'</span></p>
   
    </td>
  </tr>
  <tr>
  <td style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><p><b>P & F : </b><span style="padding-left:7px;">'. h($purchaseOrder->pnf) .'</span></p></td>
  </tr>
  <tr>
    <td valign="top" style="text-align:center; padding-top:7px; padding-bottom:7px; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>LR to be prepared in favour of :<br/></b><span style="padding:17px;">'. h(($purchaseOrder->lr_to_be_prepared_in_favour_of)) .'</span></td>
    <td valign="top" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>Payment Terms :</b><br/>'. h(($purchaseOrder->payment_terms)) .'</td>
    <td valign="top" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>Excise Duty : </b><span style="padding-left:7px;">'. h(( $purchaseOrder->excise_duty)) .'</span></td>
   
  </tr>
  <tr>
    <td  style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>Road Permit Form : </b><br/>'. h(($purchaseOrder->road_permit_form47)) .'</td>
    <td valign="top" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';"><b>Transporter Name :</b><br/>'. h(($purchaseOrder->transporter->transporter_name)) .'</td>
    <td valign="top" style="text-align:center; font-size:'. h(($purchaseOrder->pdf_font_size)) .';" ><b>Delivery : </b><br/>'. h(($purchaseOrder->delivery)) .'</td>
</tr>
<tr>';
	if($purchaseOrder->is_exceise_for_customer=='Yes'){
	$html.='<td valign="top" style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';" >
		<b style="text-decoration: underline;">Excise Invoice Required in Favour of Consignee:</b>
				'. h($purchaseOrder->customer->customer_name) .'<br/>
				'. h($purchaseOrder->customer->customer_address[0]->address) .'<br/>
				ECC : '. h($purchaseOrder->customer->ecc_no) .'<br/>
				TIN : '. h($purchaseOrder->customer->tin_no) .'<br/>
		</td>';
}else{ $html.='<td valign="top" style="font-size:13px;" >
		
		</td>'; }
$html.='<td valign="top" colspan="2" style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">
		Please confirm that you have registered this order and request you to return back the duplicate copy duly signed in token of having accepted the order.<br/><br/>
		<table width="100%" class="table2">
			<tr>
			<td width="10%"></td>
			<td style="font-size:'. h(($purchaseOrder->pdf_font_size)) .';">
				<div  align="center">
								<span>For <b>'. h($purchaseOrder->company->name) .'</b></span><br/>
									<img src='.ROOT . DS  . 'webroot' . DS  .'signatures/'.$purchaseOrder->creator->signature.' height="50px" style="height:50px;"/>
									<br/>
									<span><b>Authorised Signatory</b></span><br/>
									<span>'. h($purchaseOrder->creator->name) .'</span><br/>
									
							</div>
			</td>
			</tr>
		</table>
							
		</td>
	</tr>
</table>
';





 $html .= '</div>
</body>
</html>';

//echo $html; exit; 

$name="po";
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($name,array('Attachment'=>0));
exit(0);
?>