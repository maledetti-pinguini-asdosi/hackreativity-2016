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
					<h4><?php _e("Platform per?") ?></h4>
					<p>
						<span class="card-title"><?php _e("Indoormap è usato per identificare, mappare e condividere oggetti rilevanti dentro un edificio.") ?></span>
					</p>
				</div>
			</div>
		</div>
		<div class="col s12 m6">
			<div class="card">
				<div class="card-content">
					<h4>Sicurezza?</h4>
					<p>
						<span class="card-title"><?php _e("Indoormap ti fornisce sicurezza. Se sei un utente registrato puoi segnalare edifici daneggiati da eventi sismici, pericolanti. ") ?></span>
					</p>
				</div>
			</div>
		</div>
	</div>

	<p><?php echo menu_link('app') ?></p>
<?php

new Footer();
