<?php

namespace App\Jobs;

use App\Models\ComputerInstance;
use App\Models\ComputerPlan;
use App\Models\Database;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;
use K8s\Client\KubernetesClient;
use K8s\Http\Symfony\Transport;
use RuntimeException;
use Symfony\Component\Process\Process;

class ProvisionPostgresInstance implements ShouldQueue
{
    use Queueable;

    private $computerPlan;
    private $project_data;
    private $bd_data;

    /**
     * Create a new job instance.
     * @param ComputerPlan $computerPlan permet de savoir quel plan appliquer a l'instance
     */
    public function __construct(ComputerPlan $computerPlan, $project_data)
    {
        $this->computerPlan = $computerPlan;
        $this->project_data = $project_data;

        $this->bd_data = [
            "name" => "main",
            "username" => "postgres",
            "password" => $project_data->password,
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $instanceSlug = substr(Str::slug($this->project_data->name) . '-' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 20), 0, 53);
        $instanceSlug = Str::lower($instanceSlug);
        $instanceSlug = strtolower($instanceSlug);
        $process = Process::fromShellCommandline(sprintf(
            'KUBECONFIG=/etc/kubernetes/k3s.yaml helm install pg-%1$s bitnami/postgresql --namespace %1$s --create-namespace ' .
                '--set auth.username=%2$s,auth.password=%3$s,auth.database=%4$s ' .
                '--set primary.persistence.size=%5$s ' .
                '--set resources.requests.memory=%6$s,resources.requests.cpu=%7$s ' .
                '--set resources.limits.memory=%6$s,resources.limits.cpu=%7$s ' .
                '--set metrics.enabled=true,metrics.service.port=9187,metrics.service.type=ClusterIP',
            $instanceSlug,
            $this->bd_data['username'],
            $this->bd_data['password'],
            $this->bd_data['name'],
            $this->computerPlan->storage_mb . 'Mi',
            $this->computerPlan->memory_mb . 'Mi',
            $this->computerPlan->cpu_cores
        ));

        $process->run();

        if (!$process->isSuccessful()) {
            throw new RuntimeException(
                message: "Helm command failed:\n" .
                    "Output:\n" . $process->getOutput() . "\n" .
                    "Error Output:\n" . $process->getErrorOutput()
            );
        }

        $compute_instance = ComputerInstance::create([
            "project_id" => $this->project_data->id,
            "computer_plan_id" => $this->computerPlan->id,
            "cpu" => $this->computerPlan->cpu,
            "memory_mb" => $this->computerPlan->memory_mb,
            "storage_mb" => $this->computerPlan->storage_mb,
            "role" => "main",
            "host" => "bd." . $this->project_data->slug . ".dbaas.com",
            'status' => 'active',
            "port" => "5432",
            "db_user" => $this->bd_data['username'],
            'db_password' => bcrypt($this->bd_data['password']),
            'slug' => $instanceSlug,
        ]);

        $createDbCommand = sprintf(
            'PGPASSWORD=%s psql -h %s -U %s -c "CREATE DATABASE %s;"',
            $this->bd_data['password'],
            'db.' . $this->project_data->slug . '.dbaas.com',
            $this->bd_data['username'],
            $this->bd_data['name']
        );

        $processDb = Process::fromShellCommandline($createDbCommand);
        $processDb->run();

        if (!$processDb->isSuccessful()) {
            throw new RuntimeException("Database creation failed: " . $processDb->getErrorOutput());
        }

        Database::create([
            'compute_instance_id' => $compute_instance->id,
            'project_id' => $this->project_data->id,
            'name' => $this->bd_data['name'],
            'username' => $this->bd_data['username'],
            'password' => bcrypt($this->bd_data['password']),
            'role' => 'production',
            'host' => 'db.' . $this->project_data->slug . '.dbaas.com',
            'port' => '5432'
        ]);
    }
}
