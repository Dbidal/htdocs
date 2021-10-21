
<style>
	@media (max-width:599px) {
		.footercolumns {flex-wrap: wrap;}
		.footercolumns > div {flex-basis: 100% !important;}
	}
</style>

<div class="wp-block-group" style="background:#dadada;width: 100%;max-width: 100%;padding-top:20px;"></div>
<div class="wp-block-group" style="background:#20202f;max-width:100%;padding:20px;">
	<div class="wp-block-columns footercolumns">
		<div class="hcube-block-column" style="flex-basis:50%">
			<p style="color:#ffffff;font-size:26px;margin-top:25px;margin-bottom:0"><b>GIORGIO CONSTRUCTION&nbsp;INC.</b></p>
			<p style="color:#ffffff;margin-top:0;margin-bottom:0">SPECIALIZING IN WATERPROOFING</p>
		</div>
		<div class="hcube-block-column" style="flex-basis:50%;align-self:center">
			<h4 style="color:#a7a7a7;margin-top:20px;margin-bottom:10px">Contact Us</h4>
			<p style="margin-bottom:0px;margin-top:10px;font-size:14px;color:#a7a7a7;"><b>Email:</b> <?php echo $site->place( 0, "email", array( "link" => "mailto" ) ); ?></p>
			<p style="margin-top:0px;font-size:14px;color:#a7a7a7;"><b>Phone:</b> <?php echo $site->place( 0, "telephone", array( "link" => "tel" ) ); ?></p>
		</div>
	</div>
</div>
<div class="wp-block-group" style="background:#171717;max-width:100%;">
	<div>
		<p style="color:#a7a7a7;font-size:12px;text-align:center;">Copyright <?php echo date("Y"); ?> Giorgio Construction Inc. | Developed by <a href="http://dentalgrowthstrategies.com/">Dental Growth Strategies</a></p>
	</div>
</div>