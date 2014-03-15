<?php

class Hooks_webhooks extends Hooks
{

    public function webhooks__go()
    {
        if (array_get($this->config, 'clear_cache', true)) {
            $this->clearCache();
        }
        // clear OpCache PHP cache storage installed as part of PHP5.5.*
        if (function_exists('opcache_reset')) {
            $this->clearOpCache();
        }

    }

    private function clearCache()
    {
        $cache_folder = BASE_PATH . '/_cache/_app/';
        Folder::delete($cache_folder, true);
        $this->log->info('The cache has been cleared.');
    }

    private function clearOpCache()
    {
        opcache_reset();
        $this->log->info('OpCache has been cleared.');
    }

}
