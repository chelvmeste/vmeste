<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SearchMappingCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'search:mapping';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Put elasticsearch mapping.';

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
	public function fire()
	{

        if ($this->option('force'))
        {
            Offer::rebuildMapping();
        }
        else
        {
            Offer::putMapping();
        }


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
            array('force', null, InputOption::VALUE_OPTIONAL, 'Force rebuild mapping.', false),
        );
	}

}
