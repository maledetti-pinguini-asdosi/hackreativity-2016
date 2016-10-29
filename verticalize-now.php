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

is_logged()
	|| http_redirect( get_menu_entry('login')->url );

enqueue_css('leaflet');
enqueue_js('verticalize');
enqueue_js('leaflet');

new Header('app', [
	'container'  => false,
	'show-title' => false
] );
?>

<script>
$(document).ready(function () {
	Verticalize.init("<?php _esc_attr( get_user()->getUserNominatim() ) ?>");
});
</script>

<div class="row">
	<div class="col s12 m4">
		<div class="row">
			<div class="col s6">
				<p><?php _e("Elevazione:") ?></p>
				<div class="card-panel level-selector">
					<a class="btn-floating waves-effect waves-light <?php echo BACK ?>"><?php echo icon('add') ?></a>
					<a class="btn-floating waves-effect waves-light <?php echo BACK ?>"><?php echo icon('remove') ?></a>
				</div>
			</div>
		</div>
	</div>
	<div cla ss="col s12 m8">
		<div id="map"></div>
	</div>
</div>

<?php
new Footer();
