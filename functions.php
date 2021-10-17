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

        $target_files = array(
            600 => __DIR__ . "/shared/images/" . $params[0] . "/lowres/" . $params[2],
            1080 => __DIR__ . "/shared/images/" . $params[0] . "/medres/" . $params[2],
        );

        foreach( $target_files as $target_width => $target_file ){
        
            if ( strtolower( explode( '.', $params[2] )[1] ) === "jpg" || strtolower( explode( '.', $params[2] )[1] ) === "jpeg" ) $source_image = imagecreatefromjpeg($file);
            if ( strtolower( explode( '.', $params[2] )[1] ) === "png" ) $source_image = imagecreatefrompng($file);

            if ( $target_width < imagesx($source_image) ) {

                if( !file_exists( $target_file ) ) {
                    $desired_height = floor(imagesy($source_image) * ($target_width / imagesx($source_image)));
                    $virtual_image = imagecreatetruecolor($target_width, $desired_height);
                    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $target_width, $desired_height, imagesx($source_image), imagesy($source_image));
                    
                    imagejpeg( $virtual_image, $target_file );
                }
                
                $target_files[$target_width] = $target_file ;

            } else {

                $target_files[$target_width] = $file;
                
            }

        }

        return $target_files;

    }