<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande qui permet de créer un service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (!preg_match('/^[A-Z][a-zA-Z0-9]*$/', $name)) {
            $this->error('Le nom du service doit commencer par une majuscule et ne contenir que des lettres et des chiffres.');
            return Command::FAILURE;
        }

        if (strpos($name, 'Service') === false) {
            $name .= 'Service'; // Ajoute "Service" si ce n'est pas déjà présent
        }
        $directory = app_path('Services');

        $filePath = $directory . '/' . $name . '.php';
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($filePath)) {
            $this->error("Le service {$name} existe déjà !");
            return Command::FAILURE;
        }

        $stub = <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            // Crée vos méthodes et propriétés ici
        }

        PHP;

        File::put($filePath, $stub);

        $this->info("Service {$name} créé avec succès dans app/Services !");
        return Command::SUCCESS;
    }
}
