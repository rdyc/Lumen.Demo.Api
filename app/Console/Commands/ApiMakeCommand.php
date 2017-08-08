<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create api scaffolding';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $_name = $this->ask('What is api name?');

        if (preg_match('([^A-Za-z_/\\\\])', $_name)) {
            $this->error('Api name contains invalid characters.');
        }else{
            $name = ucwords($_name);

            $this->generate($name);
        }
    }

    private function generate($name){
        $this->comment('Generating common class for ' . $name .' api...');
        $this->line('');

        $this->call('make:api.controller', ['name' => $name]);
        $this->call('make:api.transformer', ['name' => $name]);
        $this->call('make:api.request.post', ['name' => $name]);
        $this->call('make:api.request.patch', ['name' => $name]);
        $this->call('make:api.response', ['name' => $name]);
        $this->call('make:api.response.item', ['name' => $name]);
        $this->call('make:api.response.collection', ['name' => $name]);
        $this->call('make:repo.model', ['name' => $name]);
        $this->call('make:repo.contract', ['name' => $name]);
        $this->call('make:repo', ['name' => $name]);
        $this->call('make:api.test', ['name' => $name]);

        $this->line('');
        $this->comment('Completed! Have a nice coding.');
        $this->line('Please remind, don\'t forget to:');
        $this->line('1. Bind I' . $name . 'Repository and ' . $name . 'Repository in "~/app/Providers/AppServiceProvider.php" method name -> "register_repositories".');
        $this->line('2. Assign router for '. $name .'Controller in "~/routes/web.php".');

        $this->line('');
        $this->comment('Thanks');
        $this->line('ruddycahyadi@gmail.com');
    }

}