<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $data = $response->json();

        $allNews = $data['channel']['item'];

        return view('news', [
            "allNews" => $allNews
        ]);
    }
    public function fetchNews(Request $request)
    {

        $keyword = $request->input('keyword');
        $order = $request->input('order');

        $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $data = $response->json();
        $allNews = $data['channel']['item'];

        if (!empty($keyword)) {
            $allNews = array_filter($allNews, function ($news) use ($keyword) {
                return stripos($news['title'], $keyword) !== false;
            });
        }

        if (!empty($order)) {
            usort($allNews, function ($a, $b) use ($order) {
                $dateA = strtotime($a['pubDate']);
                $dateB = strtotime($b['pubDate']);

                if ($order === 'asc') {
                    return $dateA - $dateB;
                } else {
                    return $dateB - $dateA;
                }
            });
        }
        return view('partials_news_table', [
            "allNews" => $allNews
        ]);
    }
}
