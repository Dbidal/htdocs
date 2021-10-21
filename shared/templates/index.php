<?php 

    include dirname( __DIR__, 2 ) . "/functions.php";
	$client = isset( $_GET["client"] ) ? $_GET["client"] : "public";
	$jsonfile = __DIR__ . "/$client/templates.json";
    $json = file_exists( $jsonfile ) ? json_decode( file_get_contents( $jsonfile ), 1 ) : [];

	if ( $_POST && $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

		if ( isset( $_POST[$_POST["file"]]["tags"] ) ) {
			$json[$_POST["file"]]["tags"] = $_POST["tags"];
			file_put_contents( $jsonfile, json_encode( $json ) );
		}

		if ( isset( $_POST['source'] ) )
			file_put_contents( "$client/all/" . $_POST["file"], $_POST['source'] );
		
        echo "Success";

	} else if ( $_GET && $_GET['hc'] === "00034jidsb938whuf9gi32049" ) {

        ?>

            <html>
                <body>

					<style>

						.gallery {display: grid;grid-template-columns: auto 350px;    padding-bottom: 500px;}
						.gallery * {font-family: arial;}
						.controls {grid-area: 1 / 1 / 1 span / 2 span;border-bottom: 1px solid;padding: 10px;}
						.templatebox:not([hidden]) {height: 100px;display: inline-block;width: 100px;}
						.templatebox[data-clicked="true"] {outline: 4px solid;}
						.data {display: none;position: absolute;border: 1px solid;padding: 10px;width: 350px;background: white;margin: -10px 10px;box-shadow: 0 30px 100px 10px;border-radius: 4px;border-top: 6px solid;}
						.iframe {width: 100px;height: 100px;}
						.iframe iframe {border:2px solid;pointer-events: none;width: 1000px;height: 1000px;transform: scale(.1);transform-origin: 0 0;}
						.tags, .code {display: grid;padding: 6px 6px 3px;grid-template-columns: 100%;}
						.tags textarea, .code textarea {grid-area: 1 / 1;padding: 4px 10px;height: 100px;}
						.code textarea {white-space:nowrap;}
						.tags button, .code button{width:200px;font-size: 12px;margin: 5px 0 0 0;}
						.filter, .dir {display: inline-block;margin-left: 20px;}
						.dir {padding:2px;}
						.preview {position: sticky;top: 0;overflow: hidden;}
						.info{height: 350px;margin-bottom:10px;}
						.templatebox:hover:not([data-clicked="true"]) {outline:2px solid;}
						#preview{border:2px solid;width:1400px;height:1400px;transform: scale(.25);transform-origin: 0 0}
						#preview[data-view="mobile"]{width:500px;height:500px;transform: scale(.7);transform-origin: 0 0}
						.previewcontrols button{padding:5px;margin:5px;cursor:pointer;}
						.visit {text-align: center;font-size: 14px;}

					</style>

					<div class="gallery">

						<div class="controls">
							<a href="../?hc=<?php echo $_GET["hc"]; ?>">↖ Back</a>
							<div class="filter">
								<label>Filter By Tag</label>
								<input onkeyup="filter(this)">
							</div>
                            <select class="dir" onchange="navigate(this)">
                                <?php foreach( scandir( "." ) as $dir ) if( is_dir( $dir ) && $dir !== "." && $dir !== ".." && $dir !== "index.php" ) echo "<option ".("public"==$dir?"selected":"")." value='$dir'>$dir</option>"; ?>
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
											<div class="templatebox" data-file="<?php echo $file; ?>" data-tags="<?php echo $json[$file]["tags"]; ?>" onclick="clicktemplate(this)"> 
												<div class="iframe">
													<iframe src="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/shared/templates/$client/all/" . rawurlencode($file); ?>" ></iframe>
												</div>
												<div class="data">
													<div class="visit">
														<a target="_blank" href="https://htdocs.dgstesting.com/shared/templates/<?php echo $client; ?>/all/<?php echo rawurlencode($file); ?>">View in New Tab</a>
													</div>
													<div class="tags">
														<button data-file="<?php echo $file; ?>" onclick="updatetags(this)">Update Tags</button>
														<textarea><?php echo $json[$file]["tags"]; ?></textarea>
													</div>
													<div class="code">
														<button data-file="<?php echo $file; ?>" onclick="updatesource(this)">Update Source Code</button>
														<textarea><?php echo file_get_contents( "$client/all/" . $file ); ?></textarea>
													</div>
												</div>
											</div>
										<?php
									}
							?>
						</div>

						<div class="previewbox">
							<div class="preview">
								<div class="previewcontrols">
									<button class="desktop" onclick="viewmode(this)">💻</button>
									<button class="mobile" onclick="viewmode(this)">📱</button>
								</div>
								<div class="info">
									<iframe id="preview"></iframe>
								</div>
								<div id="previewdata"></div>
								<div class="results">
									<label>Response</label>
                            			<div id="resulta"></div>
								</div>
							</div>
						</div>

					</div>

                    <script>

                        function viewmode(e){
							document.getElementById( "preview" ).dataset.view = e.className;
                        }

                        function filter(e){
							for ( const image of document.getElementById( "grid" ).children ) 
								image.hidden = image.dataset.tags.indexOf( e.value ) < 0;
                        }

                        function navigate(e){
							window.location.href = window.location.href.split('?')[0] + "?hc=<?php echo $_GET["hc"]; ?>&client=" + e.value;
                        }

                        function clicktemplate(e){
							var templates = document.getElementsByClassName( "templatebox" );
							Object.keys(templates).forEach((template) => templates[template].dataset.clicked = "false");
							e.dataset.clicked = "true";
                            document.getElementById( "preview" ).src = e.getElementsByTagName("iframe")[0].src;
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

                        function updatesource(e) {	
                            e.dataset.loading = "true";
							var formData = new FormData();
							formData.append('file',  e.dataset.file);
							formData.append('source',  e.nextElementSibling.value);
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