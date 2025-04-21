<?php

namespace App\Services;

use App\Models\Instance;

class DiscoveryService
{
    public static function fetch()
    {
        $seeds = config('fedidb.discovery.seeds');

        if(empty($seeds)) {
            throw new Exception('Missing discovery seeds. Please add to config/fedidb.php');
        }

        $seedServers = collect(explode(',', $seeds));

        foreach ($seedServers as $seedServer) {
            try {
                $nodes = HttpService::get($seedServer);
            } catch (\Exception $e) {
                return $e;
            }

            if(!$nodes || !count($nodes)) {
                throw new \Exception('empty results');
            }

            foreach($nodes as $node) {
                if(filter_var($node, FILTER_VALIDATE_IP)) {
                    continue;
                }
                if(str_contains($node, ':')) {
                    continue;
                }
                $url = str_starts_with($node, 'https://') ? parse_url($node, PHP_URL_HOST) : $node;
                $url = str_ends_with($url, '/') ? substr($url, 0, -1) : $url;
                $node = str_ends_with($node, '/') ? substr($node, 0, -1) : $node;
                $instance = Instance::firstOrCreate([
                    'domain' => $node,
                ]);
            }
        }
    }
}
