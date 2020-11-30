<?php
$paths  = glob( 'images/*/*' );
$return = array();
foreach ( $paths as $path ) {
	$image_name    = basename( dirname( $path ) );
	$image_version = basename( $path );
	$return[]      = array(
		'name' => $image_name . ':' . $image_version,
		'file' => 'images/' . $image_name . '/' . $image_version,
	);
}

$return = json_encode( $return );

echo "::set-output name=dockerinfo::$return";

echo $return;
