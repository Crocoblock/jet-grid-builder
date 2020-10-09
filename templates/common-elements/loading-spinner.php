<?php
/**
 * Loading spinner template
 */

$loading_spinner_type = $settings['loading_spinner_type'];
$spinners_structure = array(
	'circle-clip-growing' => 'custom',
	'circle-clip'         => 1,
	'circle'              => 2,
	'lines-wave'          => 5,
	'lines-pulse'         => 5,
	'lines-pulse-rapid'   => 5,
	'cube-grid'           => 9,
	'cube-folding'        => 4,
	'wordpress'           => 2,
	'hash'                => 2,
	'dots-grid-pulse'     => 9,
	'dots-grid-beat'      => 9,
	'dots-circle'         => 12,
	'dots-pulse'          => 3,
	'dots-elastic'        => 3,
	'dots-carousel'       => 1,
	'dots-windmill'       => 3,
	'dots-triangle-path'  => 3,
	'dots-bricks'         => 3,
	'dots-fire'           => 3,
	'dots-rotate'         => 1,
	'dots-bouncing'       => 3,
	'dots-chasing'        => 1,
	'dots-propagate'      => 6,
	'dots-spin-scale'     => 2,
);

?>

<div class="jgb_spinner">
	<div class="jgb_spinner-<?php echo esc_attr( $loading_spinner_type ); ?>">
		<?php
			if ( 'integer' === gettype( $spinners_structure[ $loading_spinner_type ] ) ) {
				for ( $i = 0; $i < $spinners_structure[ $loading_spinner_type ]; $i++ ) {
					echo '<div></div>';
				}
			} else {
				?>
				<svg viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg>
				<?php
			}
		?>
	</div>
</div>