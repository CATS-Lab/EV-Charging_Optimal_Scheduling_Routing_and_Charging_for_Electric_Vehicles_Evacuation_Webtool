 async function get_info() {
	//const { response } = require('express');
	const mysql_hq = require('mysql2');
	const con_hq = mysql_hq.createConnection({
		host: process.env.DB_HOST || "localhost",
		user: process.env.DB_USER || "root",
		password: process.env.DB_PASSWORD || '',
		database: process.env.DB_NAME || "EVpro"
	});

	con_hq.connect(function (err) {
		if (err) throw err;
		console.log("Connected!")
	});
	var sql = "SELECT * FROM use_result";
	const results = await con_hq.promise().query(sql);
	let node = results[0];
	const node_cs = [];
	for (let i = 0; i < node.length; i++) {
		node_cs[i] = [node[i].arrival_node_lat, node[i].arrival_node_lon];
	};
	//console.log(node_cs);
	return node_cs;
};


