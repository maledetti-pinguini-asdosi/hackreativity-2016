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

require 'load.php';

new Header('home', [
	'landing' => IMAGES . '/north_italy.png'
] );

?>

	<div class="row">
		<div class="col s12 m6">
			<div class="card">
				<div class="card-content">
					<h4><?php _e("Awareness") ?></h4>
					<p>
						<span class="card-title"><?php _e("La consapevolezza fa la differenza in una situazione di emergenza.") ?></span>
					</p>
				</div>
			</div>
		</div>
		<div class="col s12 m6">
			<div class="card">
				<div class="card-content">
					<h4><?php _e("Incognizance") ?></h4>
					<p>
						<span class="card-title"><?php _e("Ogni giorno, affrontiamo diversi pericoli, consapevoli dei rischi.") ?></span>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="parallax-container">
		<div class="parallax"><img src="<?php echo IMAGES ?>/center_italy.png" ></div>
	</div>
	<div class="row">
		<div class="col s12 m6">
			<div class="card">
				<div class="card-content">
					<h4><?php _e("Contribute") ?></h4>
					<p>
						<span class="card-title"><?php _e("Avevamo immaginato possibili soluzioni per contribuire a diffondere la consapevolezza dei rischi.") ?></span>
					</p>
				</div>
			</div>
		</div>
		<div class="col s12 m6">
			<div class="card">
				<div class="card-content">
					<h4><?php _e("Another type of map") ?></h4>
					<p>
						<span class="card-title"><?php _e("individuare, mappare, condividere, ogni oggetto, ogni edificio dall'interno") ?></span>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="parallax-container">
		<div class="parallax"><img src="<?php echo IMAGES ?>/sud_italy.png" ></div>
	</div>

	<div class="row center">
		<p><?php echo menu_link('app') ?></p>
	</div>
<?php

new Footer();
