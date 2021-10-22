<?php

	class Blog {
		public $site = []; 
		public $path = "";
		public $exceptions = [];

		function __construct( $site, $path = "", $exceptions = [] ) {
			$this->site = $site;
			$this->path = $path;
			$this->exceptions = $exceptions;
		}

		function print( $styles = true ) {

			?>
				<div class="blog">
			<?php

			$files = scandir( preg_replace( "/(features).*/", "", __DIR__ ) . "/sites/" . $this->site->id . "/root/" . $this->path );
			foreach ( $files as $file ) 
				foreach ( $this->exceptions as $exception ) 
					if ( $exception != $file && "." != $file && ".." != $file ) {
						$blogpage = new Page( $this->site, $file );
						?>
							<a href="<?php echo $blogpage->link; ?>">
								<div class="blogitem">
									<img src="<?php echo $blogpage->thumbnailWithFallback() ?? ""; ?>" />
									<h3><?php echo $blogpage->data["title"] ?? ""; ?></h3>
									<p><?php echo $blogpage->data["excerpt"] ?? ""; ?></p>
								</div>
							</a>
						<?php
					}
					
			?>
				</div>
			<?php

			if ( $styles ) $this->printStyles();
		}

		function printStyles() {

			?>
				<style>

					.blogitem {margin: auto;display: inline-block;width: 260px;margin: 10px;border: 1px solid;padding: 10px;}
					.blog {max-width: 1200px;text-align: center;}

				</style>
			<?php

		}
	}