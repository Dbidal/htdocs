<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "features/nav.php"; ?>

<style>
	nav{padding:20px 0;}
	@media (max-width:599px) {
		.imn6pwchw {flex-wrap: wrap;}
		.imn6pwchw>div {flex-basis: 100% !important;max-width: 100% !important;margin-left: 0px !important;}
	}
</style>
<div class="wp-block-group" style="width: 100%;max-width: 100%;background-color:#363839">
	<div class="wp-block-columns imn6pwchw">
		<div class="hcube-block-column" style="flex-basis:66.66%;max-width:66.66%%;align-self:center">
			<p style="color:white;" >3409 Victoria Avenue Unit 7, Brandon, MB R7B 2L8 | <?php echo $site->place(0,"telephone",array("link" => "tel")); ?> </p>
		</div>
		<div class="hcube-block-column" style="flex-basis:33.33%;max-width:33.33%%;align-self:center">
			<span style="width: 100%;display: inline-block;text-align:right;margin:20px 0;">
				<?php echo $site->place(0,"social",array( "color" => "#ffffff" )); ?>
			</span>
		</div>
	</div>
</div>

<?php $nav = new Nav( $site, array( 'items' => array(
	[ 'Home', '/', '<i class="fas fa-home"></i>' ],
	[ 'Services', '/', '<i class="fas fa-concierge-bell"></i>' ],
	[ 'About', '/', '<i class="fas fa-question-circle"></i>', array(
		[ 'More Info', '/', "", array(
			[ 'New Patients', '/' ],
			[ 'Meat the Team', '/' ],
			[ 'Contact Us', '/', '<i class="fas fa-phone"></i>' ]
		) ],
		[ 'Meat the Team', '/' ],
		[ 'Contact Us', '/' ]
	) ]
) ) ); $nav->print( $site ); ?>

