<?php 

	// - expects ?client or ?public to know what to display, if this doesn't exist, display a list of all options as links

    // - generate thumbnails if not exist
    // - hover for full res
    // - copy links ( fullres url, medres url, thumb url, new Image( url ) with preset width height ) - also at tooltip explaining why new Image() is best
    // - edit alt tag (save to images/public/index.json )

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