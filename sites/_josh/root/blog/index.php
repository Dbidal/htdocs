<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "head.php"; ?>
<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "features/nav.php"; ?>
<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "features/blog.php"; ?>


<?php $nav = new Nav( $site, array( "logo" => "https://htdocs.dgstesting.com/shared/images/public/lowres/6250924.jpg" ) ); $nav->print(); ?>

<?php $blog = new Blog( $site, "blog", [ "index.php" ] ); $blog->print(); ?>


<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "foot.php"; ?>
