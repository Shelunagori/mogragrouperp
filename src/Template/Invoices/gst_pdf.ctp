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
		margin:0;font-family: Lato;font-weight: 100;line-height: 12px !important;margin-top:-9px;
	}
	.odd td p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;margin-bottom: -1px;
	}
	.show td p{
			margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;margin-bottom: 1px;
	}
	.topdata p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 17px !important;margin-bottom: 1px;
	}
	table td{
		margin:0;font-family: Lato;font-weight: 100;padding:0;line-height: 1;
	}
	table.table_rows tr.odd{
		page-break-inside: avoid;
	}
	.table_rows, .table_rows th, .table_rows td {
	    border: 1px solid  #000; 
		border-collapse: collapse;
		padding:2px; 
	}
	.itemrow tbody td{
		border-bottom: none;border-top: none;
	}
	
	.table2 td{
		border: 0px solid  #000;font-size: 14px;padding:0px; 
	}
	.table_top td{
		font-size: 12px !important; 
	}
	.table-amnt td{
		border: 0px solid  #000;padding:0px; 
	}
	.table_rows th{
		border: 1px solid  #000;
		font-size:'. h($invoice->pdf_font_size).' !important;
	}
	.table_rows td{
		border: 1px solid  #000;
		font-size:'. h($invoice->pdf_font_size).' !important;
	}
	.avoid_break{
		page-break-inside: avoid;
	}
	.table-bordered{
		border: hidden;
	}
	table.table-bordered td {
		border: hidden;
	}
	
	</style>

<body>
  <div id="header" ><br/>	
		<table width="100%">
			<tr>
				<td width="35%" rowspan="2" valign="bottom">
				<img src='.ROOT . DS  . 'webroot' . DS  .'logos/'.$invoice->company->logo.' height="80px" />
				</td>
				<td colspan="2" align="right">
				<span style="font-size: 20px;">'. h($invoice->company->name) .'</span>
				</td>
			</tr>
			<tr>
				<td width="30%" valign="top">
				<div align="center" style="font-size: 28px;font-weight: bold;color: #0685a8;">TAX INVOICE</div>
				</td>
				<td align="right" width="35%" style="font-size: 12px; " valign="top">
				<span>'. $this->Text->autoParagraph(h($invoice->company->address)) .'</span>
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/telephone.gif height="11px" /> '. h($invoice->company->mobile_no).'</span> | 
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/email.png height="15px" /> '. h($invoice->company->email).'</span>
				</td>
			</tr>
			<!-- <tr>
				<td colspan="3" >
					<div style="border:solid 2px #0685a8;"></div>
				</td>
			</tr>-->
		</table>
  </div>
 

  
  <div id="content"> ';
  
  $html.='
  
<style>	
 

</style>

<table width="100%" class="table_rows itemrow" style="margin-top: -22px;">
	<thead>
		<tr class="show">
			<td align="">';
				$html.='
					<table  valign="center" width="100%"  class="table2">
						<tr>
							<td width="50%" valign="top" text-align="right" >
								<span><b>'. h($invoice->customer->customer_name) .'</b></span><br/>
								<div style="height:5px;"></div>
								'. $this->Text->autoParagraph(h($invoice->customer_address));
                                if(!empty($invoice->customer->gst_no))
								{
									$html.='<span>GST  : '. h($invoice->customer->gst_no).  '</span>';
								}
								$html.='<span>PAN : '. h($invoice->customer->pan_no) .'</span><br/>
								
							</td>
							<td style="white-space:nowrap"  width="40%" valign="top" text-align="right" >
								<table width="100%">
									<tr>
										<td valign="top" style="vertical-align: top;">Invoice No.</td>
										<td  valign="top">:</td>
										<td valign="top">'. h(($invoice->in1." / IN-".str_pad($invoice->in2, 3, "0", STR_PAD_LEFT)." / ".$invoice->in3." / ".$invoice->in4)) .'</td>
									</tr>
									<tr>
										<td valign="top" style="vertical-align: top;">Date</td>
										<td valign="top">:</td>
										<td valign="top">'. h(date("d-m-Y",strtotime($invoice->date_created))) .'</td>
									</tr>
									<tr>
										<td valign="top" style="vertical-align: top;">LR No.</td>
										<td valign="top">:</td>
										<td valign="top" style="vertical-align: top;">'. h($invoice->lr_no) .'</td>
									</tr>
									<tr>
										<td valign="top" style="vertical-align: top;">Carrier</td>
										<td valign="top">:</td>
										<td valign="top" ><p>'. h($invoice->transporter->transporter_name) .'</p></td>
									</tr>
									<tr>
										<td valign="top" style="vertical-align: top;"></td>
										<td valign="top">:</td>
										<td width="25%" valign="top">'. h($invoice->delivery_description) .'</td>
									</tr>
								</table>
							</td>
						</tr>
						
				</table>
			</td>
		</tr>
		<tr>
			<td style="font-size:'. h(($invoice->pdf_font_size)) .'; border-top:1px solid #000;" >
			Your Purchase Order No.'. h($invoice->customer_po_no) .' dated '. h(date("d-m-Y",strtotime($invoice->po_date))) .'
			</td>
		</tr>
	</thead>
