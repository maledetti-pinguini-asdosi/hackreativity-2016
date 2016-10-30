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

class Footer {
	function __construct() { ?>

	<?php load_module('footer') ?>

	<footer class="page-footer <?php echo GROUND ?>">
		<div class="container">
			<div class="row">
				<h5 class="white-text"><?php _e("Licenza"); ?></h5>
				<p class="white-text"><?php printf(
					_("Software libero pubblicato sotto licenza %s."),
					HTML::a(
						_("https://www.gnu.org/licenses/agpl-3.0.html"),
						"GNU AGPL",
						"GNU Affero General Public License",
						'yellow-text',
						'target="_blank"'
					)
				) ?></p>
				<p class="white-text"><?php printf(
					_("Contenuti del sito rilasciati come opera culturale libera sotto licenza %s."),
					HTML::a(
						_('https://creativecommons.org/licenses/by-sa/4.0/deed.it'),
						"CC By-Sa 4.0",
						_("Creative Commons Attribuzione - Condividi allo stesso modo 4.0"),
						'yellow-text',
						'target="_blank"'
					)
				) ?></p>
			</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
				<a class="hoverable white-text right" href="https://github.com/maledetti-pinguini-asdosi/hackreativity-2016">git clone</a>
			</div>
		</div>
	</footer>
	<script>
	$(document).ready(function () {
		$(".button-collapse").sideNav();
	} );
	</script>
</body>
</html><?php

		#################
		# END CONSTRUCT #
		#################
	}
}
