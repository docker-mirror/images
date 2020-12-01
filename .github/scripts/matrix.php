<?php
$paths  = glob( 'images/*/*' );
$return = array();
foreach ( $paths as $path ) {
	$image_name    = basename( dirname( $path ) );
	$image_version = basename( $path );
	if ( in_array( $image_version, array( 'README.md' ), true ) ) {
		continue;
	}
	$return[] = array(
		'name' => $image_name . ':' . $image_version,
		'file' => 'images/' . $image_name . '/' . $image_version,
	);
}

$return = json_encode( $return );

echo json_encode( $return, JSON_PRETTY_PRINT );

echo "::set-output name=dockerinfo::$return";
