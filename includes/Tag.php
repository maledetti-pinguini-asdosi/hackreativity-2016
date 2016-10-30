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

class Tag {
	function __construct($uid, $name) {
		$this->uid = $uid;
		$this->name = $name;
	}

	function getImage() {
		return TAG . "/{$this->uid}.png";
	}

	function printTagChip() { ?>
		<a href="#">
			<div class="chip tag-selector hoverable" data-uid="<?php echo $this->uid ?>">
				<img src="<?php echo $this->getImage() ?>" alt="<?php echo $this->name ?>" />
				<?php echo $this->name ?>
			</div>
		</a>
	<?php }
}
