<?php

namespace Modules\Ipoint\Services;

use Modules\Ipoint\Repositories\PointRepository;

class PointService
{

	private $point;


	public function __construct(
		PointRepository $point
	){
		$this->point = $point;
	}

	/**
    * 
    * @param 
    * @return 
    */
	public function create($data){

		//\Log::info('Ipoint: Point Service - Data: '.json_encode($data));
     	try {

     		$point = $this->point->create($data);

			return $point;

     	} catch (\Exception $e) {

     		\Log::info('Ipoint: Point Service - Create - ERROR: '.$e->getMessage().' Code:'.$e->getErrorCode());
        	\Log::error("error: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine() . $e->getTraceAsString());


      	}

	}


}