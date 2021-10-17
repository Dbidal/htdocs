<?php 

	$client = isset( $_GET["client"] ) ? $_GET["client"] : "public";
	$jsonfile = __DIR__ . "/$client/images.json";
    $json = json_decode( file_get_contents( $jsonfile ), 1 );

	if ( $_POST && $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

        $json[$_POST["file"]]["tags"] = $_POST["tags"];
        file_put_contents( $jsonfile, json_encode( $json ) );
        echo "Success";

	} else if ( $_GET && $_GET['hc'] === "00034jidsb938whuf9gi32049" ) {
        
    	include  dirname( __DIR__, 2 ) . "/functions.php";
        $templates = json_decode( file_get_contents( $jsonfile ), 1 );
		
        ?>
            <html>
                <body>

					<style>

						.gallery {display: grid;grid-template-columns: 80% 20%;}
						.gallery * {font-family: arial;}
						.controls {grid-area: 1 / 1 / 1 span / 2 span;border-bottom: 1px solid;padding: 10px;}
						.imagebox:not([hidden]) {height: 100px;display: inline-block;width: 100px;}
						.imagebox:hover {outline: 4px solid;}
						.data {display: none;position: absolute;border: 1px solid;padding: 10px;width: 350px;background: white;margin: -10px 10px;box-shadow: 0 30px 100px 10px;border-radius: 4px;border-top: 6px solid;}
						.image {width: 100px;height: 100px;overflow: hidden;}
						.image img {height: 100px;width: 100px;object-fit:cover;object-position:center;}
						.copybox {margin: 4px 0;font-size: 12px;text-align: right;}
						.copybox input {display: inline-block;width: 265px;padding: 4px 10px;border: none;border-left: 1px solid;margin: 0 10px;}
						.copybox label {display: inline-block;width: 60px;text-align: right;}
						.imagebox:hover .data {display:block;}
						.tags {display: grid;padding: 6px 6px 3px;grid-template-columns: 100%;}
						.tags textarea {grid-area: 1 / 1;padding: 4px 10px;height: 100px;}
						.tags button {font-size: 12px;width: 100px;margin: 5px 0 0 0;}
						.preview img {width: 100%;}

					</style>

					<div class="gallery">

						<div class="controls">
							<div class="filter">
								<label>Filter By Tag</label>
								<input onkeyup="filter(this)">
							</div>
						</div>
						
						<div class="grid" id="grid">
							<?php
								$files = scandir( "$client/highres" );

								foreach ( array_reverse( $files ) as $file ) if ( $file !== ".." && $file !== "." ) {

									if ( !array_key_exists( $file, $json ) ) {
										$json[$file]["tags"] = "";
										file_put_contents( $jsonfile, json_encode( $json ) );
									}

									list( $width, $height ) = generateThumbs( __DIR__ . "/$client/highres/" . $file );

									?>
										<div class="imagebox" data-file="<?php echo $file; ?>" data-tags="<?php echo $json[$file]["tags"]; ?>"> 
											<div class="image">
												<img loading="lazy" width="<?php echo $width; ?>" height="<?php echo $height; ?>" onmouseover="hover(this)" src="<?php echo "$client/lowres/$file"; ?>" />
											</div>
											<div class="data">
												<div class="copy">
													<div class="copybox">
														<label>Dynamic</label>
														<input value='&lt;?php new Image( "https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/highres/<?php echo $file; ?>", "" ); ?&gt;' />
													</div>
													<div class="copybox">
														<label>Large</label>
														<input value="https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/highres/<?php echo $file; ?>" />
													</div>
													<div class="copybox">
														<label>Medium</label>
														<input value="https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/medres/<?php echo $file; ?>" />
													</div>
													<div class="copybox">
														<label>Small</label>
														<input value="https://htdocs.dgstesting.com/shared/images/<?php echo $client; ?>/lowres/<?php echo $file; ?>" />
													</div>
												</div>
												<div class="tags">
													<button onclick="updatetags(this)">Update Tags</button>
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
							</div>
							<div class="info">
								<span id="previewFilename"></span>
							</div>
						</div>

					</div>

                    <script>

                        function filter(e){
							for ( const image of document.getElementById( "grid" ).children ) 
								image.hidden = image.dataset.tags.indexOf( e.value ) < 0;
                        }

                        function hover(e){
                            document.getElementById( "preview" ).src = e.src.replace( "lowres", "highres" );
                            document.getElementById( "previewFilename" ).innerHTML = e.parentNode.parentNode.dataset.file;
                        }

                        async function updatetags(e) {	
                            e.dataset.loading = "true";
							var formData = new FormData();
							formData.append('file',  e.parentNode.parentNode.parentNode.dataset.file);
							formData.append('tags',  e.nextElementSibling.value);
							formData.append('hc',  "<?php echo $_GET["hc"]; ?>");
                            await fetch('', { method: 'POST', body: formData } )
                                .then(response=>response.text())
                                .then(data=>{ 
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