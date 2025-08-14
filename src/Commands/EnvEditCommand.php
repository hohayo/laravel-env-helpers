<?php

namespace YourVendor\EnvHelpers\Commands;

use Illuminate\Console\Command;
use STS\EnvSecurity\EnvSecurityService;

class EnvEditCommand extends Command
{
    protected $signature = 'env:edit {--env= : Environment name (e.g. production, staging)}';
    protected $description = 'Edit encrypted .env file like Rails credentials:edit';

    public function handle()
    {
        $env = $this->option('env') ?? null;
        $service = app(EnvSecurityService::class);

        $encryptedFile = $service->encryptedFilePath($env);
        $tempFile = base_path('.env.temp'.($env ? ".$env" : ''));

        if (file_exists($encryptedFile)) {
            $this->info("Decrypting $encryptedFile...");
            $service->decrypt($env, $tempFile);
        } else {
            $sourceEnv = base_path($env ? ".env.$env" : ".env");
            if (file_exists($sourceEnv)) {
                copy($sourceEnv, $tempFile);
            } else {
                file_put_contents($tempFile, "");
            }
        }

        $editor = env('EDITOR', 'vim');
        system("$editor $tempFile");

        $this->info("Encrypting updated file...");
        $service->encrypt($env, $tempFile);

        unlink($tempFile);
        $this->info('Done! Encrypted env updated.');
    }
}
