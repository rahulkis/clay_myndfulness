<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateTrait extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    protected $type = 'Trait';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create trait class command';
/**
 * Get the stub file for the generator.
 *
 * @return string
 */
    protected function getStub()
    {
        return __DIR__ . '/stubs/trait.stub';
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
        return $rootNamespace . '\Traits';
    }

}
