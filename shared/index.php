<?php 

    include  dirname( __DIR__, 1 ) . "/functions.php";
    $folders = array( "img" => [ "images", "highres" ], "vid" => [ "videos", "original" ], "file" => [ "files", "all" ], "template" => [ "templates", "all" ]);

	if ( $_POST && $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

        $path = "/" . $folders[ $_POST['type'] ][0] . "/" . $_POST['dir'] . "/" . $folders[ $_POST['type'] ][1];
        $count = count( scandir( __DIR__ . $path ) );
        $file = __DIR__ . $path . "/" . sprintf( "%05d", $count );

        if ( $_POST['type'] === "template" ) 
            file_put_contents( $file . ".html", "<style>" . file_get_contents( dirname( __DIR__, 1 ) . "/boilerplate.css" ) . "</style>" . $_POST['template'] );

        if ( $_FILES['file']['name'] ) {
            
            $extension = pathinfo( $_FILES['file']['name'] )['extension'];
            $allowed_extenstions = array( "img" => ["jpg","jpeg","png"], "vid" => ["mp4","mov"], "file" => ["pdf","mp3"] );

            if ( !in_array( strtolower( $extension ), $allowed_extenstions[ $_POST['type'] ] ) ) 
                die( "Bad filetype" );

            move_uploaded_file( $_FILES['file']['tmp_name'], $file . '.' . $extension );

            if ( $_POST['type'] === "img" ) 
                generateThumbs( $file . '.' . $extension );
        }
            
        echo "https://htdocs.dgstesting.com/" . $path . "/" . sprintf( "%05d", $count ) . '.' . $extension;

	} else if ( $_GET && $_GET['hc'] === "00034jidsb938whuf9gi32049" ) {

        ?>
            <html>
                <body>

                    <div class="controlpanel">

                        <form id="form" name="form" method="post" action="index.php" enctype="multipart/form-data" onsubmit="submit(event)">
                            <input type="hidden" name="hc" value="<?php echo $_GET["hc"]; ?>" />
                            <div class="radio">
                                <input type="radio" id="img" name="type" value="img"><label for="img">Image</label>
                                <input type="radio" id="vid" name="type" value="vid"><label for="vid">Video</label>
                                <input type="radio" id="file" name="type" value="file"><label for="file">File</label>
                                <input type="radio" id="template" name="type" value="template"><label for="template">HTML Template</label>
                            </div>
                            <select name="dir">
                                <?php foreach( scandir( __DIR__ . "/images/" ) as $dir ) if( $dir !== "." && $dir !== ".." && $dir !== "index.php" ) echo "<option value='$dir'>$dir</option>"; ?>
                            </select>
                            <input type="file" name="file" />
                            <textarea name="template"></textarea>
                            <input type="submit" name="submit" value="Upload"/>
                        </form>

                        <div class="results">
                            <label>Reponse</label>
                            <input placeholder="..." id="resulta">
                        </div>

                        <div class="linkarea">
                            <a href="images?hc=00034jidsb938whuf9gi32049">Images</a>
                            <a href="videos?hc=00034jidsb938whuf9gi32049">Videos</a>
                            <a href="files?hc=00034jidsb938whuf9gi32049">Files</a>
                            <a href="templates?hc=00034jidsb938whuf9gi32049">Templates</a>
                        </div>

                        <script>
                            async function submit(event) {	
                                event.preventDefault();
                                document.getElementById("form").dataset.loading = "true";
                                    await fetch('', {method: "POST", body: new FormData(document.getElementById("form"))})
                                    .then(response=>response.text())
                                    .then(data=>{ 
                                        document.getElementById("form").dataset.loading = "false";
                                        document.getElementById("resulta").innerHTML = data; 
                                    });
                            }
                        </script>

                    </div>

                </body>
            </html>
        <?php

	} else {

        die( "Unauthorized" );

    }