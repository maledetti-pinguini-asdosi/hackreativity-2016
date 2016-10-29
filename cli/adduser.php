#!/usr/bin/php
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

if( ! isset( $argv ) || count( $argv ) !== 5 ) {
	printf(
		"Usage: %s <uid> <password> <name> <surname>",
		$argv[0]
	);
	echo "\n";
	exit(1);
}

User::insert($argv[1], $argv[2], $argv[3], $argv[4]);
