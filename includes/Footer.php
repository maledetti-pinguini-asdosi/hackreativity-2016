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
              			<!-- Mettiamo roba qui  -->
				</div>
          		</div>
		</div>
		<div class="footer-copyright">
			<div class="container">
            			© 2014 Copyright Text
				<a class="grey-text text-lighten-4 right" href="#!">Developed by MPA</a>
			</div>
		 </div>
	</footer>
</body>
</html><?php

		#################
		# END CONSTRUCT #
		#################
	}
}