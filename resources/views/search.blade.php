@extends('layouts.app')

@section('query')
value="{{$query}}" @endsection

@section('listGroup')
<ul class="list-group">
<li class="list-group-item">共搜索到{{$totalHits}}个资源 用时{{$took}}毫秒 共{{ceil($totalHits/20)}}页 显示第{{$page}}页</li>
@foreach ($torrents as $torrent)
    <li class="list-group-item">
    	<a href='/detail/{{$torrent["infohash"]}}' target="_blank">{{$torrent["name"]}}</a><br>
        种子大小：<span class="text-danger">{{$torrent["size"]}}</span>&nbsp;&nbsp;&nbsp;
        文件数：<span class="text-primary">{{$torrent["file_num"]}}</span>&nbsp;&nbsp;&nbsp;
        抓取时间：<span class="text-success">{{$torrent["date_time"]}}</span>
    </li>
@endforeach
<li class="list-group-item">
<nav>
  <ul class="pager">
    <li class="previous @if($page==1) disabled @endif"><a href="@if($page>1) /search/{{$query}}/{{$page-1}} @endif"><span aria-hidden="true">&larr;</span> 前一页</a></li>
    <li class="previous @if($page==1) disabled @endif"><a href="/search/{{$query}}/1">回首页</a></li>
    <span class="text-center">第{{$page}}页 共{{ceil($totalHits/20)}}页</span>
    <li class="next @if($page==ceil($totalHits/20)) disabled @endif"><a href="@if($page<ceil($totalHits/20)) /search/{{$query}}/{{$page+1}} @endif">后一页 <span aria-hidden="true">&rarr;</span></a></li>
  </ul>
</nav>
</li>
</ul>
@endsection
