<?php

namespace App\Services;

use App\Models\Database;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class DatabaseProvisionService
{
    /**
     * Provision a new Postgres instance (container-based) and persist metadata.
     *
     * Expected $data keys:
     * - project_id (int, required)
     * - name (string, optional)
     * - username/password (optional)
     * - host/port (optional)
     * - image/container_name/volume (optional overrides)
     */
    public function createInstance(array $data): Database
    {
        $projectId = $data['project_id'] ?? null;
        if (! $projectId) {
            throw new RuntimeException('project_id is required');
        }

        $name = $data['name'] ?? 'main';
        $username = $data['username'] ?? sprintf('pg_%s_%s', $projectId, $name);
        $password = $data['password'] ?? Str::random(32);
        // Build a DNS-friendly hostname that you can point via wildcard DNS.
        // Ex: *.db.example.com -> container host `main-1.db.example.com`.
        $host = $data['host'] ?? $this->buildHost(projectId: $projectId, name: $name);
        $port = $data['port'] ?? $this->findAvailablePort();

        $image = $data['image'] ?? 'postgres:16';
        $containerName = $data['container_name'] ?? sprintf('db_%s_%s', $projectId, $name);
        $volume = $data['volume'] ?? sprintf('pgdata_%s_%s', $projectId, $name);

        $this->runDockerContainer(
            image: $image,
            containerName: $containerName,
            volumeName: $volume,
            username: $username,
            password: $password,
            port: $port
        );

        return Database::create([
            'project_id' => $projectId,
            'name' => $name,
            'username' => $username,
            'password_encrypted' => Crypt::encryptString($password),
            'host' => $host,
            'port' => $port,
        ]);
    }

    /**
     * Compose a public hostname for the tenant DB.
     * Configure a wildcard DNS (*.db.example.com) pointing to your gateway/load balancer.
     */
    private function buildHost(int $projectId, string $name): string
    {
        $baseDomain = env('DBAAS_DOMAIN', 'db.local');
        $slug = Str::slug($name . '-' . $projectId);
        return sprintf('%s.%s', $slug, $baseDomain);
    }

    /**
     * Start a Postgres container. Throws if the command fails.
     */
    private function runDockerContainer(
        string $image,
        string $containerName,
        string $volumeName,
        string $username,
        string $password,
        int $port
    ): void {
        $process = new Process([
            'docker',
            'run',
            '-d',
            '--restart=unless-stopped',
            '--name', $containerName,
            '-e', 'POSTGRES_USER=' . $username,
            '-e', 'POSTGRES_PASSWORD=' . $password,
            '-p', sprintf('%d:5432', $port),
            '-v', sprintf('%s:/var/lib/postgresql/data', $volumeName),
            $image,
        ]);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException('Failed to start Postgres container: ' . $process->getErrorOutput());
        }
    }

    /**
     * Find an available TCP port for a new instance.
     */
    private function findAvailablePort(int $start = 5433, int $end = 5599): int
    {
        for ($port = $start; $port <= $end; $port++) {
            $connection = @fsockopen('127.0.0.1', $port);
            if ($connection === false) {
                return $port;
            }
            fclose($connection);
        }

        throw new RuntimeException('No available port found for database provisioning.');
    }
}
