<?php
namespace App\Console\Commands;

use App\Traveler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDataCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import csv into database';

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
	    Traveler::truncate();

	    $filename='app/Data/data.csv';
	    $charset = $this->_detectFileEncoding($filename);
	    $file = fopen($filename, "r");
	    while ($getData = fgetcsv($file, 100000, ";"))
	    {
		    if($getData[0] !== "name")
		    {
			    if ($charset == 'iso-8859-1'){
				    foreach ($getData as $index=>$item){
					    $getData[$index] = iconv('Windows-1251', 'UTF-8', $item);
				    }
			    }
			    $traveler = new Traveler();
			    $traveler->name = $getData[0];
			    $traveler->checkin_date =  $getData[1];
			    $traveler->ip =  $getData[2];
			    $traveler->checkin_country =  geoip()->getLocation($getData[2])['country'];
			    $traveler->rating =  $getData[3];
			    $traveler->favorite_country =  $getData[4];
			    if($getData[5] == "Да")
			        $traveler->is_active =  true;
			    else
				    $traveler->is_active =  false;
			    $traveler->save();

			    $this->info('Запись пользователя ' . $getData[0] . ' добавлена в базу данных.');
		    }
	    }
	    fclose($file);

	    $this->info('data.csv файл импортирован успешно!');
    }

	/**
	 * Detect file encoding by path to file
	 *
	 * @param string $filepath
	 * @return boolean
	 * */
	private function _detectFileEncoding($filepath) {
		$output = array();
		exec('file -i ' . $filepath, $output);
		if (isset($output[0])){
			$ex = explode('charset=', $output[0]);
			return isset($ex[1]) ? $ex[1] : null;
		}
		return null;
	}
}
?>