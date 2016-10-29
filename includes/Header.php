<?php
###############################################################################
# Copyright (C) 2016 MPA: Maledetti pinguini asdosi                           #
# Alessio Beccati, Valerio Bozzolan and contributors                          #
###############################################################################
# This program is free software: you can redistribute it and/or modify        #
# it under the terms of the GNU Affero General Public License as published by #
# the Free Software Foundation, either version 3 of the License, or           #
# (at your option) any later version.                                         #
#                                                                             #
# This program is distributed in the hope that it will be useful,             #
# but WITHOUT ANY WARRANTY; without even the implied warranty of              #
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               #
# GNU Affero General Public License for more details.                         #
#                                                                             #
# You should have received a copy of the GNU Affero General Public License    #
# along with this program.  If not, see <http://www.gnu.org/licenses/>.       #
###############################################################################

class Header {
	function __construct($menu_uid, $args = []) {

		$menu = get_menu_entry($menu_uid);

		#####################
		# DEFAULT ARGUMENTS #
		#####################

		$args = merge_args_defaults($args, [
			// Show page title
			'show-title'    => true,

			// Nav title
			'nav-title'     => SITE_NAME,

			// Head title
			'head-title'    => null,

			// Page title
			'title'         => $menu->name,

			// Permalink
			'url'           => $menu->url,

			// 404 header
			'not-found'     => false,

			// Show user navbar
			'user-navbar'   => true,

			// Materializecss container
			'container'     => true,

			// Enqueue default resources?
			'default-theme' => true,

			// ISO 639 language code
			'iso-lang'      => DEFAULT_ISO_LANG,

			'charset'       => CHARSET,

			// Landing image path
			'landing'       => false,

			// Landing image alt
			'landing-alt'   => SITE_NAME
		] );

		##################
		# CHARSET HEADER #
		##################

		$args['charset']
			|| header("Content-Type: text/html; charset={$args['charset']}");

		##############
		# HEAD TITLE #
		##############

		if( $args['head-title'] === null ) {
			$args['head-title'] = sprintf(
				_("%s - %s"),
				$args['title'],
				$args['nav-title']
			);
		}

		#######
		# 404 #
		#######
		if( $args['not-found'] ) {
			header('HTTP/1.1 404 Not Found');
		}

		###########
		# OG META #
		###########

		if( ! isset( $args['og'] ) ) {
			$args['og'] = [];
		}

		$args['og'] = merge_args_defaults($args['og'], [
			/*'image'  => DEFAULT_LOGO,*/
			'type'   => 'website',
			'url'    => $args['url'],
			'title'  => $args['title']
		] );

		################################
		# CSS AND JAVASCRIPT RESOURCES #
		################################

		if( $args['default-theme'] ) {
			enqueue_js('jquery');
			enqueue_js('materialize');
			enqueue_css('materialize');
			enqueue_css('materialize.custom');
			enqueue_css('material-icons');
		}

		#############################
		# CLOSING CONTAINER IF USED #
		#############################

		if( $args['container'] ) {
			inject_in_module('footer', function() { ?>
				</div>
				<!-- End container -->
			<?php } );
		}

		###########
		# LANDING #
		###########
		if( $args['landing'] ) {
			inject_in_module('footer', function() { ?>
				<script>
				$(document).ready( function () {
				        $('.button-collapse').sideNav();
				        $('.parallax').parallax();
				} );
				</script>
			<?php } );
		}

		######################################
		# HTML ISO LANGUAGE FROM GNU GETTEXT #
		######################################

		$l = latest_language();
		$l = $l ? $l->getISO() : $args['iso-lang'];
		?>
<!DOCTYPE html>
<html>
<head>
	<!--
	  ____ _   _ _   _   ___     _                    _       _____
	 / ___| \ | | | | | / / |   (_)_ __  _   ___  __ (_)___  |  ___| __ ___  ___
	| |  _|  \| | | | |/ /| |   | | '_ \| | | \ \/ / | / __| | |_ | '__/ _ \/ _ \
	| |_| | |\  | |_| / / | |___| | | | | |_| |>  <  | \__ \ |  _|| | |  __/  __/
	 \____|_| \_|\___/_/  |_____|_|_| |_|\__,_/_/\_\ |_|___/ |_|  |_|  \___|\___|
	             _         _____                  _
	  __ _ ___  (_)_ __   |  ___| __ ___  ___  __| | ___  _ __ ___
	 / _` / __| | | '_ \  | |_ | '__/ _ \/ _ \/ _` |/ _ \| '_ ` _ \
	| (_| \__ \ | | | | | |  _|| | |  __/  __/ (_| | (_) | | | | | |
	 \__,_|___/ |_|_| |_| |_|  |_|  \___|\___|\__,_|\___/|_| |_| |_|


	After reading this... we hope that you will think:
	«Maledetti pinguini asdosi...!!!»

	-->
	<title><?php echo $args['head-title'] ?></title>

	<?php foreach($args['og'] as $og => $content): ?>
	<meta property="og:<?php echo $og ?>" content="<?php echo $content ?>" />
	<?php endforeach ?>

	<?php load_module('header') ?>

</head>
<body>

	<?php new Nav() ?>

	<?php if( $args['landing'] ): ?>
	<div class="parallax-container">
		<div class="parallax">
			<img src="<?php echo $args['landing'] ?>" alt="<?php _esc_attr( $args['landing-alt'] ) ?>">
		</div>
	</div>
	<?php endif ?>

	<?php if( $args['show-title'] ): ?>
	<header class="container">
		<?php if( isset( $args['url'] ) ): ?>

		<h1><?php echo HTML::a($args['url'], $args['title'], null, TEXT) ?></h1>
		<?php else: ?>

		<h1><?php echo $args['title'] ?></h1>
		<?php endif ?>
	</header>
	<?php endif ?>

	<?php if( $args['container'] ): ?>
	<!-- Start container -->
	<div class="container">

	<?php endif ?>

		<?php
		#################
		# CONSTRUCT END #
		#################
	}
}
