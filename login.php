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

$status = null;

isset($_GET['logout'])
	&& logout();

isset( $_POST['user_uid'], $_POST['user_password'] )
	&& login($status);

is_logged()
	&& http_redirect( get_menu_entry('app')->url );

switch($status) {
	case Session::LOGIN_FAILED:
		message_box( _("Errore indirizzo e-mail/password") );
		break;
	case Session::USER_DISABLED:
		message_box( _("Utente disabilitato") );
		break;
}

new Header('login');

if( is_logged() ):
?>
	<p class="flow-text"><?php _e("Sei loggato!") ?></p>
	<p><?php echo HTML::a(
		ROOT . '/login.php?logout',
		_("Sloggati") . icon('exit_to_app', 'left')
	) ?></p>

<?php else: ?>
	<div class="row">
		<form method="post">
			<div class="row">
        			<div class="col s12 m6 l5">
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col s12">
									<div class="input-field">
										<label for="user_uid"><?php _e("E-mail") ?></label>
										<input name="user_uid" id="user_uid" type="text" class="validate"<?php
											echo HTML::property('value', @$_REQUEST['user_uid'] )
										?> />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<div class="input-field">
										<label for="user_password"><?php _esc_attr( _("Password") ) ?></label>
										<input name="user_password" id="user_password" type="password" class="validate" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12 center">
									<p>
									<button class="<?php echo BTN ?>" type="submit">
										<?php _e("Accedi") ?>
										<?php echo icon('send', 'right') ?>
									</button>
									</p>
								</div>
							</div>
						</div>
						<!-- End card content -->
					</div>
					<!-- End card -->
				</div>
				<!-- End col -->
				<div class="col s12 m5 offset-m1 l6 offset-l1">
					<div class="row">
						<div class="col s12">
							<h4>
								<?php _e("Indoor Mapping"); ?>
							</h4>
							<p class="flow-text">
								<?php _e("Pensando a cosa mancava, nella consapevolezza delle persone, abbiamo immaginato un nuovo approccio per comunicare vari rischi, per me, per te e per voi."); ?>
							</p>
						</div>
					</div>
				</div>
				<!-- End col -->
			</div>
			<!-- End row -->
		</form>
	</div>
<?php
endif;

new Footer();
