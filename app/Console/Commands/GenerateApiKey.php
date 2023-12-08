<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Str;

class GenerateApiKey extends Command
{
    protected $signature = 'generate:api-key';
    protected $description = 'Generate a new API key';

    public function handle()
    {
        $apiKey = ApiKey::create([
            'key' => bin2hex(random_bytes(16)),
            'company_name' => 'some company',
            'project_name' => 'some project',
        ]);

        $this->info('API Key generated: ' . $apiKey->key);
    }
}