</table>'; 
$gst_hide="style:display:;";
			  $igst_hide="style:display:;" ;
			  $tr2_colspan=15;
			  $tr3_colspan=10; 
			  $tr4_colspan=7; 
	if($invoice->customer->district->state!="Rajasthan"){
		$gst_hide="display:none;" ;
		$tr2_colspan=12;
		 $tr3_colspan=8; 
		 $tr4_colspan=5;
	}else{
		$tr2_colspan=14;
		 $tr3_colspan=8; 
		 $tr4_colspan=5;
		$igst_hide="display:none;" ;
	}
//echo $igst_hide;
$html.='
<table width="100%" class="table_rows ">
		<thead>
			<tr>
				<th rowspan="2" style="text-align: bottom;">Sr.No. </th>
				<th style="text-align: center;" rowspan="2" width="100%">Items</th>
				<th style="text-align: center;" rowspan="2"  >Quantity</th>
				<th style="text-align: center;" rowspan="2" >Rate</th>
				<th style="text-align: center;" rowspan="2" > Amount</th>
				<th style="text-align: center;" colspan="2" >Discount</th>
				<th style="text-align: center;" colspan="2" >P&F </th>
				<th style=" text-align: center;" rowspan="2" >Taxable Value</th>
				<th style="'.$gst_hide.'"';$html.='text-align: center;" colspan="2">CGST</th>
				<th style="'.$gst_hide.'"';$html.='text-align: center;" colspan="2" >SGST</th>
				<th style="'.$igst_hide.'"';$html.='text-align: center;" colspan="2" >IGST</th>
				<th style="text-align: center;" rowspan="2" >Total</th>
			</tr>
			<tr> <th style="text-align: center;" > %</th>
				<th style="text-align: center;">Amt</th>
				<th style="text-align: center;" > %</th>
				<th style="text-align: center;" >Amt</th>
				<th style="'.$gst_hide.'"';$html.='text-align: center;" > %</th>
				<th style="'.$gst_hide.'"';$html.='text-align: center;" >Amt</th>
				<th style="'.$gst_hide.'"';$html.='text-align: center;" > %</th>
				<th style="'.$gst_hide.'"';$html.='text-align: center;" >Amt</th>
				<th style="'.$igst_hide.'"';$html.='text-align: center; " >%</th>
				<th style="'.$igst_hide.'"';$html.='text-align: center;" >Amt</th>
			</tr>
		</thead>
		<tbody>
';

