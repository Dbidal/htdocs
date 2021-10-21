<?php

	include dirname( __DIR__, 2 )."/objects.php"; 

	echo "<style>" . file_get_contents( dirname( __DIR__, 2 )."/boilerplate.css" ) . "</style>";

	$site = new Site( null );
	$page = new Page( $site );