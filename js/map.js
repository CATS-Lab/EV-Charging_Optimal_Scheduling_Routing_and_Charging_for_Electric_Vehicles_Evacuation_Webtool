//This document prepares EV stations of Florida for the webpage

async function getData() {
  //async fectch EV stations in Florida   
  const response = await fetch('./data/stationsF.csv');

  const data = await response.text();   //async response of the reponse at the format of .text 
  console.log(data);
  const name = [];  // Creating array variable for EV station name
  const street = []; // Creating street array of EV station address  
  const city = [];    //Creating city array of EV station address 
  const state = []; // Creating state array of EV station address 
  const zip = [];  // Creating zip array of EV station address 
  const latitude = []; //Creating latitude array of EV station
  const longitude = []; //Creating longitude array of EV station
  // const cooridination = [];
  const rows = data.split('\n').slice(1);//Split a string into substrings using the specified separator and return them as an array.
  // assigns defined arrays with values in variable rows
  rows.forEach(row => {
    const cols = row.split(','); //Split a string into substrings using the specified separator and return them as an array.
    //assigns the row values to array variables
    name.push(cols[1]);
    street.push(cols[2]);
    city.push(cols[4]);
    state.push(cols[5]);
    zip.push(cols[6]);
    latitude.push(cols[22]);
    longitude.push(cols[23]);
  });


  const stations = [];  //define stations array;


  //Assigning stations array;
  for (let i = 0; i < name.length; i++) {
    //assigns the row values to station array variables
    stations[i] = [name[i], street[i], city[i], state[i], zip[i], latitude[i], longitude[i]];
  };

  return (stations);

}
//For map//
// Making a map and tiles
loadlocation();
async function loadlocation() {
  const stations = await getData(); //recall getData function
  //console.log(stations);
  const name = [];
  const street = [];
  const city = [];
  const state = [];
  const zip = [];
  const latitude = [];
  const longitude = [];
  const coordination = [];
  for (let i = 0; i < stations.length; i++) {
    // assigns station array variables to array variables
    name[i] = stations[i][0];
    street[i] = stations[i][1];
    city[i] = stations[i][2];
    state[i] = stations[i][3];
    zip[i] = stations[i][4];
    latitude[i] = stations[i][5];
    longitude[i] = stations[i][6];
    coordination[i] = [latitude[i], longitude[i]];
  };
  console.log(coordination);
  //define map
  const map = L.map('map', {
    center: [27.995139, -82.506186],
    zoom: 7
  });
  //const map = L.map('map');
  const attributionD =
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
  const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
  const tiles = L.tileLayer(tileUrl, { attribution: attributionD });
  tiles.addTo(map);

  //Station Icon//
  var stationIcon = L.icon({
    iconUrl: 'Lib/images/electric-station.png',
    iconSize: [22, 22]
  });

  //For station description when you click//
  var markersArray = [];
  //console.log(coordination);
  for (var i = 0; i < coordination.length; i++) {
    //define for markers Array;
    markersArray[i] = new L.marker(coordination[i], { icon: stationIcon }).addTo(map);
    //define for tags Array;
    var tag = '<p>Name: ' + name[i] + '</p>' + '<p>Street: ' + street[i] + '</p>' + '<p>City: ' + city[i] + '<p>State: ' + state[i] + '</p>' + '<p>Coordination: ' + coordination[i] + '</p>';
    //console.log(tag);
    //define popup features;
    var popup = L.popup({
      minWidth: 100
    }).setContent(tag);
    markersArray[i].bindPopup(popup);
  }
}
