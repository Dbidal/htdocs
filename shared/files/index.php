<?php 

	// - expects ?client or ?public to know what to display, if this doesn't exist, display a list of all options as links

    // - displays all as thumbnails, which are just presets based on filetype
    // - click to open in new tab
    // - copy link

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