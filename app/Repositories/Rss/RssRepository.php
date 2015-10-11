<?php

namespace App\Repositories\Rss;

use App\Models\News;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssRepository extends BaseRepository implements RssRepositoryInterface
{

    public function __construct()
    {
        $this->model = new News();
    }

    public function buildRssFeed()
    {
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $channel
            ->title(env('SITE_NAME'))
            ->description("Le club Université Nantes Aviron est LE club d'aviron des étudiants nantais,
            mais demeure ouvert à tous les publics et tous les types de pratiques.")
            ->url(url())
            ->language('fr')
            ->copyright('Copyright (c) ' . env('SITE_NAME'))
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $news_list = $this->model->Where('created_at', '<=', $now)
            ->orderBy('released_at', 'desc')
            ->take(20)
            ->get();

        foreach ($news_list as $news) {
            $item = new Item();
            $item->title($news->title)
                ->description(str_limit(strip_tags($news->content), 250))
                ->url(route('front.news.show', $news->key))
                ->pubDate(Carbon::createFromFormat('Y-m-d H:i:s', $news->released_at)->timestamp)
                ->guid(route('front.news.show', $news->key), true)
                ->appendTo($channel);
        }

        $feed = (string)$feed;

        // Replace a couple items to make the feed more compliant
        $feed = str_replace(
            '<rss version="2.0">',
            '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
            $feed
        );
        $feed = str_replace(
            '<channel>',
            '<channel>' . "\n" . '    <atom:link href="' . url('/rss') .
            '" rel="self" type="application/rss+xml" />',
            $feed
        );

        return $feed;
    }

}