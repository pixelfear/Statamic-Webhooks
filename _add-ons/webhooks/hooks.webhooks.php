<?php

class Hooks_webhooks extends Hooks 
{

	public function webhooks__go()
	{
		if (array_get($this->config, 'clear_cache', true)) {
			$this->clearCache();
		}
	}

	private function clearCache()
	{
		$cache_folder = BASE_PATH . '/_cache/_app/';
		Folder::delete($cache_folder, true);
		$this->log->info('The cache has been cleared.');
	}
	
}