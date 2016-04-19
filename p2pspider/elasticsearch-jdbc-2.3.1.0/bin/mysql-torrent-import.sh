bin=/yourPath/elasticsearch-jdbc-2.3.1.0/bin
lib=/yourPath/elasticsearch-jdbc-2.3.1.0/lib

echo '
{
    "type" : "jdbc",
    "jdbc" : {
        "url" : "jdbc:mysql://localhost:3306/dht_db",
        "user" : "yourUser",
        "password" : "yourPassword",
        "sql" :  "select infohash,name,size,file_num,date_time, infohash as _id from torrent",
        "index" : "dht",
        "type" : "torrents",
        "detect_json" : "false",
        "elasticsearch" : {
            "cluster" : "yourcluster",
            "host" : "localhost",
            "port" : 9300
		}
	}
}
' | java \
    -cp "${lib}/*" \
    -Dlog4j.configurationFile=${bin}/log4j2.xml \
    org.xbib.tools.Runner \
    org.xbib.tools.JDBCImporter
