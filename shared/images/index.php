<?php 

    // - hover for full res
    // - tooltip explaining why new Image() is best
    // - edit alt tag (save to images/public/index.json )

	$client = isset( $_POST["client"] ) ? $_POST["client"] : "public";
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

						.gallery {
							display: grid;
							grid-template-columns: 80% 20%;
						}
						.gallery * {
							font-family: arial;
						}

						.controls {
							grid-area: 1 / 1 / 1 span / 2 span;
							border-bottom: 1px solid;
							padding: 10px;
						}

						.imagebox:not([hidden]) {
							height: 100px;
							display: inline-block;
							width: 100px;
    						padding: 10px;
						}
						.imagebox:hover .data {
							display: block;
							position: absolute;
							border: 1px solid;
							padding: 10px;
							width: 350px;
						}
						.image {
							width: 100px;
							height: 100px;
							overflow: hidden;
						}
						.image img {
							width: 100px;
						}

						.copybox input {
							display: inline-block;
  			  				width: 260px;
						}

						.copybox label {
							display: inline-block;
							width: 70px;
							text-align: right;
						}
						.data {
							display:none;
						}

						.preview img {
							width: 100%;
						}

					</style>

					<div class="gallery">

						<div class="controls">
							<div class="filter">
								<label>Filter By Tag</label>
								<input onkeyup="filter(this)">
							</div>
							<div class="filter">
								<label>Show Preview Panel</label>
								<input type="checkbox" onchange="preview(this)">
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

									generateThumbs( __DIR__ . "/$client/highres/" . $file );

									?>
										<div class="imagebox" data-tags="<?php echo $json[$file]["tags"]; ?>"> 
											<div class="image">
												<img onmouseover="hover(this)" src="<?php echo "$client/lowres/$file"; ?>" />
											</div>
											<div class="data">
												<div class="copy">
													<div class="copybox">
														<label>Dynamic</label>
														<input value='&lt;?php new Image( "https://htdocs.dgstesting.com/shared/images/highres/<?php echo $file; ?>", "" ); ?&gt;' />
													</div>
													<div class="copybox">
														<label>Large</label>
														<input value="https://htdocs.dgstesting.com/shared/images/highres/<?php echo $file; ?>" />
													</div>
													<div class="copybox">
														<label>Medium</label>
														<input value="https://htdocs.dgstesting.com/shared/images/medres/<?php echo $file; ?>" />
													</div>
													<div class="copybox">
														<label>Small</label>
														<input value="https://htdocs.dgstesting.com/shared/images/lowres/<?php echo $file; ?>" />
													</div>
												</div>
												<div class="tags">
													<button onclick="updatetags(this)" data-file="<?php echo $file; ?>">Update Tags</button>
													<input value="<?php echo $json[$file]["tags"]; ?>" />
												</div>
											</div>
										</div>
									<?php
								}
							?>
						</div>

						<div class="previewbox" id="previewpanel" hidden>
							<div class="preview">
								<img id="preview" src="" />
							</div>
						</div>

					</div>

                    <script>

                        function filter(e){
							for ( const image of document.getElementById( "grid" ).children ) 
								image.hidden = image.dataset.tags.indexOf( e.value ) < 0;
                        }

                        function preview(e){
                            document.getElementById( "previewpanel" ).hidden = !e.checked;
                        }

                        function hover(e){
                            document.getElementById( "preview" ).src = e.src.replace( "lowres", "highres" );
                        }

                        async function updatetags(e) {	
                            e.dataset.loading = "true";
							var formData = new FormData();
							formData.append('file',  e.dataset.file);
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