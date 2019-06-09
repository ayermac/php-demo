<?php
/**
 * 
 */
class Api
{
	
	public function __construct()
	{
	}

	public static function result()
	{
		$data = array(
			'code' => 200,
			'msg' => '成功',
			'data' => [
				'server_time' => time()
			]
		);

		echo json_encode($data);
		exit();
	}
}

Api::result();