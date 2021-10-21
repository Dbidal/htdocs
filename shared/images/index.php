<?php 

    include dirname( __DIR__, 2 ) . "/functions.php";
	$client = isset( $_GET["client"] ) ? $_GET["client"] : "public";
	$jsonfile = __DIR__ . "/$client/images.json";
    $json = json_decode( file_exists( $jsonfile ) && file_get_contents( $jsonfile ), 1 ) ?: [];

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
						.imagebox:not([hidden]) {height: 100px;display: inline-block;width: 100px;}
						.imagebox[data-clicked="true"] {outline: 4px solid;}
						.data {display: none;position: absolute;border: 1px solid;padding: 10px;width: 350px;background: white;margin: -10px 10px;box-shadow: 0 30px 100px 10px;border-radius: 4px;border-top: 6px solid;}
						.image {width: 100px;height: 100px;overflow: hidden;}
						.image img {height: 100px;width: 100px;object-fit:cover;object-position:center;}
						.copybox {margin: 4px 0;font-size: 12px;text-align: right;overflow: hidden;position: relative;}
						.copybox:before {content: '';display: block;position: absolute;background: white;height: 100%;width: 10px;left: 0;z-index: 1;}
						.copybox input {display: inline-block;width: 2065px;padding: 4px 10px;border: none;border-left: 1px solid;margin: 0 10px;text-align: right;right: 0;position: absolute;}
						.copybox label {display: inline-block;width: 60px;text-align: right;position: relative;background: white;padding: 5px 10px 5px 0px;margin-right: 270px;z-index: 1;font-weight: bold;border-right: 1px solid;}
						.tags {display: grid;padding: 6px 6px 3px;grid-template-columns: 100%;}
						.tags textarea {grid-area: 1 / 1;padding: 4px 10px;height: 100px;}
						.tags button {font-size: 12px;width: 100px;margin: 5px 0 0 0;}
						.preview img {width: 100%;}
						.shuffle,.filter ,.dir {display: inline-block;margin-left: 20px;}
						.shuffle button {cursor: pointer;}
						.dir {padding:2px;}
						.preview {position: sticky;top: 0;}
						.copy {padding: 10px 0;}
						.imagebox:hover:not([data-clicked="true"]) {outline:2px solid;}

					</style>

					<div class="gallery">

						<div class="controls">
							<a href="../?hc=<?php echo $_GET["hc"]; ?>">↖ Back</a>
							<div class="filter">
								<label>Filter By Tag</label>
								<input onkeyup="filter(this)">
							</div>
							<div class="shuffle">
								<button onclick="shuffle(this)">Shuffle</button>
							</div>
                            <select class="dir" onchange="navigate(this)">
                                <?php 
									foreach( scandir( "." ) as $dir ) if( $dir !== "." && $dir !== ".." && $dir !== "index.php" ) 
										echo "<option ".( ( !isset ( $_GET['client'] ) && "public" == $dir ) || $_GET['client'] == $dir ? "selected" : "" )." value='$dir'>$dir</option>"; 
								?>
                            </select>
						</div>
						
						<div class="grid" id="grid">
							<?php
								$files = file_exists( "$client/highres" ) ? array_reverse( scandir( "$client/highres" ) ) : [];

								foreach ( $files as $f => $file ) if ( !is_numeric( explode( '.', $file )[0] ) ) {
									array_push($files, $file);
									unset($files[$f]);
								}

								foreach ( array_filter( $files ) as $file ) if ( $file !== ".." && $file !== "." ) {

									if ( !array_key_exists( $file, $json ) || !array_key_exists( "tags", $json[$file] ) ) {
										$json[$file]["tags"] = "";
										file_put_contents( $jsonfile, json_encode( $json ) );
									}

									list( $width, $height ) = generateThumbs( __DIR__ . "/$client/highres/" . $file );

									?>
										<div class="imagebox" data-tags="<?php echo $json[$file]["tags"]; ?>" onclick="clickimg(this)"> 
											<div class="image">
												<img loading="lazy" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo "$client/lowres/$file"; ?>" />
											</div>
											<div class="data">
												<div class="copy">
													<div class="copybox">
														<label>Dynamic</label>
														<input value='&lt;?php new Image( "https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/highres/<?php echo rawurlencode($file); ?>" ); ?&gt;' />
													</div>
													<div class="copybox">
														<label>Large</label>
														<input value="https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/highres/<?php echo rawurlencode($file); ?>" />
													</div>
													<div class="copybox">
														<label>Medium</label>
														<input value="https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/medres/<?php echo rawurlencode($file); ?>" />
													</div>
													<div class="copybox">
														<label>Small</label>
														<input value="https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/lowres/<?php echo rawurlencode($file); ?>" />
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
								<img id="preview" src="" />
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

                        function shuffle(e){
							var grid = document.getElementById('grid');
							for (var i = grid.children.length; i >= 0; i--) {
								grid.appendChild(grid.children[Math.random() * i | 0]);
							}
						}

                        function clickimg(e){
							var imgs = document.getElementsByClassName( "imagebox" );
							Object.keys(imgs).forEach((img) => imgs[img].dataset.clicked = "false");
							e.dataset.clicked = "true";
                            document.getElementById( "preview" ).src = e.getElementsByTagName("img")[0].src;
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