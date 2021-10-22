<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "head.php"; ?>
<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "features/nav.php"; ?>


<?php $nav = new Nav( array( "logo" => "https://htdocs.dgstesting.com/shared/images/public/lowres/6250924.jpg" ) ); $nav->print( $site ); ?>




<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "foot.php"; ?>