$sr=0; $h="-"; $total_taxable_value=0; foreach ($invoice->invoice_rows as  $invoiceRows): $sr++; 
$html.='
	<tr class="odd">
		<td style="padding-top:8px;padding-bottom:5px;" valign="top" align="center" >'. h($sr) .'</td>
		<td style="padding-top:8px;padding-bottom:5px;line-height:20px " valign="top"><span>'.$invoiceRows->description .'<div style="height:'.$invoiceRows->height.'"></div></span></td>
		<td style="padding-top:8px;padding-bottom:5px;" valign="top" align="center">'. h($invoiceRows->quantity) .'</td>
		<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->rate,[ 'places' => 2]) .'</td>
		<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->amount,[ 'places' => 2]) .'</td>';
		
		if($invoiceRows->discount_amount==0){ 
		$html.='
			<td style="padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->discount_percentage) .'%</td>
			<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->discount_amount,[ 'places' => 2]) .'</td>';	
		}
		
		if($invoiceRows->pnf_amount==0){ 
		$html.='
			<td style="padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->pnf_percentage) .'%</td>
			<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->pnf_amount,[ 'places' => 2]) .'</td>';	
		
		}
		
		$html.='
		<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->taxable_value,[ 'places' => 2]) .'</td>';
		if($invoiceRows->cgst_amount==0){ 
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format(@$cgst_per[$invoiceRows->id]['tax_figure']) .'%</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->cgst_amount,[ 'places' => 2]) .'</td>';
		}
		if($invoiceRows->sgst_amount==0){ 
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format(@$sgst_per[$invoiceRows->id]['tax_figure']) .'%</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->sgst_amount,[ 'places' => 2]) .'</td>';
		}
		if($invoiceRows->igst_amount==0){ 
		$html.='
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format(@$igst_per[$invoiceRows->id]['tax_figure']) .'%</td>
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->igst_amount,[ 'places' => 2]) .'</td>';
		}
		$html.='

		<td style="padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format($invoiceRows->row_total,[ 'places' => 2]) .'</td>
	</tr>';
	$total_taxable_value+=$invoiceRows->taxable_value;
endforeach; 
$fright_total=$invoice->fright_amount+$invoice->fright_cgst_amount+$invoice->fright_sgst_amount+$invoice->fright_igst_amount;
if($invoice->fright_amount != 0){ 
$html.='<tr>
			<td style="padding-top:8px;padding-bottom:5px;" valign="top" align="right" colspan="9" >Freight  Amount</td>
			<td style="padding-top:8px;padding-bottom:5px;" valign="top" align="right"  >'. $this->Number->format($invoice->fright_amount,[ 'places' => 2]) .'</td>';
		
		if($invoice->fright_cgst_amount==0){ 
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format(@$fright_ledger_cgst->tax_figure) .'%</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" valign="top" align="right"  >'. $this->Number->format($invoice->fright_cgst_amount,[ 'places' => 2]) .'</td>';
		}
		
		if($invoice->fright_sgst_amount==0){ 
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format(@$fright_ledger_sgst->tax_figure) .'%</td>
			<td style="'.$gst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" valign="top" align="right"  >'. $this->Number->format($invoice->fright_sgst_amount,[ 'places' => 2]) .'</td>';
		}
		
		if($invoice->fright_igst_amount==0){ 
		$html.='
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="center" valign="top">'. h($h) .'</td>';
		}else{
		$html.='
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" align="right" valign="top">'. $this->Number->format(@$fright_ledger_igst->tax_figure) .'%</td>
			<td style="'.$igst_hide.'"';$html.='padding-top:8px;padding-bottom:5px;" valign="top" align="right"  >'. $this->Number->format($invoice->fright_igst_amount,[ 'places' => 2]) .'</td>';
		}
		$html.='	
			
			<td style="padding-top:8px;padding-bottom:5px;" valign="top" align="right"  >'. $this->Number->format($fright_total,[ 'places' => 2]) .'</td>
		</tr>';
}
	$html.='</tbody>';
$html.='</table>';
	
$grand_total=explode('.',$invoice->grand_total);
$rupees=$grand_total[0];
$paisa_text='';
if(sizeof($grand_total)==2)
{
	$grand_total[1]=str_pad($grand_total[1], 2, '0', STR_PAD_RIGHT);
	$paisa=(int)$grand_total[1];
	$paisa_text=' and ' . h(ucwords($this->NumberWords->convert_number_to_words($paisa))) .' Paisa';
}else{ $paisa_text=""; }

