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

trait UserTrait {
	function getUserFullname() {
		return sprintf(
			_('%1$s %2$s'),
			$this->user_name,
			$this->user_surname
		);
	}

	function getUserID() {
		isset($this->user_ID)
			|| error_die("Missing user_ID");

		return $this->user_ID;
	}

	function getUserUID() {
		isset($this->user_uid)
			|| error_die("Missing user_uid");

		return $this->user_uid;
	}
}

class User extends Sessionuser {
	use UserTrait;

	function __construct() {
		self::normalize();
	}

	function normalize(& $t) {
		if( isset( $t->user_ID ) ) {
			$t->user_ID = (int) $t->user_ID;
		}
	}

	function insert($uid, $password, $name, $surname, $active = true, $token = null) {
		$uid     = luser_input($uid,     32);
		$name    = luser_input($name,    32);
		$surname = luser_input($surname, 32);
		$active  = $active ? 1 : 0;

		// Boz-PHP Sessionuser
		$password = self::encryptSessionuserPassword( $password );

		insert_row('user', [
			new DBCol('user_uid',               $uid,      's'),
			new DBCol('user_active',            $active,   'd'),
			new DBCol('user_password',          $password, 's'),
			new DBCol('user_name',              $name,     's'),
			new DBCol('user_surname',           $surname,  's'),
			new DBCol('user_registration_date', 'NOW()',   '-'),
			new DBCol('user_token',             $token,    'snull')
		] );
	}

	function getByID($id) {
		return query_row(
			sprintf(
				"SELECT * FROM user WHERE user_ID = %d",
				$id
			),
			'User'
		);
	}
}
