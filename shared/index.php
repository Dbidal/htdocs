<?php 

    include  dirname( __DIR__, 1 ) . "/functions.php";
    $folders = array( "img" => [ "images", "highres" ], "vid" => [ "videos", "original" ], "file" => [ "files", "all" ], "template" => [ "templates", "all" ]);

	if ( $_POST && $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

        $path = "/" . $folders[ $_POST['type'] ][0] . "/" . $_POST['dir'] . "/" . $folders[ $_POST['type'] ][1];
        $count = count( scandir( __DIR__ . $path ) );
        $file = __DIR__ . $path . "/" . sprintf( "%05d", $count );

        if ( $_POST['type'] === "template" ) {
            file_put_contents( $file . ".html", $_POST['template'] );
			$extension = "html";
		}

        if ( isset( $_FILES['file'] ) && $_FILES['file']['name'] ) {

			$extension = checkFileType( pathinfo( $_FILES['file']['name'] )['extension'], $_POST['type'], array( "img" => ["jpg","jpeg","png"], "vid" => ["mp4","mov"], "file" => ["pdf","mp3"] ) );
            move_uploaded_file( $_FILES['file']['tmp_name'], $file . '.' . $extension );
            if ( $_POST['type'] === "img" ) generateThumbs( $file . '.' . $extension );

        }
            
		if ( !isset( $extension ) || !$extension ) die( "Bad file" );

		$jsonfile = __DIR__ . "/" . $folders[ $_POST['type'] ][0] . "/" . $_POST['dir'] . "/" . $folders[ $_POST['type'] ][0] . ".json";
		$json = json_decode( file_get_contents( $jsonfile ), 1 );
		$json[ sprintf( "%05d", $count ) . '.' . $extension ]["tags"] = $_POST['tags'];
		file_put_contents( $jsonfile, json_encode( $json ) );

        echo "https://htdocs.dgstesting.com/shared/" . $path . "/" . sprintf( "%05d", $count ) . '.' . $extension;

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
                        [data-mode="template"] textarea[name="template"] {display: block;position: absolute;right: 10px;top: 0px;width: 310px;height: 70px;}
						textarea[name="template"] {display: none;}
						textarea[name="tags"] {position: absolute;right: 105px;bottom: 20px;height: 29px;}
						form > label {position: absolute;right: 280px;bottom: 15px;height: 29px;}
						form[data-loading="true"] *,form[data-loading="done"] * {display: none !important;}
						form[data-loading="true"]:before {content: "Uploading";text-align: center;width: 100%;display: block;margin-bottom: 15px;}
						form[data-loading="done"]:before {content: "Complete";text-align: center;width: 100%;display: block;margin-bottom: 15px;color:#00bd00;font-weight:bold;}
                    </style>

                    <div class="controlpanel">

                        <form enctype="multipart/form-data" onsubmit="submitForm(event,this)">
                            <input type="hidden" name="hc" value="<?php echo $_GET["hc"]; ?>" />
                            <div class="radio">
                                <input onchange="radio(this)" checked type="radio" id="img" name="type" value="img"><label for="img">Image</label>
                                <input onchange="radio(this)" type="radio" id="vid" name="type" value="vid"><label for="vid">Video</label>
                                <input onchange="radio(this)" type="radio" id="file" name="type" value="file"><label for="file">File</label>
                                <input onchange="radio(this)" type="radio" id="template" name="type" value="template"><label for="template">HTML Template</label>
                            </div>
                            <select name="dir">
                                <?php foreach( scandir( __DIR__ . "/images/" ) as $dir ) if( $dir !== "." && $dir !== ".." && $dir !== "index.php" ) echo "<option ".("public"==$dir?"selected":"")." value='$dir'>$dir</option>"; ?>
                            </select>
                            <input type="file" name="file" />
                            <textarea name="template"></textarea>
							<label>Tags</label>
                            <textarea name="tags"></textarea>
                            <input type="submit" name="submit" value="Upload"/>
                        </form>

                        <div class="results">
                            <label>Response</label>
                            <div id="resulta"></div>
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

                            function submitForm(event,e) {	
                                event.preventDefault();
                               	e.dataset.loading = "true";
                                    fetch('', {method: "POST", body: new FormData(e)})
                                    .then(response=>response.text())
                                    .then(data=>{ 
                                        e.dataset.loading = "done";
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