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

                    <style>
                        .controlpanel {background: white;width: 600px;max-width: 100%;margin: auto;padding: 26px;border-radius: 9px;border-top: 7px solid #85a5e6;box-shadow: 0 20px 40px -35px;margin-top: 20vh;position: relative;}
                        body {background: #e6e7ea;font-family: arial;}
                        form{position: relative;border-bottom: 1px solid;padding-bottom: 10px;}
                        .radio label {position: absolute;margin: -25px 36px;}
                        .radio input {display: block;margin: 10px;}
                        input[type="submit"] {position: absolute;right: 0px;bottom: 20px;}
                        select {padding: 5px 10px;margin: 10px;width: 200px;}
                        .results {width: 50%;display: inline-block;margin: 0 10px;}
                        .linkarea {right: 30px;position: absolute;display: inline-block;text-align: right;}
                        .linkarea a {margin: 5px;}
                        .results input {border: none;}
                        input[type="file"] {position: absolute;right: 10px;top: 20px;width: 310px;border-right: 1px solid black;}
                        ::file-selector-button, input[type="submit"] {background: #4875d2;border: none;padding: 7px 20px;color: white;margin: 0 10px;cursor: pointer;}
                        ::file-selector-button:hover, input[type="submit"]:hover {background: #2d56ac;}
                        [data-mode="template"] input[type="file"] {display: none;}
                        [data-mode="template"] textarea {display: block;position: absolute;right: 10px;top: 0px;width: 310px;height: 70px;}
                        textarea {display: none;}
                    </style>

                    <div class="controlpanel">

                        <form id="form" name="form" method="post" action="index.php" enctype="multipart/form-data" onsubmit="submit(event)">
                            <input type="hidden" name="hc" value="<?php echo $_GET["hc"]; ?>" />
                            <div class="radio">
                                <input onchange="radio(this)" checked type="radio" id="img" name="type" value="img"><label for="img">Image</label>
                                <input disabled onchange="radio(this)" type="radio" id="vid" name="type" value="vid"><label for="vid">Video</label>
                                <input disabled onchange="radio(this)" type="radio" id="file" name="type" value="file"><label for="file">File</label>
                                <input disabled onchange="radio(this)" type="radio" id="template" name="type" value="template"><label for="template">HTML Template</label>
                            </div>
                            <select name="dir">
                                <?php foreach( scandir( __DIR__ . "/images/" ) as $dir ) if( $dir !== "." && $dir !== ".." && $dir !== "index.php" ) echo "<option value='$dir'>$dir</option>"; ?>
                            </select>
                            <input type="file" name="file" />
                            <textarea name="template"></textarea>
                            <input type="submit" name="submit" value="Upload"/>
                        </form>

                        <div class="results">
                            <label>Response</label>
                            <input placeholder="..." id="resulta">
                        </div>

                        <div class="linkarea">
                            <a href="images?hc=00034jidsb938whuf9gi32049">Images</a>
                            <a href="videos?hc=00034jidsb938whuf9gi32049">Videos</a>
                            <a href="files?hc=00034jidsb938whuf9gi32049">Files</a>
                            <a href="templates?hc=00034jidsb938whuf9gi32049">Templates</a>
                        </div>

                        <script>
                            function radio(e){
                                e.parentNode.parentNode.dataset.mode = e.id;
                            }

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