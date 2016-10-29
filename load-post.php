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

# This file is autoloaded after the Boz-PHP framework initialization.

#########################
# PACKAGABLE PATH NAMES #
#########################

defined('DIR_CONTENT')
	|| define('DIR_CONTENT',  'content');

defined('DIR_INCLUDES')
	|| define('DIR_INCLUDES', 'includes');

defined('DIR_STATIC')
	|| define('DIR_STATIC',   'static');

defined('CONTENT')
	|| define('CONTENT',  ROOT . _ . DIR_CONTENT);

// You know... "static" is a PHP reserved word! asd
defined('STITIC')
	|| define('STITIC',   ROOT . _ . DIR_STATIC);

########################################################
# PROBABLY PROVIDED BY 'libjs-jquery', 'libjs-leaflet' #
########################################################

defined('PATH_JQUERY')
	|| define('PATH_JQUERY',      '/javascript/jquery/jquery.min.js');

defined('PATH_LEAFLET_JS')
	|| define('PATH_LEAFLET_JS',  '/javascript/leaflet/leaflet.js');

defined('PATH_LEAFLET_CSS')
	|| define('PATH_LEAFLET_CSS', '/javascript/leaflet/leaflet.css');

########################
# PHP CLASS AUTOLOADER #
########################

// Autoload classes in the includes folder (on-demand! <3)
spl_autoload_register( function($missing_class_name) {
	$path = ABSPATH . _ . DIR_INCLUDES . "/$missing_class_name.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

require ABSPATH . _ . DIR_INCLUDES . '/functions.php';

######################################
# INTERNATIONALIZATION (GNU GETTEXT) #
######################################

define('DEFAULT_ISO_LANG',       'it');
define('GETTEXT_DOMAIN',         'main');
define('GETTEXT_DIRECTORY',      'l10n');
define('GETTEXT_DEFAULT_ENCODE', 'utf8');

register_language('en_US', ['en', 'en-us', 'en-en'] );
register_language('it_IT', ['it', 'it-it'] );

$l = null;
if( isset( $_REQUEST['l'] ) ) {
        $l = $_REQUEST['l'];
}
define('LANGUAGE_APPLIED', apply_language( $l ) );

################
# SITE RELATED #
################

defined('SITE_NAME')
	|| define('SITE_NAME', _("Maledetti Pinguini asdosi...!") );

defined('SITE_DESCRIPTION')
	|| define('SITE_DESCRIPTION', _("Progetto Hackreativity Fabriano 2016") );

defined('FAVICON')
	|| define('FAVICON', 'file:///asd');

############################
# MATERIALIZE CSS DEFAULTS #
############################

defined('TEXT')
	|| define('TEXT', 'black-text');

defined('GROUND')
	|| define('GROUND', 'teal');

defined('BTN')
	|| define('BTN',  'btn waves-effect waves-light ' . GROUND);

###############################
# JAVSCRIPT AND CSS RESOURCES #
###############################

register_js( 'jquery',         PATH_JQUERY);
register_js( 'leaflet',        PATH_LEAFLET_JS);
register_css('leaflet',        PATH_LEAFLET_CSS);
register_js( 'materialize',    STITIC . '/materialize/js/materialize.min.js');
register_css('materialize',    STITIC . '/materialize/css/materialize.min.css');
register_css('material-icons', STITIC . '/material-design-icons/material-icons.css');

#############
# MENU TREE #
#############

$not_logged = is_logged() ? 'hidden' : 'root';

add_menu_entries( [
	new MenuEntry('home',    URL,                _("Benvenuti"), 'root'),
	new MenuEntry('login',   URL . '/login.php', _("Login"),     $not_logged)
] );
