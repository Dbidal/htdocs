<?php 

    include dirname( __DIR__, 2 ) . "/functions.php";
	$client = isset( $_GET["client"] ) ? $_GET["client"] : "public";
	$jsonfile = __DIR__ . "/$client/videos.json";
    $json = file_exists( $jsonfile ) ? json_decode( file_get_contents( $jsonfile ), 1 ) : [];

	if ( $_POST && $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

        if ( isset( $_POST["tags"] ) ) $json[$_POST["file"]]["tags"] = $_POST["tags"];
        if ( isset( $_POST["thumbnail"] ) ) $json[$_POST["file"]]["thumbnail"] = $_POST["thumbnail"];

        if ( isset( $_FILES['file'] ) && $_FILES['file']['name'] ) {
            
            $extension = checkFileType( pathinfo( $_FILES['file']['name'] )['extension'], "vid", array( "vid" => ["mp4","mov"] ) );
            move_uploaded_file( $_FILES['file']['tmp_name'], __DIR__ . "/{$_POST['client']}/compressed/" . explode(".",$_POST["file"])[0] . '.' . $extension );
			$json[$_POST["file"]]["compressedfile"] = explode(".",$_POST["file"])[0] . '.' . $extension;

        }
		
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
						.videobox:not([hidden]) {height: 100px;display: inline-block;width: 100px;}
						.videobox[data-clicked="true"] {outline: 4px solid;}
						.data {display: none;position: absolute;border: 1px solid;padding: 10px;width: 350px;background: white;margin: -10px 10px;box-shadow: 0 30px 100px 10px;border-radius: 4px;border-top: 6px solid;}
						.thumbnail {width: 100px;height: 100px;}
						.copybox {margin: 4px 0;font-size: 12px;text-align: right;overflow: hidden;position: relative;}
						.copybox:before {content: '';display: block;position: absolute;background: white;height: 100%;width: 10px;left: 0;z-index: 1;}
						.copybox input {display: inline-block;width: 2065px;padding: 4px 10px;border: none;border-left: 1px solid;margin: 0 10px;text-align: right;right: 0;position: absolute;}
						.copybox label {display: inline-block;width: 80px;text-align: right;position: relative;background: white;padding: 5px 10px 5px 0px;margin-right: 250px;z-index: 1;font-weight: bold;border-right: 1px solid;}
						.tags,.thumbnailtext,.compressed {display: grid;padding: 6px 6px 3px;grid-template-columns: 100%;}
						.tags textarea {grid-area: 1 / 1;padding: 4px 10px;height: 100px;}
						.thumbnailtext input,.compressed input {grid-area: 1 / 1;padding: 4px 10px;}
						.tags button,.thumbnailtext button,.compressed button {width:200px;font-size: 12px;margin: 5px 0 0 0;}
						.preview video {width: 100%;}
						.filter, .dir {display: inline-block;margin-left: 20px;}
						.dir {padding:2px;}
						.preview {position: sticky;top: 0;}
						.copy {padding: 10px 0;}
						.videobox:hover:not([data-clicked="true"]) {outline:2px solid;}
						.thumbnail > .thumbnail:before {content: '▶';display: block;width: 0;height: 0;width: 100%;text-align: center;margin: 32px 0;font-size: 28px;}
						.thumbnail > .thumbnail {border: 2px double gray;}
						.thumbnail > div {background-size: cover;height: 100%;}

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
								if ( file_exists( "$client/original" ) ) foreach ( array_reverse( scandir( "$client/original" ) ) as $file ) 
									if ( $file !== ".." && $file !== "." ) {

										if ( !array_key_exists( $file, $json ) ) {
											$json[$file]["tags"] = "";
											$json[$file]["thumbnail"] = "";
											$json[$file]["compressedfile"] = "";
										}

										if ( !array_key_exists( "tags", $json[$file] ) ) $json[$file]["tags"] = "";
										if ( !array_key_exists( "thumbnail", $json[$file] ) ) $json[$file]["thumbnail"] = "";
										if ( !array_key_exists( "compressedfile", $json[$file] ) ) $json[$file]["compressedfile"] = "";

										file_put_contents( $jsonfile, json_encode( $json ) );

										?>
											<div class="videobox" data-file="<?php echo $file; ?>" data-tags="<?php echo $json[$file]["tags"]; ?>" onclick="clickvid(this)"> 
												<div class="thumbnail">
													<?php echo $json[$file]["thumbnail"] ? "<div style='background-image:url(".$json[$file]['thumbnail'].")'></div>" : "<div class='thumbnail'></div>"; ?>
												</div>
												<div class="data">
													<div class="copy">
														<div class="copybox">
															<label>Dynamic</label>
															<input value='&lt;?php new Video( "https://htdocs.dgstesting.com/shared/videos/<?php echo $client; ?>/original/<?php echo rawurlencode($file); ?>" ); ?&gt;' />
														</div>
														<div class="copybox">
															<label>Original</label>
															<input class="original" value="https://htdocs.dgstesting.com/shared/videos/<?php echo $client; ?>/original/<?php echo rawurlencode($file); ?>" />
														</div>
														<div class="copybox">
															<?php if ( $json[$file]["compressedfile"] ) { ?>
																<label>Compressed</label>
																<input value="https://htdocs.dgstesting.com/shared/videos/<?php echo $client; ?>/compressed/<?php echo rawurlencode($json[$file]["compressedfile"]); ?>" />
															<?php } ?>
														</div>
													</div>
													<div class="tags">
														<button data-file="<?php echo $file; ?>" onclick="updatetags(this)">Update Tags</button>
														<textarea><?php echo $json[$file]["tags"]; ?></textarea>
													</div>
													<div class="thumbnailtext">
														<button data-file="<?php echo $file; ?>" onclick="updatethumbnail(this)">Update Thumbnail Link</button>
														<input value="<?php echo $json[$file]["thumbnail"]; ?>" />
													</div>
													<div class="compressed">
														<form enctype="multipart/form-data" onsubmit="updatecompressed(event,this)">
															<input type="file" name="file" />
															<input type="hidden" name="hc" value="<?php echo $_GET["hc"]; ?>" />
															<input type="hidden" name="file" value="<?php echo $file; ?>" />
															<input type="hidden" name="client" value="<?php echo $client; ?>" />
															<input type="submit" name="submit" value="Upload Compressed Version"/>
														</form>
													</div>
												</div>
											</div>
										<?php
									}
							?>
						</div>

						<div class="previewbox">
							<div class="preview">
								<video controls id="preview" src="" ></video>
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

                        function clickvid(e){
							var vids = document.getElementsByClassName( "videobox" );
							Object.keys(vids).forEach((vid) => vids[vid].dataset.clicked = "false");
							e.dataset.clicked = "true";
                            document.getElementById( "preview" ).src = e.getElementsByClassName("original")[0].value.replace("htdocs.dgstesting.com",document.location.host);
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

                        function updatethumbnail(e) {	
                            e.dataset.loading = "true";
							var formData = new FormData();
							formData.append('file',  e.dataset.file);
							formData.append('thumbnail',  e.nextElementSibling.value);
							formData.append('hc',  "<?php echo $_GET["hc"]; ?>");
                            fetch('', { method: 'POST', body: formData } )
                                .then(response=>response.text())
                                .then(data=>{ 
									document.getElementById('resulta').value = data;
                                    e.dataset.loading = "false";
                                });
                        }

                        function updatecompressed(event,e) {
                            event.preventDefault();	
                            e.dataset.loading = "true";
                            fetch('', { method: 'POST', body: new FormData(e) } )
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