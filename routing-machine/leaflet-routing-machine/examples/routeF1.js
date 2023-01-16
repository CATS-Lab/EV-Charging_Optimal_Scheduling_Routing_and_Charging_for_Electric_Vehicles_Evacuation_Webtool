
async function get_data() {
	const response = await fetch('userResult.csv');
	const data = await response.text();
	const arrivT = [];
	const city = [];
	const arrivE = [];
	const lat = [];
	const lon = [];
	const rows = data.split('\n');
	rows.forEach(row => {
		const cols = row.split(',');
		arrivT.push(cols[0]);
		city.push(cols[2]);
		arrivE.push(cols[3]);
		lat.push(cols[4]);
		lon.push(cols[5]);
	});

	const node = [];
	for (let i = 0; i < lon.length; i++) {
		node[i] = [lat[i], lon[i], arrivT[i], city[i], arrivE[i]];
	};
	//console.log(node);
	return (node);
}


loadMap();

async function loadMap() {
	const nodeCs = await get_data();
	//console.log(nodeCs[1][2],',',nodeCs[1][3]);
	const via = [];
	const arrT = [];
	const arrC = [];
	const arrE = [];
	for (let i = 0; i < nodeCs.length; i++) {
		via[i] = [nodeCs[i][0], nodeCs[i][1]];
		arrT[i] = nodeCs[i][2];
		arrC[i] = nodeCs[i][3];
		arrE[i] = nodeCs[i][4];
	};

	let map = L.map('map');
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	var control = L.Routing.control(L.extend(window.lrmConfig, {
		/*  waypoints: [
			L.latLng(via[0]),
			L.latLng(via[1]),

		],  */

		geocoder: L.Control.Geocoder.nominatim(),
		routeWhileDragging: true,
		reverseWaypoints: true,
		showAlternatives: true,
		altLineOptions: {
			styles: [
				{ color: 'black', opacity: 0.15, weight: 9 },
				{ color: 'white', opacity: 0.8, weight: 6 },
				{ color: 'blue', opacity: 0.5, weight: 2 }
			]
		}
	})).addTo(map);

	control.setWaypoints(via);

	L.Routing.errorControl(control).addTo(map);

	var stationIcon = L.icon({
		iconUrl: 'Lib/images/electric-station.png',
		iconSize: [22, 22]
	});

	var markersArray = [];

	for (var i = 0; i < nodeCs.length; i++) {
		markersArray[i] = new L.marker(via[i], { icon: stationIcon }).addTo(map);
		console.log(markersArray[i]);
		//if(i<=nodeCs.length-2) 
		if (i == 0) {
			var tag = '<p>Arrive ' + arrC[i] + ' at ' + arrT[i] + ' with electricity level of ' + arrE[i] + '%. ' + '</p>';
		}
		else {
			tag = '<p>Leave ' + arrC[i] + ' at ' + arrT[i] + ' with electricity level of ' + arrE[i] + '%. ' + '</p>';
		}
		//   var tag = '<p>Leave/Arrival Time: ' + arrT[i] + '</p>' + '<p>City: ' + arrC[i] + '</p>' + '<p>Arrival Energy: ' + arrE[i]  + '</p>';
		var popup = L.popup({
			minWidth: 150
		}).setContent(tag);
		markersArray[i].bindPopup(popup);
	}


}
