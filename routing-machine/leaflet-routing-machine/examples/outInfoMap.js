
async function out_infoMap() {
 
  //const via1=[];
  const node_cs1 = await get_info();
  //const start = node_cs1[0];
  //const end = node_cs1[node_cs1.length - 1];
  //via1.push(start);

  /* let pointArray = [];
  pointArray.push(L.latLng(node_cs1[0]));

  for (var i = 0; i < node_cs1.length; i++) {
    pointArray.push(L.latLng(node_cs1[i]));
  }; */
  console.log(node_cs1);
};
out_infoMap();
