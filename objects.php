<?php

	class Site {
		public $id = "";
		public $domain = "";
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
			$this->id = $id;
			foreach( json_decode( file_get_contents( __DIR__."/$this->id/settings.json" ))->settings as $field => $value ) 
				$this->data["settings"][$field] = $value;

			//foreach( tojson file_get_contents( __DIR__ )["locations"] as location
				//$this->data["locations"][locationid] = $location_defaults
				//foreach( location as field => value ) 
					//$this->data["locations"][locationid][$field] = $value;
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
			"is_service" => "",
			"is_about" => "",
			"no_tracking" => ""
		);

  	  	function __construct( $site ) {
			$this->id = "";
			//foreach( tojson file_get_contents( __DIR__ ) as field => value ) data[$field] = $value;

			$this->folder = __DIR__;
			$this->link = $site->domain . $this->folder . $this->id;

			//if no thumbnail, use homepages thumbnail

			if ( $site->data["locations"] ) {
				$this->data["location"]["data"] = array_key_first( $site->data["locations"] );
				if ( $this->data["location"]["id"] && array_key_exists( $this->data["location"]["id"], $site->data["locations"] ) ) {
					foreach( $site->data["locations"][ $this->data["location"]["id"] ] as $field => $value ) $this->data["location"]["data"][$field] = $value;
				}
			}
		}
	}

	class Image {
		public $src = [""];
		public $alt = "";
		public $data = array( "width" => "", "height" => "", "echo" => true );
		
    	function __construct( $src = "", $alt = "", $data = array() ) {
			foreach ( $data as $field => $value ) $this->data[ $field ] = $value;
			$this->src[0] = $src;
			$this->alt = $alt;

			if ( strpos( $src, "dgstesting.com/shared/" ) !== false ) {
				$thumbs = generateThumbs( $src );
				$this->src[1] = $thumbs[0];
				$this->src[2] = $thumbs[1];
				if ( !$this->alt ) $this->alt = "alt from media folder";
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
