<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Helpers\Tools as Tools;

class piCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'piCommand';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
		//
		$this->someCommand();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			# ['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['subnetId', null, InputOption::VALUE_OPTIONAL, 'Value range: 1-254', null],
			['RTUID', null, InputOption::VALUE_OPTIONAL, 'Value range: 1-254', null],
			['AreaNo', null, InputOption::VALUE_OPTIONAL, 'Value range: 1-254', null],
			['SceneNo', null, InputOption::VALUE_OPTIONAL, 'Value range: 1-4', null],
			['ChannelNo', null, InputOption::VALUE_OPTIONAL, 'Value range: 1-4', null],
			['Value', null, InputOption::VALUE_OPTIONAL, 'Value range: 1-4', null],
		];
	}

	public function someCommand(){
		$subnetId = $this->option('subnetId');
		$RTUID = $this->option('RTUID');
		$AreaNo = $this->option('AreaNo');
		$SceneNo = $this->option('SceneNo');
		$ChannelNo = $this->option('ChannelNo');
		$Value = $this->option('Value');
		$result = Tools::piController($subnetId, $RTUID, $AreaNo, $SceneNo, $ChannelNo, $Value);
		if($result['success'] == true){
			$this->info($result['message']);
		}else{
			$this->error($result['message']['common']);
		}
	}
}
