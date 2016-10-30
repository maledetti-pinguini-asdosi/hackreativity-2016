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

class Verticalize {
	function __construct($nominatim = null, $bigdata = null) {
		if($nominatim === null) {
			$nominatim = get_user()->getUserNominatim();
		}

		if($bigdata === null) {
			$bigdata = get_user()->getUserBigdata();
		}
	?>

	Verticalize.l10n = {
		connectionError: "<?php _esc_attr( _("Errore di rete") ) ?>",
		level:           "<?php _esc_attr( _("{level}°") ) ?>",
		levelPopup:      "<?php _esc_attr( _("Piano {level}.") ) ?>",
		ground:          "<?php _esc_attr( _("terra") ) ?>",
		currentLevel:    "<?php _esc_attr( _("Piano corrente: {level}.") ) ?>",
		saved:           "<?php _esc_attr( _("Salvato") ) ?>"
	};
	Verticalize.bigdata         =  JSON.parse('<?php echo $bigdata ?>');
	for(var i in Verticalize.bigdata) {
		var tag = Verticalize.bigdata[i];
		Verticalize.bigdata[i] = new Verticalize.Tag(tag.uid, tag.latLng, tag.level);
	}

	Verticalize.config.tagImage =  "<?php echo TAG ?>";
	Verticalize.levels =    <?php echo get_user()->getUserLevels() ?>;
	Verticalize.minusLevels = <?php echo get_user()->getUserMinusLevels() ?>;
	Verticalize.init("<?php _esc_attr( $nominatim ) ?>");

	<?php }
}
