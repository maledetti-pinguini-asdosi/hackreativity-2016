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
		zoom: 19
	},

	map: null,

	geojson: {},

	levels: 10,
	minusLevels: 0,

	layers: false,

	addLevel: function() {
		Verticalize.levels++;
	},

	addMinusLevel: function () {
		Verticalize.minusLevels++;
	},

	removeLevel: function () {
		if( Verticalize.levels > 0 ) {
			Verticalize.levels--;
		}
	},

	removeMinusLevel: function () {
		if( Verticalize.minusLevels > 0 ) {
			Verticalize.minusLevels--;
		}
	},

	clearGeojsonLayers: function () {
		if( Verticalize.layers !== false ) {
			// is L.LayerGroup()
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
					// featuregroup
					return {};
				},
				onEachFeature: function (feature, layer) {
					// layer.bindPopup(feature.properties.description);
				}
			} )
		);
	},

	plotNominatim: function(nominatim, callback) {
		Verticalize.clearGeojsonLayers();

		var data = {q: nominatim, format: "json", polygon_geojson: 1, limit: 1};
		$.getJSON(Verticalize.config.nominatim, data, function(json) {
			if( ! json || json.length !== 1) {
				Materialize.error("Connection error");
				return;
			}

			for(var i=0; i<json.length; i++) {
				Verticalize.geojson = json[i].geojson;
				Verticalize.map.setView([json[i].lat, json[i].lon], Verticalize.config.zoom);
				Verticalize.geoJson3D();
			}
		});
	},

	cloneGeojsonSpased: function(level) {
		// JavaScript MERDA
		geojson = JSON.parse(JSON.stringify(Verticalize.geojson));

		var coordinates = [];

		for(var i=0; i<geojson.coordinates.length; i++) {
			coordinates[i] = [];
			for(var j=0; j<geojson.coordinates[i].length; j++) {
				coordinates[i][j] = [];
				coordinates[i][j][0] = geojson.coordinates[i][j][0] += - level * 0.00000001;
				coordinates[i][j][1] = geojson.coordinates[i][j][1] +=   level * 0.00001;
			}
		}

		return {
			type: geojson.type,
			coordinates: coordinates
		};
	},

	geoJson3D: function() {
		for(var i=0; i<Verticalize.levels; i++) {
			Verticalize.plotGeoJson( Verticalize.cloneGeojsonSpased(i) );
		}
	}
};
