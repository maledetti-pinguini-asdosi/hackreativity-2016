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
		focusGap: 0.0001
	},

	l10n: {
		connectionError: null
	},

	map: null,

	geojson: {},

	levels: 10,
	minusLevels: 0,

	layers: false,

	focusedFloor: false,

	focusFloor: function(floor) {
		Verticalize.focusedFloor = floor;
		Verticalize.plot();
	},

	addLevel: function() {
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

	clearGeojsonLayers: function () {
		if( Verticalize.layers !== false ) {
			Verticalize.layers.clearLayers();
		}
	},

	addGeojsonLayer: function (layer) {
		if( Verticalize.layers === false ) {
			Verticalize.layers = new L.LayerGroup();
			Verticalize.layers.addLayer( layer );
			Verticalize.map.addLayer( Verticalize.layers );
		} else {
			Verticalize.layers.addLayer( layer );
		}
	},

	init: function(nominatim) {
		Verticalize.map = L.map(Verticalize.config.id);

		var osm = new L.TileLayer( Verticalize.config.tiles, {
			maxZoom:     Verticalize.config.maxZoom,
			attribution: Verticalize.config.attribution
		} );

		// Unused
		Verticalize.map.setView(Verticalize.config.view, Verticalize.config.zoom).addLayer(osm);

		Verticalize.plotNominatim( nominatim );
	},

	plotGeoJson: function(geojson) {
		Verticalize.addGeojsonLayer(
			L.geoJson(geojson, {
				style: function (feature) {
					return feature.geometry.properties;
				},
				onEachFeature: function (feature, layer) {
					var floor = feature.properties.floor;
					if(floor === 0) {
						floor = Verticalize.l10n.ground;
					}
					layer.bindPopup( Verticalize.l10n.floorPopup.formatUnicorn( { floor: floor } ) )
					     .on('click', function (e) {
						Verticalize.focusFloor( e.target.options.floor );
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
		Verticalize.clearGeojsonLayers();
		Verticalize.geoJson3D();
	},

	gap: function(floor) {
		if(Verticalize.focusedFloor === false || floor <= Verticalize.focusedFloor) {
			return 0;
		}
		return Verticalize.config.focusGap;
	},

	cloneGeojsonSpased: function(level, properties) {
		// JavaScript #merda
		geojson = JSON.parse(JSON.stringify(Verticalize.geojson));

		var coordinates = [];

		var gap = Verticalize.gap(level);
		for(var i=0; i<geojson.coordinates.length; i++) {
			coordinates[i] = [];
			for(var j=0; j<geojson.coordinates[i].length; j++) {
				coordinates[i][j] = [];
				coordinates[i][j][0] = geojson.coordinates[i][j][0] += - level * 0.0000005 - gap;
				coordinates[i][j][1] = geojson.coordinates[i][j][1] +=   level * 0.00004   + gap;
			}
		}

		return {
			type: geojson.type,
			coordinates: coordinates,
			properties: properties
		};
	},

	geoJson3D: function() {
		for(var i=Verticalize.minusLevels; i>0; i--) {
			var cloned = Verticalize.cloneGeojsonSpased(-i, {
				floor: -i,
				fillColor: 'white',
				fillOpacity: 0.2,
				weight: 3
			});
			Verticalize.plotGeoJson( cloned );
		}
		for(var i=0; i<Verticalize.levels; i++) {
			var cloned = Verticalize.cloneGeojsonSpased(i, {
				floor: i,
				fillColor: '#009688',
				fillOpacity: 1
			});
			Verticalize.plotGeoJson( cloned );
		}
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
