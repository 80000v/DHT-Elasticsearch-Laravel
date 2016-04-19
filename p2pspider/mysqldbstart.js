'use strict';

var P2PSpider = require('./lib');
var mysql = require('mysql');
// var heapdump = require('heapdump');

var pool = mysql.createConnection({
  host            : 'localhost',
  user            : 'yourUser',
  password        : 'yourPassword',
  database        : 'yourDatabase'
});

var p2p = P2PSpider({
    nodesMaxSize: 200,
    maxConnections: 400,
    timeout: 5000
});

p2p.ignore(function (infohash, rinfo, callback) {
    var query = pool.query(
        'SELECT infohash FROM torrent WHERE infohash=?',[infohash],
        function(err, results) {
            if(results.length)
                callback(true);
            else
                callback(false);
    });
});

p2p.on('metadata', function (metadata) {
    var name = metadata.info.name ? metadata.info.name.toString() : '';
    var size = metadata.info.length ? metadata.info.length : 0;
    var file_num = metadata.info.files ? 0 : 1;
    var files;
    if("files" in metadata.info){
        files = {};
        var filesLen = metadata.info.files.length;
        var str, path, pathLen, j;
        for (var i = 0; i < filesLen; ++i) {
            path = files;
            pathLen = metadata.info.files[i].path.length;
            for(j = 0; j < pathLen-1; ++j){
                str = metadata.info.files[i].path[j].toString();
                if(!(str in path))
                    path[str] = {};
                path = path[str];
            }
            str = metadata.info.files[i].path[pathLen-1].toString();
            path[str] = metadata.info.files[i].length;
            size += path[str];
            ++file_num;
        }
    }
    var inserts = [metadata.infohash, name, size,
        files?JSON.stringify(files):'', file_num];
    var query = pool.query(
        'INSERT INTO torrent(infohash,name,size,files,file_num) VALUES(?,?,?,?,?)',
        inserts, function(err) {
            if(err)
                console.log(err);
    });
});

process.on('SIGINT', function() {
    pool.end(function (err) {
  		console.log("SIGINT:DB closed!");
        process.exit();
	});
});

p2p.listen(6881, '0.0.0.0');
