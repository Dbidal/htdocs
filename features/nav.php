<?php

	class Nav {
		public $site = []; 
		public $params = array( 

			'colors' => array(
				'text' => 'black', 
				'accent' => 'gray', 
				'background' => 'white',
				'dropdown_text' => 'black', 
				'dropdown_accent' => 'gray', 
				'dropdown_background' => 'white', 
			),
			'max-width' => '1000px', 
			'size' => 'sizeb', 
			'logo' => '',

			'items' => array(
				[ 'Home', '/', '<i class="fas fa-home"></i>' ],
				[ 'Services', '/', '<i class="fas fa-concierge-bell"></i>' ],
				[ 'About', '/', '<i class="fas fa-question-circle"></i>', array(
					[ 'More Info', '/', "", array(
						[ 'New Patients', '/' ],
						[ 'Meat the Team', '/' ],
						[ 'Contact Us', '/', '<i class="fas fa-phone"></i>' ]
					) ],
					[ 'Meat the Team', '/' ],
					[ 'Contact Us', '/' ]
				) ]
			)

		);

		function __construct( $site, $params = [] ){
			$this->site = $site;
			foreach ( $params as $key => $value ) {
				if ( $key == "colors" ) {
					foreach ( $value as $innerkey => $innervalue ) 
						$this->params[$key][$innerkey] = $innervalue;
				} else {
					$this->params[$key] = $value;
				}
			}

			$this->params["logo"] = $this->params["logo"] ?: $site->data["settings"]["logo"] ?? "";
		}

		function listLoop( $array, $level ) {
			foreach( $array as $item ) {
				?>
					<li data-open="false">
						<?php if ( is_array( $item[3] ?? "" ) ) { ?>
							<a data-submenu="true" onclick="this.parentNode.dataset.open = this.parentNode.dataset.open == 'false';">
						<?php } else { ?>
							<a href="<?php echo $item[1] ?? ""; ?>">
						<?php } ?>
								<?php echo $item[2] ?? ""; ?>
								<?php echo $item[0] ?? ""; ?>
							</a>
						<?php if ( is_array( $item[3] ?? "" ) ) { ?>
							<ul class="level<?php echo $level; ?>">
								<?php $this->listLoop( $item[3], $level + 1 ); ?>
							</ul>
						<?php } ?>
					</li>
				<?php
			}
		}

		function print( $styles = true ) {
			$level = 0;
			?>
				<nav class="menu" data-open="false">
					<a href="<?php echo $this->site->data['settings']['domain'] ?? ""; ?>">
						<img src="<?php echo $this->params["logo"] ?? ""; ?>" />
					</a>

					<a class="hamburger" onclick="this.parentNode.dataset.open = this.parentNode.dataset.open == 'false';">
						<i class="fas fa-bars"></i>
					</a>

					<ul class="level<?php echo $level; ?>">
						<?php $this->listLoop( $this->params["items"], $level + 1 ); ?>
					</ul>
				</nav>
			<?php

			if ( $styles ) $this->printStyles();
		}

		function printStyles() {

			?>
				<style>

					nav.menu{    height: 60px;margin: auto;max-width: 1200px;left: 0;right: 0;display: grid;grid-template-columns: 100px auto;text-align: right;align-items: center;}
					nav.menu .level0 > li {display: inline;}
					nav.menu li {list-style: none;    position: relative;}
					nav ul.level0 ul {opacity: 0;transition: all .2s;pointer-events: none;}
					nav.menu ul.level0 {height: 20px;transition: all .2s;}
					nav li[data-open="true"] > ul {opacity: 1;pointer-events: initial;}
					nav.menu ul.level0 > li > a {padding: 10px 20px; }
					nav a[data-submenu="true"] + ul[class] {padding: 0;position: absolute;box-shadow: 0 10px 10px -10px black;border: 1px solid;border-top: 4px solid;margin-top: 10px;right: 0;background: white;z-index: 1;width: 400px;text-align: left;}
					nav a[data-submenu="true"] + ul li {padding: 10px;border-top: 1px solid;}
					nav ul.level1 a {width: calc( 100% - 20px );display: block;padding: 10px;}
					nav ul.level1 a:hover {background: #e3e3e3;}
					nav a {cursor: pointer;text-decoration: none !important;}
					.hamburger{display:none;font-size:26px;}
					nav img {margin: 0px 20px;height: 60px;max-width: initial;}

					@media ( max-width: 1000px ){

						.hamburger{display:block;padding:10px 20px;}
						nav > ul.level0{opacity:0;
						grid-area: 2 / 1 / 1 span / 2 span;}
						nav[data-open="true"] ul.level0 {opacity: 1;}
						nav.menu .level0 > li {display: block;}
						nav.menu .level0 > li > a{display: block;padding: 10px 20px;}
					}

				</style>
			<?php

		}

	}