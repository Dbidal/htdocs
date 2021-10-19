<?php


    function sendPixel(){
		if( isset( $_GET['token'] ) && isset( $_GET['event'] ) && isset( $_GET['id'] ) ) {

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v10.0/".$_GET['id']."/events?access_token=".$_GET['token']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'data' => 
				'[{
				"event_name": "'.$_GET['event'].'",
				"event_time": '.strtotime('now').',
				"event_source_url": "'.$_SERVER['HTTP_HOST'].'",
				"action_source": "website",
				"user_data": {"country":"'.(hash('sha256','canada')).'","client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'","client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'"}
				}]'
			));

			$output = curl_exec($ch);
			curl_close($ch);
			echo $output;
			exit;
		}
	}
	sendPixel();




    function generateThumbs( $file ){

       	$params = explode( "/", explode( "images/", $file )[1] );

		if ( strpos( $file, $_SERVER[ "HTTP_HOST" ] ) !== false ) {

			$target_files = array(
				600 => __DIR__ . "/shared/images/" . $params[0] . "/lowres/" . $params[2],
				1080 => __DIR__ . "/shared/images/" . $params[0] . "/medres/" . $params[2],
			);

			foreach( $target_files as $target_width => $target_file ){

				if ( !file_exists( $target_file ) ) {

					if ( strtolower( explode( '.', $params[2] )[1] ) === "jpg" || strtolower( explode( '.', $params[2] )[1] ) === "jpeg" ) $source_image = imagecreatefromjpeg($file);
					if ( strtolower( explode( '.', $params[2] )[1] ) === "png" ) $source_image = imagecreatefrompng($file);

					if ( isset( $source_image ) && $target_width < imagesx($source_image) ) {

						$desired_height = floor(imagesy($source_image) * ($target_width / imagesx($source_image)));
						$virtual_image = imagecreatetruecolor($target_width, $desired_height);
						imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $target_width, $desired_height, imagesx($source_image), imagesy($source_image));
						
						imagejpeg( $virtual_image, $target_file );
					
					} else {

						copy($file, $target_file);
						
					}

					if ( $virtual_image ) imagedestroy( $virtual_image );
					if ( $source_image ) imagedestroy( $source_image );
				}

			}
		} else {

			$target_files = array(
				600 => explode( "/shared/", $file )[0] . "/shared/images/" . $params[0] . "/lowres/" . $params[2],
				1080 => explode( "/shared/", $file )[0] . "/shared/images/" . $params[0] . "/medres/" . $params[2],
			);

		}

		list( $width, $height ) = getimagesize( $file );

        return array( $width, $height, $target_files, "" );

    }