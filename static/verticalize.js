/*
 * Copyright (C) 2016 MPA: Maledetti pinguini asdosi
 * Alessio Beccati, Valerio Bozzolan and contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

var Verticalize = {
	config: {
		id: 'map',
		attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
		tiles: '/tiles/{s}/{z}/{x}/{y}.png',
		maxZoom: 20,
		nominatim: '/nominatim/search',
		overpass: '/overpass',
		view: [45.07050, 7.68254],
		zoom: 19,
		focusGap: 0.00018,
		$currentLevel: '.current-level',
		tagImage: null,
		saveAPI: '/api/save-bigdata.php'
	},
	l10n: {},

	bigdata: [],

	latestTagUid: null,

	Tag: function (uid, latLng, level) {
		this.uid = uid;
		this.latLng = latLng;

		if (typeof level === 'undefined') {
			level = Verticalize.getFocusedLevel();
		}
		this.level = level;

		Verticalize.Tag.prototype.getImage = function () {
			return Verticalize.config.tagImage + '/' + this.uid + '.png';
		};

		Verticalize.Tag.prototype.plot = function() {
			var i = L.icon( {
				iconUrl: this.getImage(),
				iconSize:    [32, 32], // size of the icon
				iconAnchor:  [16, 32], // point of the icon which will correspond to marker's location
				popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
			} );

			var m = L.marker(this.latLng, {icon: i, draggable: true});
			m.tag = this;
			m.on('drag', function(e) {
				var marker = e.target;
				var position = marker.getLatLng();
				marker.tag.latLng = position;
			});
			Verticalize.addLayer( m );

			return this;
		};
	},

	pickTag: function(el) {
		$el = $(el);
		var tag_uid = $(el).data('uid');
		var geojson = Verticalize.findGeojsonLevel( Verticalize.getFocusedLevel() );
		var bounds = geojson.getBounds();
		var latLng = bounds.getCenter();
		var tag = new Verticalize.Tag(tag_uid, latLng);
		Verticalize.appendTag( tag.plot() );
	},

	appendTag: function(tag) {
		return Verticalize.bigdata.push(tag);
	},

	findGeojsonLevel: function(level) {
		if (typeof level === 'undefined') {
			level = Verticalize.getFocusedLevel();
		}

		var found = false;
		for (var i in Verticalize.layers._layers) {
			var layer = Verticalize.layers._layers[i];
			for (var j in layer._layers) {
				var geojson = layer._layers[j];
				if( geojson.options.level === level ) {
					return geojson;
				}
			}
		}
		return false;
	},

	map: null,

	geojson: {},

	levels: 10,
	minusLevels: 0,

	layers: false,

	focusedLevel: false,
	focusLevel: function (level) {
		Verticalize.focusedLevel = level;
		Verticalize.plot();
		Verticalize.$currentLevel.text( Verticalize.l10n.currentLevel.formatUnicorn({
			level: Verticalize.humanLevel(level)
		}) );
	},

	addLevel: function () {
		Verticalize.levels++;
		Verticalize.plot();
	},

	addMinusLevel: function () {
		Verticalize.minusLevels++;
		Verticalize.plot();
	},

	removeLevel: function () {
		if( Verticalize.levels > 1 ) {
			Verticalize.levels--;
			Verticalize.plot();
		}
	},

	removeMinusLevel: function () {
		if( Verticalize.minusLevels > 0 ) {
			Verticalize.minusLevels--;
			Verticalize.plot();
		}
	},

	clearLayers: function () {
		if( Verticalize.layers !== false ) {
			Verticalize.layers.clearLayers();
		}
	},

	addLayer: function (layer) {
		if( Verticalize.layers === false ) {
			Verticalize.layers = new L.LayerGroup();
			Verticalize.layers.addLayer( layer );
			Verticalize.map.addLayer( Verticalize.layers );
		} else {
			Verticalize.layers.addLayer( layer );
		}
	},

	init: function (nominatim) {
		Verticalize.map = L.map(Verticalize.config.id);

		if(Verticalize.bigdata) {
			console.log(Verticalize.bigdata);
		}

		Verticalize.$currentLevel = $(Verticalize.config.$currentLevel);

		var osm = new L.TileLayer( Verticalize.config.tiles, {
			maxZoom:     Verticalize.config.maxZoom,
			attribution: Verticalize.config.attribution
		} );

		// Unused
		Verticalize.map.setView(Verticalize.config.view, Verticalize.config.zoom).addLayer(osm);

		Verticalize.plotNominatim( nominatim );
	},

	humanLevel: function(level) {
		if(level === 0) {
			level = Verticalize.l10n.ground;
		} else if(level > 0) {
			level = Verticalize.l10n.level.formatUnicorn({level: level});
		}
		return level;
	},

	plotGeoJson: function (geojson) {
		Verticalize.addLayer(
			L.geoJson(geojson, {
				style: function (feature) {
					return feature.geometry.properties;
				},
				onEachFeature: function (feature, layer) {
					var level = Verticalize.humanLevel(feature.properties.level);
					layer.bindPopup( Verticalize.l10n.levelPopup.formatUnicorn( { level: level } ) )
					     .on('click', function (e) {
						Verticalize.focusLevel( e.target.options.level );
					     } );
				}
			} )
		);
	},

	plotNominatim: function(nominatim, callback) {
		var data = {q: nominatim, format: 'json', polygon_geojson: 1, limit: 1};
		$.getJSON(Verticalize.config.nominatim, data, function(json) {
			if( ! json || json.length !== 1 ) {
				Materialize.error( Verticalize.l10n.connectionError );
				return;
			}

			for(var i=0; i<json.length; i++) {
				Verticalize.geojson = json[i].geojson;
				Verticalize.map.setView([json[i].lat, json[i].lon], Verticalize.config.zoom);
				Verticalize.plot();
			}
		});
	},

	plot: function() {
		Verticalize.clearLayers();
		Verticalize.geoJson3D();
		Verticalize.plotLevelTags();
	},

	gap: function (level) {
		if(Verticalize.focusedLevel === false || level <= Verticalize.focusedLevel) {
			return 0;
		}
		return Verticalize.config.focusGap;
	},

	getFocusedLevel: function() {
		if( Verticalize.focusedLevel === false ) {
			Verticalize.focusLevel(Verticalize.levels - 1);
		}
		return Verticalize.focusedLevel;		
	},

	cloneGeojsonSpased: function (level, properties) {
		// JavaScript #merda
		geojson = JSON.parse(JSON.stringify(Verticalize.geojson));

		var coordinates = [];

		if( ! geojson.coordinates ) {
			return;
		}

		for(var i=0; i<geojson.coordinates.length; i++) {
			coordinates[i] = [];
			for(var j=0; j<geojson.coordinates[i].length; j++) {
				coordinates[i][j] = [];
				coordinates[i][j][0] = Verticalize.planLat(geojson.coordinates[i][j][0], level);
				coordinates[i][j][1] = Verticalize.planLng(geojson.coordinates[i][j][1], level);
			}
		}

		return {
			type: geojson.type,
			coordinates: coordinates,
			properties: properties
		};
	},

	plotLevelTags: function(level) {
		if(typeof level === 'undefined') {
			level = Verticalize.getFocusedLevel();
		}

		for(var i in Verticalize.bigdata) {
			var tag = Verticalize.bigdata[i];

			if(tag.level === level) {
				tag.plot();
			}
		}
	},

	planLat: function(lat, level) {
		return lat - ( level * 0.00000002 + Verticalize.gap(level) );
	},

	planLng: function(lng, level) {
		return lng + ( level * 0.00004    + Verticalize.gap(level) );
	},

	geoJson3D: function () {
		for(var i=Verticalize.minusLevels; i>0; i--) {
			var cloned = Verticalize.cloneGeojsonSpased(-i, {
				level: -i,
				fillColor: 'white',
				fillOpacity: 0.2,
				weight: 3
			});
			Verticalize.plotGeoJson( cloned );
		}
		for(var i=0; i<Verticalize.levels; i++) {
			var cloned = Verticalize.cloneGeojsonSpased(i, {
				level: i,
				fillColor: '#009688',
				fillOpacity: 1
			});
			Verticalize.plotGeoJson( cloned );
		}
	},
	save: function() {
		$.post(Verticalize.config.saveAPI, {
			bigdata: JSON.stringify( Verticalize.bigdata )
		} );
		Materialize.toast(Verticalize.l10n.saved);
	}
};

/*
 * This is so... asd
 *
 * http://stackoverflow.com/questions/610406/javascript-equivalent-to-printf-string-format
 */
String.prototype.formatUnicorn = function() {
	var str = this.toString();
	if( ! arguments.length ) {
		return str;
	}
	var args = typeof arguments[0],
	args = ( ('string' == args || 'number' == args) ? arguments : arguments[0] );
        for(var arg in args) {
		str = str.replace(RegExp('\\{' + arg + '\\}', 'gi'), args[arg]);
	}
	return str;
};
