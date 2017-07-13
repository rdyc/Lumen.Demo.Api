<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class ApiControllerMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:api.controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    protected $base_name;

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $name = trim($this->argument('name'));
        $this->base_name = $name;

        return $name . 'Controller';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [
            'DummyClass' => $this->base_name,
            'DummyPath' => strtolower($this->base_name)
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($this->base_name)
        );
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers\Api\V1';
    }
}