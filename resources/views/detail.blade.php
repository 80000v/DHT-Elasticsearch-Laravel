@extends('layouts.app')

@section('listGroup')
<ul class="list-group">
<li class="list-group-item bg-info">
种子名：<span class="text-danger">{{$torrent["name"]}}</span>
</li>
<li class="list-group-item">
    种子大小：<span class="text-danger">{{$torrent["size"]}}</span>&nbsp;&nbsp;&nbsp;
    文件数：<span class="text-primary">{{$torrent["file_num"]}}</span>&nbsp;&nbsp;&nbsp;
    抓取时间：<span class="text-success">{{$torrent["date_time"]}}</span>
</li>
<li class="list-group-item bg-info">
	磁力链接：<a href='magnet:?xt=urn:btih:{{$torrent["infohash"]}}'>magnet:?xt=urn:btih:{{$torrent["infohash"]}}</a>
</li>
<li class="list-group-item">
文件列表：
<div id="dirTree"></div>
</li>
@endsection

@section('script')
<script type="text/javascript">
function bytesToSize(bytes) {
    if (bytes === 0) return '0 B';
    var k = 1024,
        sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
   return (bytes / Math.pow(k, i)).toPrecision(4) + ' ' + sizes[i];
}
var convert = function (o) {
  var r = []
  var i = null
  var tmp = {}
  for (i in o) {
    if (o.hasOwnProperty(i)) {
      if (typeof o[i] === 'object') {
        tmp = { label: i, children: convert(o[i]) }
        r.push(tmp)
      } else {
        r.push( {label: i + " - " + bytesToSize(o[i])} )
      }
    }
  }
  return r
}
data = convert({!! $torrent['files'] !!});
$('#dirTree').tree({
    data: data,
    buttonLeft: true,
    autoEscape: false,
    autoOpen: true
});
</script>
@endsection
