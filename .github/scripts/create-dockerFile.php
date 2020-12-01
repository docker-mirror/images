<?php
define( 'IMAGE_PATH', __DIR__ . '/../../images/' );
$json = file_get_contents( __DIR__ . '/images.json' );
$json = json_decode( $json, true );

$saved_images = array();
foreach ( $json as $docker => $file ) {
	@mkdir( IMAGE_PATH . dirname( $file ), 777 );
	$content = <<<DOCKERFILE
FROM $docker
DOCKERFILE;
	file_put_contents( IMAGE_PATH . '' . $file, $content );

	if ( ! isset( $saved_images[ dirname( $file ) ] ) ) {
		$saved_images[ dirname( $file ) ] = array();
	}
	$saved_images[ dirname( $file ) ][] = $docker . '=' . basename( $file );
}


foreach ( $saved_images as $name => $tags ) {
	$markdown = array();
	foreach ( $tags as $tag ) {
		$tag        = explode( '=', $tag );
		$tag[3]     = $tag[0];
		$tag[0]     = explode( ':', $tag[0] );
		$markdown[] = "- [{$tag[3]}](https://hub.docker.com/_/{$tag[0][0]}?tab=tags&page=1&name={$tag[0][1]}) - `ghcr.io/docker-mirror/{$name}:{$tag[1]}`";
	}
	$markdown = implode( PHP_EOL, $markdown );
	$content  = <<<MARKDOWN
## $name - Images
$markdown
MARKDOWN;

	file_put_contents( IMAGE_PATH . $name . '/README.md', $content );

}