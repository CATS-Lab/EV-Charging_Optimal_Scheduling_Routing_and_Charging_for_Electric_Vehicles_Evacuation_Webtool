//function routenode(){
const arrival_node_latR1 = [];
const arrival_node_lonR1 = [];
var mysql_hq = require('mysql');
var con_hq = mysql_hq.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "EVpro"
});

//const arrival_node_latR="SELECT arrival_node_lat FROM use_result"
//const arrival_node_lonR="SELECT arrival_node_lon FROM use_result"
con_hq.connect(function (err) {
  if (err) throw err;
  //Select only "name" and "address" from "customers":
  //var sql = "SELECT arrival_node_lat FROM use_result";
  var sql = "SELECT * FROM use_result";

  con_hq.query(sql, function (err, result, fields) {
    if (err) throw err;
    let node_length = result.length;
    let end_index = node_length - 1;


    var arrival_node_latR = [];
    var arrival_node_lonR = [];
    //var Start=[result[0].arrival_node_lat,result[0].arrival_node_lon];
    //var End=[result[end_index].arrival_node_lat,result[end_index].arrival_node_lon];
    for (let i = 0; i < result.length; i++) {
      //console.log(result[i].arrival_node_lat);
      arrival_node_latR[i] = result[i].arrival_node_lat;
      arrival_node_lonR[i] = result[i].arrival_node_lon;
    };
    arrival_node_latR1.push = arrival_node_latR;
    arrival_node_lonR1.push = arrival_node_lonR;   
    console.log(arrival_node_latR1);
    return arrival_node_latR1;
  });

});

//console.log(con_hq.connect());

console.log('123');

//console.log('as'+arrival_node_latR11);
//var arri_node_latR1_1=con_hq.[con_hq.query].arrival_node_latR1;
//console.log(arri_node_latR1_1);
//var arrival_node_latR1=con_hq.connect.arrival_node_latR;
//console.log(con_hq.query.arrival_node_latR1);

//var start1=con_hq.Start;
