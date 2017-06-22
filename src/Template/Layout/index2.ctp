<!DOCTYPE html>
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?= $this->fetch('title') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<?php echo $this->Html->script('/assets/global/plugins/pace/pace.min.js'); ?>
<?php echo $this->Html->css('/assets/global/plugins/pace/themes/pace-theme-flash.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/uniform/css/uniform.default.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>

<?php echo $this->Html->css('/assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>

<?php echo $this->Html->css('/assets/global/plugins/select2/select2.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-select/bootstrap-select.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/jquery-multi-select/css/multi-select.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/icheck/skins/all.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>
<!-- END GLOBAL MANDATORY STYLES -->
<?php echo $this->Html->css('/assets/global/plugins/clockface/css/clockface.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>

<!-- BEGIN THEME STYLES -->
<?php echo $this->Html->css('/assets/global/css/components.css'); ?>
<?php echo $this->Html->css('/assets/global/css/plugins.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/layout.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/themes/default.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/custom.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/jquery-notific8/jquery.notific8.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/icheck/skins/all.css'); ?>

<!-- BEGIN PAGE LEVEL STYLES -->
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/typeahead/typeahead.css'); ?>
<!-- END PAGE LEVEL STYLES -->
<style media="print">
	.hide_at_print {
		display:none !important;
	}
</style>
<style>
	.error-message {
		color: red;
		font-style: inherit;
	}
</style>


<style>
.self-table > tbody > tr > td, .self-table > tr > td
{
	border-top:none !important;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
 
    vertical-align:middle !important;
}
option 
{
    border-top:1px solid #CACACA;
    padding:4px;
	cursor:pointer;
}
select 
{
	cursor:pointer;
}
.myshortlogo
{
	font: 15px "Open Sans",sans-serif;
	text-transform: uppercase !important;
	box-sizing:border-box;
}
.toast_success_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px ;
	color: #FFF;
	opacity: 0.8;
	background-color: #42893D;
}
.tost_edit_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px #999;
	color: #FFF;
	opacity: 0.8;
	background-color: #B0B343;	
}
.tost_delete_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px #999;
	color: #FFF;
	opacity: 0.8;
	background-color: #D75C48;
}
</style>
<!-- END THEME STYLES -->
<!-- <link rel="shortcut icon" href="favicon.ico"/> -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-open ">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo" style="padding-top:5px;">
			<span style="color: #cd2831;font-weight: bold;font-size: 17px;" class="myshortlogo">Mogra Group</span>
			<br/><span style="color: #FFF;font-size: 12px;">
			<?php 
			$session = $this->request->session(); 
			echo $this->viewVars['s_company_name'];
			?>
			</span>
			
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<!-- <img alt="" class="img-circle" src="/assets/admin/layout/img/avatar3_small.jpg"/> -->
					<span class="username username-hide-on-mobile" style="color:#F0F0F0;">
					<strong><?php echo $s_employee_name=$this->viewVars['s_employee_name']; ?></strong> </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<?php 
							//
							echo $this->Html->link('<i class="fa fa-random"></i> Switch Company','/Logins/Switch-Company',array('escape'=>false)); ?>
						</li>
						<li>
							<?php echo $this->Html->link('<i class="icon-key"></i> Log Out','/Logins/logout',array('escape'=>false)); ?>
						</li>
					</ul>
				</li>
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- BEGIN INBOX DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END INBOX DROPDOWN -->
				<!-- BEGIN TODO DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END TODO DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN QUICK SIDEBAR TOGGLER -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
			
				<!-- END QUICK SIDEBAR TOGGLER -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->

	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
   	<div class="page-content" >
            <div ng-spinner-bar="" class="page-spinner-bar hide">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
            </div>
			<!-- BEGIN PAGE HEADER-->
		
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
             
			<div class="row">
         
				<div class="col-md-12">
					
					
					<div id="toast-container" class="toast-top-right" aria-live="polite" role="alert">
					<?= $this->Flash->render() ?>
					</div>
					
					<?php //pr($this->viewVars); ?>
					<?php echo $this->fetch('content'); ?>
					<!--here is page content--->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN QUICK SIDEBAR -->

	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 <a href="http://phppoets.com/" target="_blank" style="color:#FFF;">2016 &copy; PHPPOETS IT SOLUTION PVT LTD.</a>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-migrate.min.js'); ?>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<?php echo $this->Html->script('/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.blockui.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.cokie.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/uniform/jquery.uniform.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>
<!-- END CORE PLUGINS -->
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/clockface/js/clockface.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/moment.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-notific8/jquery.notific8.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/ui-notific8.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-toastr/toastr.min.js'); ?>

<?php echo $this->Html->script('/assets/global/plugins/select2/select2.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-select/bootstrap-select.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js'); ?>

<?php echo $this->Html->script('/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>

<?php echo $this->Html->script('/assets/global/scripts/metronic.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/form-icheck.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.pulsate.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/table-managed.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>

<?php echo $this->Html->script('/assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/form-validation.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/ui-general.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>


<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php echo $this->Html->script('/assets/global/plugins/fuelux/js/spinner.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/typeahead/handlebars.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/typeahead/typeahead.bundle.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php echo $this->Html->script('/assets/global/scripts/metronic.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/components-form-tools.js'); ?>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features
	ComponentsFormTools.init();
	UINotific8.init();
	FormValidation.init();
	TableManaged.init();
	ComponentsPickers.init();
	UIGeneral.init();
	FormiCheck.init(); // init page demo
	ComponentsDropdowns.init();
});
</script>
<style>
div[contenteditable="true"]{
	border:1px solid #e5e5e5;padding:5px;box-shadow: none;
}
div[contenteditable="true"]:active{
	border:1px solid #000;
}
</style>
<script>
$("a[role='button']").live('click',function(e){
		e.preventDefault();
	});

$('a[role="button"]').live('click',function(e){
	e.preventDefault();
});

$('.firstupercase').die().live('blur',function(e){
	var str=$(this).val();
	var str2=touppercase(str);
	$(this).val(str2);
});

function touppercase(str){
	str = str.replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	});
	return str;
}

$(".nospace").live("keypress",function(e){
	 if(e.which === 32) 
     return false;
 })

$('input').attr('autocomplete','off');

$('div[contenteditable="true"]').live('keydown blur',function(e) {
    if(e.keyCode === 9) { 
		// now insert four non-breaking spaces for the tab key
       var editor = document.getElementById("editor");
        var doc = editor.ownerDocument.defaultView;
        var sel = doc.getSelection();
        var range = sel.getRangeAt(0);

        var tabNode = document.createTextNode("\u00a0\u00a0\u00a0\u00a0");
        range.insertNode(tabNode);

        range.setStartAfter(tabNode);
        range.setEndAfter(tabNode); 
        sel.removeAllRanges();
        sel.addRange(range);
		
		e.preventDefault();
    }
	var ht=$(this).html();
	var name=$(this).attr('name');
	$('textarea[name="'+name+'"]').text(ht);
});

$('div[contenteditable="true"]').each(function(){
	var ht=$(this).html();
	var name=$(this).attr('name');
	$('textarea[name="'+name+'"]').text(ht);
});
</script>         

 
</div>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>