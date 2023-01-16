
async function get_data() {
	const response = await fetch('userResult1.csv');
	const data = await response.text();
	const arrivT = [];
	const city = [];
	const arrivE = [];
	const lat = [];
	const lon = [];
	const rows = data.split('\n');
	rows.forEach(row => {
		const cols = row.split(',');
		arrivT.push(cols[1]);		
		city.push(cols[3]);

		arrivE.push(cols[4]);
		lat.push(cols[5]);
		lon.push(cols[6]);
	});

	const node = [];
	/* for (let i = 0; i < lon.length-1; i++) {
		node[i] = [lat[i], lon[i], arrivT[i], city[i], arrivE[i]];
		console.log(node[i]);
	}; */
	const end = lon.length - 2;
	console.log(end);
	for (let i = 0; i <= end; i++) {
		//console.log(nodeCs.length);
		index = end - i;

		//cityR[i]= city[i].replace(/\\/g, '');
		node[index] = [lat[i], lon[i], arrivT[i], city[i], arrivE[i]];
		console.log(node[index])
	};

	console.log(node);
	return (node);
}


loadMap();

async function loadMap() {
	const nodeCs = await get_data();
	//console.log(nodeCs[1][0],',',nodeCs[1][1]);
	const via = [];
	const arrT = [];
	const arrC = [];
	const arrE = [];
	for (let i = 0; i < nodeCs.length; i++) {
		via[i] = [nodeCs[i][0], nodeCs[i][1]];
		arrT[i] = nodeCs[i][2];
		arrC[i] = nodeCs[i][3];
		arrE[i] = nodeCs[i][4];
		//console.log(via[i]);
		//console.log(via[i]);
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

	var markersArrayP = [];
	//markersArrayP[4] = new L.marker(via[4], { icon: stationIcon }).addTo(map);
	//markersArrayP[9] = new L.marker(via[9], { icon: stationIcon }).addTo(map);
	for (var i = 0; i < nodeCs.length; i++) {
		if (arrC[i] == '\"Charging station\"') {
			markersArrayP[i] = new L.marker(via[i], { icon: stationIcon }).addTo(map);
		}
		//console.log(markersArray[i]);
		//if(i<=nodeCs.length-2) 

		//markersArray[0] = new L.marker(via[0], { icon: stationIcon }).addTo(map);

	}


	var markersArray = [];

	for (var i = 0; i < nodeCs.length; i++) {
		/* if (arrC[i] == 'charging station') {
			markersArray[i] = new L.marker(via[i], { icon: stationIcon }).addTo(map);
		} */
		//console.log(markersArray[i]);
		//if(i<=nodeCs.length-2) 

		//markersArray[0] = new L.marker(via[0], { icon: stationIcon }).addTo(map);
		markersArray[i] = new L.marker(via[i]).addTo(map);
		if (i == nodeCs.length - 1) {
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
