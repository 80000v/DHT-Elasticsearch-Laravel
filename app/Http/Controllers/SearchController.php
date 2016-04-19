<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Torrent;
use App\TorrentDetail;

class SearchController extends Controller
{
    private function formatBytes($size)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2).$units[$i];
    }

    public function index(Request $request)
    {
        return view('index');
    }

    public function search($query, $page)
    {
	if($page<1) return view('index');
        $result = Torrent::searchByQuery(
            array("match" => array("name" => $query)), null, null, 15, ($page-1)*15);
        $torrents = $result->toArray();
        foreach ($torrents as &$torrent) {
            $torrent['size'] = $this->formatBytes($torrent['size']);
            $torrent['date_time'] = date("y年m月d日H:i:s",strtotime($torrent['date_time']));
        }
        return view('search', ['query' => $query, 'torrents' => $torrents,
            'totalHits' => $result->totalHits(), 'took' => $result->took(),
            'page' => $page]);
    }

    public function detail($infohash)
    {
        $torrent = TorrentDetail::where('infohash', $infohash)->take(1)->get()->toArray()[0];
        $torrent['size'] = $this->formatBytes($torrent['size']);
        // $torrent['files'] = json_decode($torrent['files'], false);
        return view('detail', ['torrent' => $torrent]);
    }
}
