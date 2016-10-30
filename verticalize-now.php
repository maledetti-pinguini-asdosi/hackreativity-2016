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

<div class="row">
	<div class="col s12 m8 no-padding-left">
		<div id="map"></div>
	</div>
	<div class="col s12 m4">
		<div class="row">
			<div class="col s6">
				<h5 class="center"><?php _e("Elevazione") ?></h5>
				<div class="level-selector">
					<div class="row center">
						<div class="col s6">
							<a class="up btn-floating waves-effect waves-light <?php echo GROUND ?>"><?php echo icon('add') ?></a>
						</div>
						<div class="col s6">
							<a class="down btn-floating waves-effect waves-light <?php echo GROUND ?>"><?php echo icon('remove') ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col s6">
				<h5 class="center"><?php _e("Delevazione") ?></h5>
				<div class="minlevel-selector">
					<div class="row center">
						<div class="col s6">
							<a class="up btn-floating waves-effect waves-light <?php echo GROUND ?>"><?php echo icon('add') ?></a>
						</div>
						<div class="col s6">
							<a class="down btn-floating waves-effect waves-light <?php echo GROUND ?>"><?php echo icon('remove') ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row tag-picker">
			<div class="col s12">
				<?php
				$tags = [
					new Tag('extinguisher', _("Estintore") ),
					new Tag('exit',         _("Uscita") ),
					new Tag('hydrant',      _("Idrante") ),
					new Tag('voltage',      _("Alta tensione") ),
					new Tag('fire_alarm',   _("Allarme") )
				];
				foreach($tags as $tag) {
					$tag->printTagChip();
				}
				?>
			</div>
			<div class="col s12">
				<p class="current-level"></p>
			</div>
			<p><button class="<?php echo BTN ?> bigdata-save"><?php _e("Salva"); echo icon('save', 'right') ?></button></p>
		</div>
	</div>
</div>

<script>
$(document).ready(function () {
	$("#map").height( $(document).height() - $("nav").height() );

	<?php new Verticalize() ?>

	$('.level-selector .up')        .click(Verticalize.addLevel);
	$('.level-selector .down')      .click(Verticalize.removeLevel);
	$('.minlevel-selector .up')     .click(Verticalize.addMinusLevel);
	$('.minlevel-selector .down')   .click(Verticalize.removeMinusLevel);
	$('.tag-picker a .tag-selector').click( function (e) {
		Verticalize.pickTag( $(this) );
		e.preventDefault();
	} );
	$('.bigdata-save').click(Verticalize.save);
});
</script>

<?php
new Footer();
