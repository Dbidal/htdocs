<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "head.php"; ?>

<!-- header -->
<?php include "../blocks/header.php"; ?>

<div class="wp-block-group" style="margin-bottom:50px;background:#f6f6f6;max-width:100%;" >
	<div>
		<h1>Amalgam - Free Restorative Dentistry</h1>
	</div>
</div>
<div class="wp-block-group" style="margin-bottom:50px;">
	<figure class="alignright size-large"><?php new Image( "https://htdocs.dgstesting.com/shared/images/{$site->id}/highres/canstockphoto17278674_web.jpg", "", array( "width" => "450", "height" => "300" ) ); ?></figure>
	<p>Princess Dental provides comprehensive mercury-free and amalgam-free dentistry. Restorative dentistry seeks to repair or replace your natural teeth in order to return your mouth to full functional and aesthetic harmony. The restorative work can range from simple fillings and crowns to more complex root canal therapy and tooth replacement implants. No matter what stage of restorative care your teeth require, we can offer solutions.</p>
</div>

<!-- footer -->
<?php include "../blocks/footer.php"; ?>

<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "foot.php"; ?>
