<?php

namespace Strimoid\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Strimoid\Models\Content;

class TwitterPost extends Command
{
    protected $name = 'lara:twitterpost';
    protected $description = 'Posts most popular content to Twitter.';
    public function __construct(private \Illuminate\Contracts\Config\Repository $configRepository)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $dayBefore = Carbon::now()->subDay();
        $content = Content::where('created_at', '>', $dayBefore)
            ->orderBy('uv', 'desc')
            ->firstOrFail();

        $client = new Client([
            'base_url' => 'https://api.twitter.com/1.1/',
            'defaults' => ['auth' => 'oauth'],
        ]);

        $oauth = new Oauth1([
            'consumer_key' => $this->configRepository->get('social.twitter.consumer_key'),
            'consumer_secret' => $this->configRepository->get('social.twitter.consumer_secret'),
            'token' => $this->configRepository->get('social.twitter.token'),
            'token_secret' => $this->configRepository->get('social.twitter.token_secret'),
        ]);

        $client->getEmitter()->attach($oauth);

        $params = [
            'status' => Str::limit($content->title, 100) . ' https://strm.pl/c/' . $content->hashId(),
        ];

        $client->post('statuses/update.json', [
            'body' => $params,
        ]);
    }
}
