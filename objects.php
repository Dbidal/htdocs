<?php

	class Site {
		public $root = "";
		public $id = "";
		public $pages = [];
		public $data = array(
			"settings" => array(
				"business_type" => "",
				"sitename" => "",
				"tagline" => "",
				"domain" => "",
				"favicon" => "",
				"logo" => "",
				"googlefonts" => "",
				"languages" => [ "EN" ]
			),
			"locations" => array()
		);
		public $location_defaults = array(
			"name" => "", 
			"addressLocality" => "", 
			"addressRegion" => "", 
			"postalCode" => "", 
			"addressCountry" => "", 
			"streetAddress" => "", 
			"priceRange" => "", 
			"latitude" => "", 
			"longitude" => "", 
		);

  	  	function __construct( $id ) {
			if ( $this->id = $id ){
				$settings = json_decode( file_get_contents( __DIR__."/sites/$this->id/settings.json" ), 1 );
				$this->pages = json_decode( file_get_contents( __DIR__."/sites/$this->id/pages.json" ), 1 );

				if ( array_key_exists( "settings", $settings ) ) foreach( $settings["settings"] as $field => $value ) $this->data["settings"][$field] = $value;
				if ( array_key_exists( "places", $settings ) ) foreach( $settings["places"] as $locationid => $settings ) $this->data["locations"][ $locationid ] = $settings;
					
				$this->root = $_SERVER["HTTP_HOST"] == "localhost" ? "http://localhost/sites/$id/root" : $this->data["domain"];
			}
		}

		function place( $placeid, $field, $params = [] ) {

			if ( !$this->id ) return "⋪⋫";

			$color = array_key_exists( "color", $params ) ? $params["color"] : "#000";

			$l = 0;
			foreach( $this->data["locations"] as $locationid => $location ) {
				if ( $placeid === $l || $placeid === $locationid ) {

					if ( $field === "telephone" && array_key_exists( "link", $params ) && $params[ "link" ] ) {
						$formatted = str_replace('(','',str_replace(')','',str_replace('-','',str_replace(' ','',$location["telephone"]))));
						return '<a class="hcube-contact-link" href="tel:'.$formatted.'">'.$location["telephone"].'</a>';
					}

					if ( $field === "email" && array_key_exists( "link", $params ) && $params[ "link" ] ) {
						return '<a class="hcube-contact-link" href="mailto:'.$location["email"].'">'.$location["email"].'</a>';
					}


					if ( $field === "social" ) {
						
						$cl = [];
						$cl["facebook"] = ["fab fa-facebook-f", "Facebook" ];
						$cl["twitter"] = ["fab fa-twitter", "Twitter" ];
						$cl["pinterest"] = ["fab fa-pinterest", "Pwitter" ];
						$cl["linkedin"] = ["fab fa-linkedin", "Linkedin" ];
						$cl["youtube"] = ["fab fa-youtube", "Youtube" ];
						$cl["google"] = ["fab fa-google", "Google" ];
						$cl["instagram"] = ["fab fa-instagram", "Instagram" ];
						$cl["yelp"] = ["fab fa-yelp", "Yelp" ];

						$result = "<b class='hcube-social'>";
						if ( array_key_exists( "social", $location ) ) foreach ( $location["social"] as $key => $value)
							$result .= '
								<a target="_blank" data-vars-name="Social Profile - '.$cl[$key][1].'" rel="'.$cl[$key][1].'" aria-label="'.$cl[$key][1].'" href="'.$value.'" data-amp-original-style="color:">
									<i style="color:'.$color.'" class="'.$cl[$key][0].'"></i></a>';
									
						if ( array_key_exists( "customsocial", $location ) ) foreach ( $location["customsocial"] as $key => $value)
							$result .= '
								<a target="_blank" data-vars-name="Social Profile - '.$key.'" rel="'.$key.'" aria-label="'.$key.'" href="'.$value[0].'" data-amp-original-style="color:">
									<i class="hc2_customsocial" style="filter:opacity(.1) drop-shadow(0 0 0 '.$color.') drop-shadow(0 0 0 '.$color.') drop-shadow(0 0 0 '.$color.') drop-shadow(0 0 0 '.$color.') drop-shadow(0 0 0 '.$color.');background-image:url('.wp_get_attachment_image_src($value[1], 'full')[0].')"></i></a>';

						return $result."</b>";

					}

					return array_key_exists( $field, $location ) ? $location[$field] : "";
				}
				$l ++;
			}
		}
	}
	
	class Page {
		public $id = "";
		public $folder = "";
		public $link = "";
		public $data = array( 
			"title" => "",
			"excerpt" => "",
			"thumbnail" => "",
			"language" => array( "code" => "EN", "urls" => array( "EN" => "" ) ),
			"location" => array( "id" => "", "data" => array( 
				"name" => "", 
				"owner" => "", 
				"addressLocality" => "", 
				"addressRegion" => "", 
				"postalCode" => "", 
				"addressCountry" => "", 
				"streetAddress" => "", 
				"priceRange" => "", 
				"latitude" => "", 
				"longitude" => "", 
				"hours" => "", 
				"telephone" => "",
				"social" => []
			) ),
			"date" => array( "published" => "", "modified" => "" ),
			"is_hidden" => "",
			"is_service" => "",
			"is_about" => "",
			"no_tracking" => ""
		);

  	  	function __construct( $site, $idoverride = "" ) {
			if ( $site->id ) {
				$this->id = $idoverride ?: ( basename($_SERVER['PHP_SELF']) === "index.php" ? "" : basename($_SERVER['PHP_SELF']) );
				
				foreach( json_decode( file_get_contents( __DIR__."/sites/$site->id/pages.json" ), 1 )[$this->id] as $field => $value ) 
					$this->data[$field] = $value;

				$this->link = $site->data["settings"]["domain"] . $this->folder . $this->id;

				if ( $site->data["locations"] ) {
					foreach( $site->data["locations"][array_key_first( $site->data["locations"] )] as $field => $value ) 
						$this->data["location"]["data"][$field] = $value;
					if ( $this->data["location"]["id"] && array_key_exists( $this->data["location"]["id"], $site->data["locations"] ) ) {
						foreach( $site->data["locations"][ $this->data["location"]["id"] ] as $field => $value ) $this->data["location"]["data"][$field] = $value;
					}
				}
			}
		}

		function thumbnailWithFallback() {
			//if no thumbnail, ty homepage thumbnail, then try site logo
			return $this->data["thumbnail"];
		}
	}

	class Image {

		public $src = ["","",""];
		public $alt = "";
		public $data = array( "width" => "", "height" => "", "echo" => true );
		
    	function __construct( $src = "", $alt = "", $data = array() ) {
			foreach ( $data as $field => $value ) $this->data[ $field ] = $value;
			$this->src[0] = $src;
			$this->alt = $alt;
			
			if ( function_exists( "generateThumbs" ) && strpos( $src, "htdocs.dgstesting.com/shared" ) !== false ) {
				list( $width, $height, $files, $genalt ) = generateThumbs( $src );
				
				$this->$width = $this->data[ "width" ] ?: $width;
				$this->$height = $this->data[ "height" ] ?: $height;
				$this->src[1] = $files[600];
				$this->src[2] = $files[1080];
				$this->alt = $alt ?: $genalt;

			} else {
				$this->src[1] = $this->src[0];
				$this->src[2] = $this->src[0];

			}
				
			if ( $this->data["echo"] ) $this->print();

		}

    	function print() {
			?>
				<img 
					loading="lazy" 
					width="<?php echo $this->data["width"]; ?>" 
					height="<?php echo $this->data["height"]; ?>" 
					src="<?php echo $this->src[0]; ?>" 
					alt="<?php echo $this->alt; ?>" 
					srcset="<?php echo $this->src[1]; ?> 576w, <?php echo $this->src[2]; ?> 1000w" 
					sizes="100vw"
				>
			<?php
		}
	}

	class Video {
		// preset poster image from videos.json
	}
