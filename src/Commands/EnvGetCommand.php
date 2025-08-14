<?php

namespace YourVendor\EnvHelpers\Commands;

use Illuminate\Console\Command;
use STS\EnvSecurity\EnvSecurityService;

class EnvGetCommand extends Command
{
    protected $signature = 'env:get {key : The env key to get} {--env= : Environment name (e.g. production, staging)}';
    protected $description = 'Get a value from an encrypted .env file without manually decrypting it';

    public function handle()
    {
        $key = $this->argument('key');
        $env = $this->option('env') ?? null;
        $service = app(EnvSecurityService::class);

        $tempFile = base_path('.env.temp'.($env ? ".$env" : ''));
        $service->decrypt($env, $tempFile);

        $lines = file($tempFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        unlink($tempFile);

        foreach ($lines as $line) {
            if (str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$k, $v] = explode('=', $line, 2);
            if (trim($k) === $key) {
                $this->line($v);
                return Command::SUCCESS;
            }
        }

        $this->error("Key [$key] not found in encrypted env.");
        return Command::FAILURE;
    }
}
