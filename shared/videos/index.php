<?php 

	// - expects ?client or ?public to know what to display, if this doesn't exist, display a list of all options as links
	
    // - displays all as thumbnails (manually entered urls)
    // - edit thumbnail url (save to videos/public/index.json )
    // - edit tags (save to videos/public/index.json )
    // - click to open in new tab
    // - copy links ( original url, compressed url if exists, new Video( url ) with preset poster ) - also at tooltip explaining why new Video() is best

    if ( $_GET['hc'] !== "00034jidsb938whuf9gi32049") die( "Unauthorized" );

?>

<html>

    <body>

        <?php

            $files = scandir( "/highres" );
            foreach( $files as $file ){
        
                echo "<img width='100px' src='https://htdocs.dgstesting.com/shared/images/lowres/$file' />";

            }

        ?>

    </body>

</html>