$basic_value=$invoice->fright_amount+$total_taxable_value;
$html.='
<table width="100%" class="table_rows" >
	<tbody>
			<tr>
				<td  width="75%">
					<b style="font-size:13px;"><u>Our Bank Details</u></b>
					<table width="100%" class="table2">
						<tr>
							<td width="" style="white-space: nowrap;">Bank Name</td>
							<td  style="white-space: nowrap;">: '.h($invoice->company->company_banks[0]->bank_name).'</td>
							<td  >Branch</td>
							<td style="white-space: nowrap;">: '.h($invoice->company->company_banks[0]->branch).'</td>
						</tr>
						
						<tr>
							<td  style="white-space: nowrap;">Account No</td>
							<td style="white-space: nowrap;">: '.h($invoice->company->company_banks[0]->account_no).'</td>
							<td >IFSC Code</td>
							<td  style="white-space: nowrap;">: '.h($invoice->company->company_banks[0]->ifsc_code).'</td>
						</tr>
						
					</table>
				</td>
				
				<td  width="25%">
					<table width="100%" class="table2">
					<tr>
							<td >Total</td>
							<td>:</td>
							<td style="text-align:right;" valign="">'. $this->Number->format($basic_value,[ 'places' => 2]) .'</td>
						</tr>';
					if($invoice->total_igst_amount == 0){
					$html.='
							<tr>
								<td  >Total CGST</td>
								<td>:</td>
								<td style="text-align:right;" valign="">'. $this->Number->format($invoice->total_cgst_amount,[ 'places' => 2]) .'</td>
								
							</tr>
							<tr>
								<td  >Total SGST</td>
								<td>:</td>
								<td style="text-align:right;" valign="">'. $this->Number->format($invoice->total_sgst_amount,[ 'places' => 2]) .'</td>
							</tr>';
					}else{
						$html.='
							<tr>
								<td  >Total IGST</td>
								<td>:</td>
								<td style="text-align:right;" valign="">'. $this->Number->format($invoice->total_igst_amount,[ 'places' => 2]) .'</td>
							</tr>';
						}
						$html.='
						<tr>
							<td >Grand Total</td>
							<td>:</td>
							<td style="text-align:right;" valign="">'. $this->Number->format($invoice->grand_total,[ 'places' => 2]) .'</td>
						</tr>
						</table>
				</td>
			</tr>
		</tbody>
	</table>
	<table width="100%" class="table_rows ">
		<tr>
			<td valign="top" width="18%">Amount in words</td>
			<td  valign="top"> '. h(ucwords($this->NumberWords->convert_number_to_words($rupees))) .'  Rupees ' .h($paisa_text).'</td>
		</tr>
		<tr>
			<td valign="top" width="18%">Additional Note</td>
			<td  valign="top" class="topdata">'. $this->Text->autoParagraph($invoice->additional_note).'</td>

		</tr>
		
		<tr>
				<td colspan="2" >
					<table width="100%" class="table2" >
						<tr>
							<td  >
								<table>
									<tr>
										<td style="line-height:20px" >Interest @15% per annum shall be charged if not paid  with in agreed terms. <br/> Invoice is Subject to Udaipur jurisdiction</td>
									</tr>
								</table>
								<table>
									<tr>
										<td >GST</td>
										<td >: '. h($invoice->company->gst_no) .'</td>
									</tr>
									<tr width="30">
										<td >PAN</td>
										<td >: '. h($invoice->company->pan_no) .'</td>
									</tr>
									<tr>
										<td >CIN</td>
										<td >: '. h($invoice->company->cin_no) .'</td>
									</tr>
								</table>
							</td>
							<td align="right" >
								<div align="center">
									<span>For <b>'. h($invoice->company->name) .'</b></span><br/>
									<img src='.ROOT . DS  . 'webroot' . DS  .'signatures/'.$invoice->creator->signature.' height="50px" style="height:50px;"/>
									<br/>
									<span><b>Authorised Signatory</b></span><br/>
									<span>'. h($invoice->creator->name) .'</span><br/>
									
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
	</table>
	
			';

 $html .= '
</body>
</html>';

//echo $html; exit; 

$name='Invoice-'.h(($invoice->in1.'_IN'.str_pad($invoice->in2, 3, '0', STR_PAD_LEFT).'_'.$invoice->in3.'_'.$invoice->in4));
$dompdf->loadHtml($html);
$dompdf->set_paper('letter', 'landscape');
//$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($name,array('Attachment'=>0));
exit(0);
?>
