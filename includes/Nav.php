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

class Nav {
	function __construct() {
?>

	<nav>
		<div class="nav-wrapper <?php echo GROUND ?>">
			<a class="brand-logo" href="<?php echo URL ?>" title="<?php _esc_attr( SITE_NAME ) ?>">
				<img src="<?php echo FAVICON ?>" alt="<?php _esc_attr( SITE_DESCRIPTION ) ?>" />
			</a>
			<a href="#" data-activates="slide-out" class="button-collapse"><?php echo icon('menu') ?></a>
			<?php print_menu(
				'root',
				0, [
					'main-ul-intag' => 'class="right hide-on-med-and-down"'
				]
			) ?>

		</div>
		<?php print_menu(
			'root',
			0, [
				'main-ul-intag' => 'id="slide-out" class="side-nav"',
				'collapse' => true,
				'pre' => function() { ?>
			<?php if( is_logged() ): ?>
			<li>
				<div class="userView">
					<img class="background" src="<?php echo IMAGES ?>/map_menu.jpg" />
					<a href="#!user"><img class="circle" src="<?php echo get_user()->getUserImage() ?>" /></a>
					<a href="#!name"><span class="white-text name"><?php echo get_user()->getUserFullName() ?></span></a>
					<a href="#!email"><span class="white-text email"><?php echo get_user()->getUserEmail() ?></span></a>
				</div>
			</li>
			<li><div class="divider"></div></li>
			<?php endif ?>
				<?php }
			]
		) ?>

	</nav>
<?php
	}
}
