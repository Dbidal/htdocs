<?php 
	include __DIR__."/functions.php"; 
	include __DIR__."/objects.php"; 
	$site = new Site( explode( "/", $_SERVER['SCRIPT_NAME'] )[1] );
	$page = new Page( $site );
	foreach( scandir( __DIR__."/$site->id/features/" ) as $file ) if( $file !== ".." && $file !== "." ) include __DIR__."/$site->id/features/".$file; 
?>

<!doctype html>
<html lang="<?php echo $page->data["language"]["code"]; ?>" >
	<head>

		<?php 
		
			if ( $site->data["settings"]["googlefonts"] ) echo "<link crossorigin  href='https://fonts.googleapis.com/css?family=".$site->data["settings"]["googlefonts"]."&display=swap' rel='stylesheet'>" ;
		
			if ( count( $site->data["settings"]["languages"] ) > 1 )
				foreach( $site->data["settings"]["languages"] as $language )
					if( $language != $page->data["language"]["code"] )
						echo '<link rel="alternate" hreflang="'.$page->data["language"]["code"].'" href="'.$page->data["language"]["urls"][ $page->data["language"]["code"] ].'" />'; 
				
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $page->data["title"]; ?></title>
		<link rel="Shortcut Icon" type="image/x-icon" href="<?php echo $site->data["settings"]["favicon"]; ?>" />
		<meta property="og:title" content="<?php echo $page->data["title"]; ?>"/>
		<meta property="og:type" content="article"/>
		<meta property="og:url" content="<?php echo $page->link; ?>"/>
		<meta property="og:site_name" content="<?php echo $site->data["settings"]["sitename"]; ?>"/>
		<meta property="og:description" content="<?php echo $page->data["excerpt"]; ?>"/>
		<meta property="og:image" content="<?php echo $page->data["thumbnail"]; ?>"/>
		<meta property="id" content="<?php echo $page->id; ?>"/>
		<meta name="viewport" content="width=device-width">
		<meta name="description" content="<?php echo $page->data["excerpt"]; ?>"/>
		<link rel="canonical" href="<?php echo $page->link; ?>" />
		<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.1/css/all.css">
	
		<script <?php echo 'type="application/ld+json"'; ?>>
			[
				<?php if ( $page->data["is_service"] ) { ?>
				{
					"@context": "http://schema.org/",
					"@type": "Service",
					"serviceType": "<?php echo $page->data["title"]; ?>",
					"areaServed": {"@type": "AdministrativeArea","name":"<?php echo $page->data["location"]["data"]['addressLocality']; ?>" },
					"provider": "<?php echo $page->data["excerpt"]; ?>",
					"description":"<?php echo $page->data["excerpt"]; ?>",
					"image":"<?php echo $page->data["thumbnail"] ; ?>",
					"logo" : {"@type" : "ImageObject","url":"<?php echo $site->data["settings"]["favicon"]; ?>","width":"60","height":"60"},
					"url":"<?php echo $page->link; ?>"
				},
				<?php } elseif ( $page->data["is_about"] ) { ?>
				{
					"@context": "http://schema.org/",
					"@type": "AboutPage",
					"description":"<?php echo $page->data["excerpt"]; ?>",
					"image":"<?php echo $page->data["thumbnail"] ; ?>",
					"name":"<?php echo $page->data["title"]; ?>",
					"url":"<?php echo $page->link; ?>"
				},
				<?php } else { ?>
				{
					"@context": "http://schema.org/"
					,"@type": "NewsArticle"
					,"name": "<?php echo $page->data["title"]; ?>"
					,"url":"<?php echo $page->link; ?>"
					,"headline": "<?php echo $page->data["title"]; ?>"
					,"description": "<?php echo $page->data["excerpt"]; ?>"
					,"datePublished": "<?php echo $page->data["date"]["published"]; ?>"
					,"dateModified": "<?php echo $page->data["date"]["modified"]; ?>"
					,"image": "<?php echo $page->data["thumbnail"] ; ?>"
					,"mainEntityOfPage":"<?php echo $page->link; ?>"
					,"author":{ "@type" : "Person","name" : "<?php echo $page->data["location"]["data"]['owner']; ?>"}
					,"publisher": { 
						"@type" : "Organization"
						,"url" : "<?php echo $page->link; ?>"
						,"logo" : {"@type" : "ImageObject","url":"<?php echo $site->data["settings"]["favicon"]; ?>","width":"60","height":"60"}
						,"name": "<?php echo $page->data["title"]; ?>"
						,"contactPoint" : [{ "@type" : "ContactPoint","telephone" : "+1 <?php echo $page->data["location"]["data"]['telephone']; ?>","contactType" : "customer service"} ] }
				},
				<?php } ?>
				{
					"@context": "https://schema.org",
					"@type": "Organization",
					"url": "<?php echo $page->link; ?>",
					"logo": "<?php echo $site->data["settings"]["logo"]; ?>"
				},
				{
					"@context": "http://schema.org/"
					,"@type": "<?php echo $site->data["settings"]["business_type"]; ?>"
					,"name": "<?php echo $site->data["settings"]["sitename"]; ?>"
					,"logo" : {"@type" : "ImageObject","url":"<?php echo $site->data["settings"]["favicon"]; ?>","width":"60","height":"60"}
					,"image": "<?php echo $page->data["thumbnail"]; ?>"
					,"@id": "<?php echo $site->data["settings"]["domain"]; ?>"
					,"url": "<?php echo $site->data["settings"]["domain"]; ?>"
					,"description": "<?php echo $page->data["excerpt"]; ?>"
					<?php if ( $page->data["location"]["data"]['telephone'] ) { ?>,"telephone": "+1 <?php echo $page->data["location"]["data"]['telephone']; ?>"<?php } ?>
					<?php if ( $page->data["location"]["data"]['priceRange'] ) { ?>,"priceRange": "<?php echo $page->data["location"]["data"]['priceRange']; ?>"<?php } ?>
					
					<?php if ( $page->data["location"]["data"]["addressCountry"] ) { ?>
						,"address": {
							"@type": "PostalAddress",
							"streetAddress": "<?php echo $page->data["location"]["data"]['streetAddress']; ?>",
							"addressLocality": "<?php echo $page->data["location"]["data"]['addressLocality']; ?>",
							"addressRegion": "<?php echo $page->data["location"]["data"]['addressRegion']; ?>",
							"postalCode": "<?php echo $page->data["location"]["data"]['postalCode']; ?>",
							"addressCountry": "<?php echo $page->data["location"]["data"]['addressCountry']; ?>"
						}
					<?php } ?>
					<?php if ( $page->data["location"]["data"]['latitude'] && $page->data["location"]["data"]['longitude'] ) { ?>
						,"geo": {
							"@type": "GeoCoordinates",
							"latitude": <?php echo $page->data["location"]["data"]['latitude']; ?>,
							"longitude": <?php echo $page->data["location"]["data"]['longitude']; ?>
						}
					<?php } ?>
					<?php if ( $page->data["location"]["data"]['hours'] ) { ?>,"openingHours":<?php echo json_encode( $page->data["location"]["data"]['hours'] ); } ?>
					
					<?php if ( count( $site->data["locations"] ) > 1 ) { ?>
						,"location": [ 
							<?php 
								$a = 1;
								foreach ( $site->data["locations"] as $data ) { 
									if ( array_key_exists( 'addressCountry', $data ) ) { 
										if ($a > 1 ) { ?>,<?php } $a++ ; 
										?>
											{ 
												"@type": "<?php echo $site->data["settings"]["business_type"]; ?>", 
												"parentOrganization": {"name": "<?php echo $site->data["settings"]["sitename"]; ?>"},
												"name" : "<?php echo $data['name']; ?>",
												"image": "<?php echo $page->data["thumbnail"]; ?>",
												"logo" : {"@type" : "ImageObject","url":"<?php echo $site->data["settings"]["favicon"]; ?>","width":"60","height":"60"},
												"telephone": "+1 <?php echo $data['telephone']; ?>",
												"priceRange": "<?php echo $data['priceRange']; ?>",
												"address": {
													"@type": "PostalAddress",
													"streetAddress": "<?php echo $data['streetAddress']; ?>",
													"addressLocality": "<?php echo $data['addressLocality']; ?>",
													"addressRegion": "<?php echo $data['addressRegion']; ?>",
													"postalCode": "<?php echo $data['postalCode']; ?>",
													"addressCountry": "<?php echo $data['addressCountry']; ?>"
													},
												"geo": {
													"@type": "GeoCoordinates",
													"latitude": <?php echo $data['latitude']; ?>,
													"longitude": <?php echo $data['longitude']; ?>
													}
											}
										<?php 
									}
								} 
							?>
						]
					<?php } ?>
					,"sameAs":[
						"<?php $site->data["settings"]["domain"]; ?>"
						<?php 
							foreach( $page->data["location"]["data"]['social'] as $key => $value ) echo ',"'.$value.'"'; 
						?>
					]
				
				}
			]
		</script>	

		<script>
			
			<?php if ( !$page->data["no_tracking"] ) { ?>
				(function(w, d, s, l, i) {w[l] = w[l] || [];w[l].push({'gtm.start': new Date().getTime(),event: 'gtm.js'});
					var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
					j.async = true;j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;f.parentNode.insertBefore(j, f);}
				)(window, document, 'script', 'dataLayer', 'GTM-WXN3R4G');
			<?php } ?>

			// ADMIN TOOLS
				// a quick way to add notes, keywords, mark as seo important, and see the seo score

			}

		</script>

		<?php

			foreach ( ['a','b','c','d','e'] as $key ) 
				if ( array_key_exists( "ga_trigger_".$key, $page->data, ) && $page->data["ga_trigger_".$key] ) 
					echo '<script id="gtag_thankyou_'.$key.'"></script>';

			foreach ( ['a','b','c','d','e'] as $key ) 
				if ( array_key_exists( "fb_trigger_".$key, $page->data, ) && $page->data["fb_trigger_".$key] ) 
					echo '<script id="fb_thankyou_'.$key.'"></script>';

		?>

		<style>
			<?php echo file_get_contents(__DIR__."/boilerplate.css"); ?>
			<?php echo file_get_contents(__DIR__."/$site->id/global.css"); ?>
		</style>

		</head>
		<body>

			<div id='hcube_top'></div>
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXN3R4G" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			
			<div id='h' class='h hcube-content'>
