# DHT-Elasticsearch-Laravel
A DHT search website use elasticsearch and laravel.

# Requirements
- Elasticsearch 2.3(newest)
- Laravel 5.2(newest)
- Elasticquent(newest)
- Mysql 5.5
- Nodejs 4.4
- Elasticsearch-jdbc(newest)
- p2pspider(newest)

# Setup and run
1. Set APP_URL, APP_KEY, DB_DATABASE, DB_USERNAME, DB_PASSWORD etc. in .env.
2. Set default_index to your elasticsearch index in config/elasticquent.php.
3. Root directory is public/.
4. DHT crawler is in p2pspider/ and you should set user,password,database etc. in p2pspider/mysqldbstart.js.
5. Run `node p2pspider/mysqldbstart.js` to start DHT crawler.
6. Set path,user,password,cluster etc. in p2pspider/elasticsearch-jdbc-2.3.1.0/bin/mysql-torrent-import.sh and run ./mysql-torrent-import.sh for copying torrent information to elasticsearch.

# How it works
1. Use p2pspider to get DHT resource and save torrents to mysql.
2. Copy torrent information to elasticsearch using Elasticsearch-jdbc.
3. Laravel website use Elasticquent to search torrent name and fetch other torrent information form mysql.
