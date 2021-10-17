<?php 

	if ( $_POST['hc'] === "00034jidsb938whuf9gi32049" ) {

        $templates = json_decode( file_get_contents( "templates.json" ), 1 );
        $templates[$_POST["file"]]["tags"] = $_POST["tags"];
        file_put_contents( __DIR__ "shared/templates/public/templates.json", json_encode( $templates ) );
        echo "Success";

	} else if ( $_GET['hc'] === "00034jidsb938whuf9gi32049" ) {
        
        $templates = json_decode( file_get_contents( "templates.json" ), 1 );

        ?>
            <html>
                <body>

                    <div class="controls">
                        <div class="filter">
                            <input onchange="filter(this)">
                        </div>
                    </div>

                    <?php

                        $files = scandir( __DIR__ . "shared/templates/public/all" );
                        foreach( $files as $file ){
                            ?>
                                <div class="template" data-tags="<?php echo $templates[$file]["tags"]; ?>"> 
                                    <div class="iframe">
                                        <iframe src="https://htdocs.dgstesting.com/shared/templates/public/all/<?php echo $file; ?>"></iframe>
                                    </div>
                                    <div class="preview">
                                        <a href="https://htdocs.dgstesting.com/shared/templates/public/all/<?php echo $file; ?>" target="_blank">Preview</a>
                                    </div>
                                    <div class="tags">
                                        <button onclick="copycode(this)">Copy Code</button>
                                        <textarea hidden><?php echo explode( "</style>", file_get_contents($file), 2 )[1]; ?></textarea>
                                    </div>
                                    <div class="tags">
                                        <button onclick="updatetags(this)" data-file="<?php echo $file; ?>">Update Tags</button>
                                        <input value="<?php echo $templates[$file]["tags"]; ?>" />
                                    </div>
                                </div>
                            <?php
                        }

                    ?>

                    <script>

                        function filter(e){
                            
                        }

                        function copycode(e){
                            e.nextElementSibling.select();
                            document.execCommand('copy');
                            e.dataset.copied = !e.dataset.copied;
                        }

                        async function updatetags(e) {	
                            e.dataset.loading = "true";
                            var data = { file: e.dataset.file, tags: e.nextElementSibling.value, hc: "00034jidsb938whuf9gi32049" };
                            await fetch('', {method: "POST", body: JSON.stringify( data ), headers: { "Content-Type": "application/json" } ) } )
                            await fetch('', { method: "POST", body: e.nextElementSibling.value  } )
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