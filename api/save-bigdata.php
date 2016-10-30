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

require '../load.php';

echo http_json_header();

if( ! is_logged() ) {
	echo json_encode(['please-login-in' => true]);
	exit;
}

if( ! isset( $_POST['bigdata'] ) ) {
	echo json_encode(['missing-bigdata' => true]);
	exit;
}

query_update('user',
	new DBCol('user_bigdata', $_POST['bigdata'], 's'),
	sprintf(
		'user_ID = %d',
		get_user()->getUserID()
	)
);

echo json_encode(['ok' => true]);

