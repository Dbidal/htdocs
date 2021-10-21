<?php 

    include dirname( __DIR__, 2 ) . "/functions.php";
	$client = isset( $_GET["client"] ) ? $_GET["client"] : "public";
	$jsonfile = __DIR__ . "/$client/files.json";
    $json = file_exists( $jsonfile ) ? json_decode( file_get_contents( $jsonfile ), 1 ) : [];

	if ( $_POST && $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

        $json[$_POST["file"]]["tags"] = $_POST["tags"];
        file_put_contents( $jsonfile, json_encode( $json ) );
		echo "Success";

	} else if ( $_GET && $_GET['hc'] === "00034jidsb938whuf9gi32049" ) {

		?>

            <html>
                <body>

					<style>

						.gallery {display: grid;grid-template-columns: auto 350px;    padding-bottom: 500px;}
						.gallery * {font-family: arial;}
						.controls {grid-area: 1 / 1 / 1 span / 2 span;border-bottom: 1px solid;padding: 10px;}
						.filebox:not([hidden]) {display: inline-block;width: 200px;}
						.filebox[data-clicked="true"] {outline: 4px solid;}
						.data {display: none;position: absolute;border: 1px solid;padding: 10px;width: 350px;background: white;margin: -10px 10px;box-shadow: 0 30px 100px 10px;border-radius: 4px;border-top: 6px solid;}
						.thumbnail {width: 200px;}
						.copybox {margin: 4px 0;font-size: 12px;text-align: right;overflow: hidden;position: relative;}
						.copybox:before {content: '';display: block;position: absolute;background: white;height: 100%;width: 10px;left: 0;z-index: 1;}
						.copybox input {display: inline-block;width: 2065px;padding: 4px 10px;border: none;border-left: 1px solid;margin: 0 10px;text-align: right;right: 0;position: absolute;}
						.copybox label {display: inline-block;width: 80px;text-align: right;position: relative;background: white;padding: 5px 10px 5px 0px;margin-right: 250px;z-index: 1;font-weight: bold;border-right: 1px solid;}
						.tags {display: grid;padding: 6px 6px 3px;grid-template-columns: 100%;}
						.tags textarea {grid-area: 1 / 1;padding: 4px 10px;height: 100px;}
						.tags button{width:200px;font-size: 12px;margin: 5px 0 0 0;}
						.filter, .dir {display: inline-block;margin-left: 20px;}
						.dir {padding:2px;}
						.preview {position: sticky;top: 0;}
						.copy {padding: 10px 0;}
						.filebox:hover:not([data-clicked="true"]) {outline:2px solid;}
						.thumbnail > .thumbnail:before {display: block;width: 0;height: 0;width: 100%;text-align: center;margin-top: -5px;font-size: 28px;}
						.thumbnail[data-type="pdf"] > .thumbnail:before {content: '❐';}
						.thumbnail[data-type="mp3"] > .thumbnail:before {content: '♫';}
						.thumbnail > .thumbnail {border: 2px double gray;height: 30px;}
						.thumbnailtags{    min-height: 30px;max-height: 100px;padding: 7px;margin: 2px;box-sizing: border-box;display: block;border: 1px solid lightgray;width: 200px;overflow: hidden;font-size: 12px;}

					</style>

					<div class="gallery">

						<div class="controls">
							<a href="../?hc=<?php echo $_GET["hc"]; ?>">↖ Back</a>
							<div class="filter">
								<label>Filter By Tag</label>
								<input onkeyup="filter(this)">
							</div>
                            <select class="dir" onchange="navigate(this)">
                                <?php foreach( scandir( "." ) as $dir ) if( $dir !== "." && $dir !== ".." && $dir !== "index.php" ) echo "<option ".("public"==$dir?"selected":"")." value='$dir'>$dir</option>"; ?>
                            </select>
						</div>
						
						<div class="grid" id="grid">
							<?php
								if ( file_exists( "$client/all" ) ) foreach ( array_reverse( scandir( "$client/all" ) ) as $file ) 
									if ( $file !== ".." && $file !== "." ) {

										if ( !array_key_exists( $file, $json ) || !array_key_exists( "tags", $json[$file] ) ) {
											$json[$file]["tags"] = "";
											file_put_contents( $jsonfile, json_encode( $json ) );
										}

										file_put_contents( $jsonfile, json_encode( $json ) );

										?>
											<div class="filebox" data-file="<?php echo $file; ?>" data-tags="<?php echo $json[$file]["tags"]; ?>" onclick="clickfile(this)"> 
												<div class="thumbnail" data-type="<?php echo explode(".",$file)[1]; ?>">
													<div class='thumbnail'></div>
													<div class='thumbnailtags'><?php echo $json[$file]["tags"]; ?></div>
												</div>
												<div class="data">
													<div class="copy">
														<div class="copybox">
															<label>Source</label>
															<input class="original" value="https://htdocs.dgstesting.com/shared/files/<?php echo $client; ?>/original/<?php echo rawurlencode($file); ?>" />
														</div>
													</div>
													<div class="tags">
														<button data-file="<?php echo $file; ?>" onclick="updatetags(this)">Update Tags</button>
														<textarea><?php echo $json[$file]["tags"]; ?></textarea>
													</div>
												</div>
											</div>
										<?php
									}
							?>
						</div>

						<div class="previewbox">
							<div class="preview">
								<div class="info">
									<div id="previewdata"></div>
									<div class="results">
										<label>Response</label>
                            			<div id="resulta"></div>
									</div>
								</div>
							</div>
						</div>

					</div>

                    <script>

                        function filter(e){
							for ( const image of document.getElementById( "grid" ).children ) 
								image.hidden = image.dataset.tags.indexOf( e.value ) < 0;
                        }

                        function navigate(e){
							window.location.href = window.location.href.split('?')[0] + "?hc=<?php echo $_GET["hc"]; ?>&client=" + e.value;
                        }

                        function clickfile(e){
							var files = document.getElementsByClassName( "filebox" );
							Object.keys(files).forEach((file) => files[file].dataset.clicked = "false");
							e.dataset.clicked = "true";
                            document.getElementById( "previewdata" ).innerHTML = e.getElementsByClassName("data")[0].innerHTML;
                        }

                        function updatetags(e) {	
                            e.dataset.loading = "true";
							var formData = new FormData();
							formData.append('file',  e.dataset.file);
							formData.append('tags',  e.nextElementSibling.value);
							formData.append('hc',  "<?php echo $_GET["hc"]; ?>");
                            fetch('', { method: 'POST', body: formData } )
                                .then(response=>response.text())
                                .then(data=>{ 
									document.getElementById('resulta').value = data;
                                    e.dataset.loading = "false";
                                });
                        }

                    </script>

                </body>
            </html>
        <?php

    } else {

        die( "Unauthorized" );

    }