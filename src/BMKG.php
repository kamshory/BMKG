<?php
error_reporting(0);
require('simple_html_dom.php');

class BMKG
{
    function __construct()
    {
        $this->user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0.1) Gecko/20100101 Firefox/52.0.1';
        $this->url        = 'http://www.bmkg.go.id/';
    }
    private function remote_data($get)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $this->url);
        curl_setopt($ch, CURLOPT_URL, $this->url . $get);
        if (!$html = curl_exec($ch))
		{
            return 'offline';
        } 
		else 
		{
            curl_close($ch);
            return utf8_decode($html);
        }
    }
    public function province_list()
	{
		$list = array(
		"01"=>array("Aceh","Aceh"),								
		"02"=>array("Bali","Bali"),								
		"03"=>array("Bangka Belitung","Bangka Belitung"),								
		"04"=>array("Banten","Banten"),								
		"05"=>array("Bengkulu","Bengkulu"),								
		"06"=>array("DI Yogyakarta","DI Yogyakarta"),								
		"07"=>array("DKI Jakarta","DKI Jakarta"),								
		"08"=>array("Gorontalo","Gorontalo"),								
		"09"=>array("Jambi","Jambi"),								
		"10"=>array("Jawa Barat","Jawa Barat"),								
		"11"=>array("Jawa Tengah","Jawa Tengah"),								
		"12"=>array("Jawa Timur","Jawa Timur"),								
		"13"=>array("Kalimantan Barat","Kalimantan Barat"),								
		"14"=>array("Kalimantan Selatan","Kalimantan Selatan"),								
		"15"=>array("Kalimantan Tengah","Kalimantan Tengah"),								
		"16"=>array("Kalimantan Timur","Kalimantan Timur"),								
		"17"=>array("Kalimantan Utara","Kalimantan Utara"),								
		"18"=>array("Kepulauan Riau","Kepulauan Riau"),								
		"19"=>array("Lampung","Lampung"),								
		"20"=>array("Maluku","Maluku"),								
		"21"=>array("Maluku Utara","Maluku Utara"),								
		"22"=>array("Nusa Tenggara Barat","Nusa Tenggara Barat"),								
		"23"=>array("Nusa Tenggara Timur","Nusa Tenggara Timur"),								
		"24"=>array("Papua","Papua"),								
		"25"=>array("Papua Barat","Papua Barat"),								
		"26"=>array("Riau","Riau"),								
		"27"=>array("Sulawesi Barat","Sulawesi Barat"),								
		"28"=>array("Sulawesi Selatan","Sulawesi Selatan"),								
		"29"=>array("Sulawesi Tengah","Sulawesi Tengah"),								
		"30"=>array("Sulawesi Tenggara","Sulawesi Tenggara"),								
		"31"=>array("Sulawesi Utara","Sulawesi Utara"),								
		"32"=>array("Sumatera Barat","Sumatera Barat"),								
		"33"=>array("Sumatera Selatan","Sumatera Selatan"),								
		"34"=>array("Sumatera Utara","Sumatera Utara"),								
		"35"=>array("Indonesia","Indonesia")							  
		);
		$ret = array();
		foreach($list as $key=>$val)
		{
			$ret[$key] = $val[0];
		}
		return $ret;
	}
	public function big_city_list()
	{
		$list = $this->province_list();
		$location = $this->latlon();
		$ret = array();
		foreach($list as $key=>$val)
		{
			$ret[$key] = array();
			$ret[$key]["level"] = 1;
			$ret[$key]["id"] = $key;
			$ret[$key]["name"] = $val;
			$ret[$key]["city"] = array();
			$found = false;
			foreach($location as $k=>$v)
			{
				if($v["id"] == $key)
				{
					$v["level"] = 2;
					$v["name"] = str_replace("_", " ", $k);
					unset($v["id"]);
					$ret[$key]["city"][] = $v;
					$found = true;
				}
			}
			if(!$found)
			{
				unset($ret[$key]);
			}
		}
		return $ret;
	}
    private function latlon()
    {
		$location = array(
            "Banda_Aceh" => array(
				"id"=>"01",
                "lat" => 5.5482904,
                "lon" => 95.3237559
            ),
            "Medan" => array(
				"id"=>"34",
                "lat" => 3.5951956,
                "lon" => 98.6722227
            ),
            "Pekanbaru" => array(
				"id"=>"26",
                "lat" => 0.5070677,
                "lon" => 101.4477793
            ),
            "Batam" => array(
				"id"=>"18",
                "lat" => 1.0456264,
                "lon" => 104.0304535
            ),
            "Padang" => array(
				"id"=>"32",
                "lat" => -0.9470832,
                "lon" => 100.417181
            ),
            "Jambi" => array(
				"id"=>"09",
                "lat" => -1.6101229,
                "lon" => 103.6131203
            ),
            "Palembang" => array(
				"id"=>"33",
                "lat" => -2.9760735,
                "lon" => 104.7754307
            ),
            "Pangkal_Pinang" => array(
				"id"=>"03",
                "lat" => -2.1316266,
                "lon" => 106.1169299
            ),
            "Bengkulu" => array(
				"id"=>"05",
                "lat" => -3.7928451,
                "lon" => 102.2607641
            ),
            "Bandar_Lampung" => array(
				"id"=>"19",
                "lat" => -5.3971396,
                "lon" => 105.2667887
            ),
            "Pontianak" => array(
				"id"=>"13",
                "lat" => -0.0263303,
                "lon" => 109.3425039
            ),
            "Samarinda" => array(
				"id"=>"16",
                "lat" => -0.4948232,
                "lon" => 117.1436154
            ),
            "Palangkaraya" => array(
				"id"=>"15",
                "lat" => -2.2161048,
                "lon" => 113.913977
            ),
            "Banjarmasin" => array(
				"id"=>"14",
                "lat" => -3.3186067,
                "lon" => 114.5943784
            ),
            "Manado" => array(
				"id"=>"31",
                "lat" => 1.4748305,
                "lon" => 124.8420794
            ),
            "Gorontalo" => array(
				"id"=>"08",
                "lat" => 0.5435442,
                "lon" => 123.0567693
            ),
            "Palu" => array(
				"id"=>"29",
                "lat" => -0.9002915,
                "lon" => 119.8779987
            ),
            "Kendari" => array(
				"id"=>"30",
                "lat" => -3.9984597,
                "lon" => 122.5129742
            ),
            "Makassar" => array(
				"id"=>"28",
                "lat" => -5.1476651,
                "lon" => 119.4327314
            ),
            "Majene" => array(
				"id"=>"27",
                "lat" => -3.0297251,
                "lon" => 118.9062794
            ),
            "Ternate" => array(
				"id"=>"21",
                "lat" => 0.7898868,
                "lon" => 127.3753792
            ),
            "Ambon" => array(
				"id"=>"20",
                "lat" => -3.6553932,
                "lon" => 128.1907723
            ),
            "Jayapura" => array(
				"id"=>"24",
                "lat" => -2.5916025,
                "lon" => 140.6689995
            ),
            "Sorong" => array(
				"id"=>"25",
                "lat" => -0.8819986,
                "lon" => 131.2954834
            ),
            "Biak" => array(
				"id"=>"24",
                "lat" => -1.0381022,
                "lon" => 135.9800848
            ),
            "Manokwari" => array(
				"id"=>"25",
                "lat" => -0.8614531,
                "lon" => 134.0620421
            ),
            "Merauke" => array(
				"id"=>"24",
                "lat" => -8.4991117,
                "lon" => 140.4049814
            ),
            "Kupang" => array(
				"id"=>"23",
                "lat" => -10.1771997,
                "lon" => 123.6070329
            ),
            "Sumbawa_Besar" => array(
				"id"=>"22",
                "lat" => -8.504043,
                "lon" => 117.428497
            ),
            "Mataram" => array(
				"id"=>"22",
                "lat" => -8.5769951,
                "lon" => 116.1004894
            ),
            "Denpasar" => array(
				"id"=>"02",
                "lat" => -8.6704582,
                "lon" => 115.2126293
            ),
            "Jakarta" => array(
				"id"=>"07",
                "lat" => -6.2087634,
                "lon" => 106.845599
            ),
            "Jakarta_Pusat" => array(
				"id"=>"07",
                "lat" => -6.2087634,
                "lon" => 106.845599
            ),
            "Serang" => array(
				"id"=>"04",
                "lat" => -6.1103661,
                "lon" => 106.1639749
            ),
            "Bandung" => array(
				"id"=>"10",
                "lat" => -6.9174639,
                "lon" => 107.6191228
            ),
            "Semarang" => array(
				"id"=>"11",
                "lat" => -7.0051453,
                "lon" => 110.4381254
            ),
            "Yogyakarta" => array(
				"id"=>"06",
                "lat" => -7.7955798,
                "lon" => 110.3694896
            ),
            "Surabaya" => array(
				"id"=>"12",
                "lat" => -7.2574719,
                "lon" => 112.7520883
            )
        );
		return $location;
    }
    
    function weather($prov = null, $selected_city = null)
    {
		$url = 'cuaca/prakiraan-cuaca-indonesia.bmkg';
		if($prov !== null && $prov != "")
		{
			$url .= "?Prov=$prov";
		}
        $data = $this->remote_data($url);
        $location = $this->latlon();
        $result = array();
        if($data == "offline")
		{
            $result['status']     = "error";
			$result['message']    = "offline";
			$result['timestamp']  = time();
        } 
		else 
		{
            $result['status']     = "success";
            $result['view']       = "weather";
			$result['timestamp']  = time();
            $html                 = Util::str_get_html($data);
			if(stripos($html, 'TabPaneCuaca1') === false && stripos($html, 'TabPaneCuaca2') === false && stripos($html, 'TabPaneCuaca3') === false)
			{
				$result['status']     = "error";
				$result['message']    = "invalid_data";
				$result['timestamp']  = time();
				return $result;
			}
			$result['data']       = array();
			$buff                 = array();
			$table                = array();
			$idx                  = 0;
			try
			{
				$buff[$idx] = $html->find('div[id="TabPaneCuaca1"]', 0);
				try
				{
					if(isset($buff[$idx]))
					{
						$table[$idx] = $buff[$idx]->find('table', 0);
						$idx++;
					}
				}
				catch(Exception $e2)
				{
				}
			}
			catch(Exception $e)
			{
			}
			try
			{
				$buff[$idx] = $html->find('div[id="TabPaneCuaca2"]', 0);
				try
				{
					if(isset($buff[$idx]))
					{
						$table[$idx] = $buff[$idx]->find('table', 0);
						$idx++;
					}
				}
				catch(Exception $e2)
				{
				}
			}
			catch(Exception $e)
			{
			}
			try
			{
				$buff[$idx] = $html->find('div[id="TabPaneCuaca3"]', 0);
				try{
					if(isset($buff[$idx]))
					{
						$table[$idx] = $buff[$idx]->find('table', 0);
						$idx++;
					}
				}
				catch(Exception $e2)
				{
				}
			}
			catch(Exception $e)
			{
			}
			try
			{
				$date = array(date('Y-m-d'), date('Y-m-d', strtotime('+1 day')), date('Y-m-d', strtotime('+2 day')));
				
				$nweather = array();
				$weather_time = array();
				$ndata = array();
				
				for($day = 0; $day < $idx; $day++)
				{
					$tbl = $table[$day];
					$nweather[$day] = count($tbl->find('tr', 2)->find('td')) - 3;
					if($nweather[$day] < 0)
					{
						$nweather[$day] = count($tbl->find('tr', 2)->find('th'));
					}
					$ndata = count($tbl->find('tr', 2)->find('td'));
					if($ndata == 0)
					{
						$ndata = count($tbl->find('tr', 2)->find('th'));
					}
					
					$weather_time[$day] = array();
					if($ndata != 0)
					{
						foreach($tbl->find('tr', 1)->find('th') as $key=>$val)
						{
							$weather_time[$day][] = str_replace(
								array('pagi', 'siang', 'malam', 'dini_hari'), 
								array('morning', 'daylight', 'night', 'dawn'), 
								strtolower(str_replace(" ", "_", trim($val->innertext))));
							if(@$weather_time[$day][$key] == "")
							{
								$weather_time[$day][$key] = "weather".$key;
							}
						}
						if(isset($weather_time[$day]))
						{
							if(is_array($weather_time[$day]))
							{
								foreach($weather_time[$day] as $k=>$v)
								{
									if(@$weather_time[$day][$k] == "")
									{
										$weather_time[$day][$key] = "weather".$k;
									}
								}
							}
							else
							{
								$weather_time[$day] = array();
								$weather_time[$day][0] = "weather0";
							}
						}
						else
						{
							$weather_time[$day] = array();
							$weather_time[$day][0] = "weather0";
						}
					}
					else
					{
						$nw = -3;
						$xxx = 0;
						foreach($tbl->find('tr', 1)->find('th') as $key=>$val)
						{
							$nw++;
							$xxx++;
						}
						$weather_time[$day] = array();
						
						$cw[0] = "morning";
						$cw[1] = "daylight";
						$cw[2] = "night";
						$cw[3] = "dawn";
						
						
						$nweather[$day] = $nw;
						for($i = 0, $j=count($cw)-$nw; $i<$nw; $i++, $j++)
						{
							$weather_time[$day][$i] = $cw[$j];
						}
	
					}
				}
				$cw = array();
				$cw[0] = "morning";
				$cw[1] = "daylight";
				$cw[2] = "night";
				$cw[3] = "dawn";
				foreach($weather_time as $day=>$val)
				{
					if($val[0] == "kota")
					{
						$weather_time[$day] = array();
						$nw = $nweather[$day];
						$nc = count($cw);
						for($i = 0, $j=$nc-$nw; $i<$nw; $i++, $j++)
						{
							$weather_time[$day][$i] = $cw[$j];
						}
					}
				}
				
				for($day = 0; $day < $idx; $day++)
				{
					$collection = array();
					$collection['date'] = @$date[$day];
					$collection['data'] = array();
					
					foreach ($table[$day]->find('tr') as $i=>$tr) 
					{
						if($i >= 0) 
						{
							$city = trim(strip_tags(@$tr->find('td', 0)->innertext, " \r\n\t "));
							if(strlen($city) > 1)
							{
								$weather = array();
								for($xx = 0; $xx < $nweather[$day]; $xx++)
								{
									$weather[$weather_time[$day][$xx]] = strip_tags(@$tr->find('td', $xx+1)->innertext);
								}
								
								// Find column
								$temperature              = @$tr->find('td', $ndata-1)->innertext;
								$temperature_minmax       = explode("-", @$temperature);
								$humidity        = @$tr->find('td', $ndata)->innertext;
								$humidity_minmax = explode("-", @$humidity);								
								
								$r_coordinates = @$location[str_replace(" ", "_", $city)];
								$r_weather = @$weather;
								$r_temp_min = strip_tags(@$temperature_minmax[0])*1;
								$r_temp_max = strip_tags(@$temperature_minmax[1])*1;
								$r_hum_min = strip_tags(@$humidity_minmax[0])*1;
								$r_hum_max = strip_tags(str_replace(" %", "", @$humidity_minmax[1]))*1;

								// check if humidity is valid
								$inc = 1;
								while(($r_temp_min == 0 && $r_temp_max == 0) || ($r_hum_min == 0 && $r_hum_max == 0))
								{
									$temperature              = @$tr->find('td', $ndata-$inc)->innertext;
									$temperature_minmax       = explode("-", @$temperature);
									$humidity        = @$tr->find('td', ($ndata-$inc)+1)->innertext;
									$humidity_minmax = explode("-", @$humidity);								
									
									$r_coordinates = @$location[str_replace(" ", "_", $city)];
									$r_weather = @$weather;
									$r_temp_min = strip_tags(@$temperature_minmax[0])*1;
									$r_temp_max = strip_tags(@$temperature_minmax[1])*1;
									$r_hum_min = strip_tags(@$humidity_minmax[0])*1;
									$r_hum_max = strip_tags(str_replace(" %", "", @$humidity_minmax[1]))*1;
									$inc++;
								}
								
								
								$cells            = array(
									'city' => $city,
									'coordinate'=> $r_coordinates,
									'weather' => $r_weather,
									'temperature' => array(
										'min' => $r_temp_min,
										'max' => $r_temp_max
									),
									'humidity' => array(
										'min' => $r_hum_min,
										'max' => $r_hum_max
									)
								);
								$collection['data'][] = @$cells;
							}
						}
					}
					$result['data'][] = @$collection;
				}
			}
			catch(Exception $e)
			{
			}
        }
		if($selected_city !== null)
		{
			$filtered = array();
			$i = 0;
			foreach($result['data'] as $i=>$data_at)
			{
				$filtered[$i] = array();
				$filtered[$i]['date'] = $data_at['date'];
				$filtered[$i]['data'] = array();
				foreach($data_at['data'] as $j=>$data)
				{
					if($data['city'] == $selected_city)
					{
						$filtered[$i]['data'][] = $data;
					}
				}
			}
			$result_filtered = array(
				'status' => 'success',
				'view' => 'weather',
    			'timestamp' => time(0),
				'data'=>$filtered
				);
			
	        return $result_filtered;
		}
		else
		{
	        return $result;
		}
    }
    
    function earthquake()
    {
        $data = $this->remote_data('gempabumi/gempabumi-terkini.bmkg');
        $result = array();
        if ($data == "offline")
		{
            $result['status']     = "error";
			$result['message']    = "offline";
			$result['timestamp']  = time();
        } 
		else 
		{
            $result['status']     = "success";
            $result['view']       = "earthquake";
			$result['timestamp']  = time();
            $html                 = Util::str_get_html($data);
			if(stripos($html, '<table class="table table-hover table-striped">') === false)
			{
				$result['status']     = "error";
				$result['message']    = "invalid_data";
				$result['timestamp']  = time();
				return $result;
			}
			$table                = $html->find('table[class="table-hover"]', 0);
            $i = 0;
			try
			{
				$i = 0;
				foreach ($table->find('tr') as $tr)
				{
					if ($i != 0) 
					{
						$datetime	        = $tr->find('td', 1)->innertext;
						$coords              = $tr->find('td', 2)->innertext;
						$latitude_longitude  = explode(" - ", $coords);
						$magnitude           = $tr->find('td', 3)->innertext;
						$depth               = $tr->find('td', 4)->innertext;
						$region              = $tr->find('td', 5)->innertext;
						$cells = array(
							'time' => strip_tags($datetime),
							'coordinate'=>array(
								'lat' => strip_tags($latitude_longitude[0])*1,
								'lon' => strip_tags($latitude_longitude[1])*1),
							'magnitude' => strip_tags($magnitude)*1,
							'depth' => strip_tags($depth),
							'zone' => strip_tags($region)
						);
						$result['data'][] = $cells;
					}
					$i++;
				}
			}
			catch(Exception $e)
			{
			}
        }
        return $result;
    }
    function earthquake_hidden()
    {
        $data = $this->remote_data('gempabumi/gempabumi-dirasakan.bmkg');
        $result = array();
        if ($data == "offline") 
		{
            $result['status']     = "error";
			$result['message']    = "offline";
			$result['timestamp']  = time();
        } 
		else 
		{
            $result['status']     = "success";
            $result['view']       = "earthquake";
			$result['timestamp']  = time();
            $html                 = Util::str_get_html($data);
			if(stripos($html, '<table class="table table-hover table-striped">') === false)
			{
				$result['status']     = "error";
				$result['message']    = "invalid_data";
				$result['timestamp']  = time();
				return $result;
			}
			$table                = $html->find('table[class="table-hover"]', 0);
            $i = 0;
			try
			{
				foreach ($table->find('tr') as $tr)
				{
					if ($i != 0)
					{
						$datetime           = str_replace("/", "-", $tr->find('td', 1)->innertext);
						$datetime           = substr($datetime, 0, 10)." ".substr($datetime, 10);
						$coords             = $tr->find('td', 2)->innertext;
						$coords1            = trim(str_replace("  ", " ", str_replace(array("LS", "LU", "BT", "BB"), "", $coords)));
						$latitude_longitude = explode(" ", $coords1);
						$magnitude 	      = $tr->find('td', 3)->innertext;
						$depth 	          = $tr->find('td', 4)->innertext;
						$region   	         = $tr->find('td', 5)->find('a', 0)->innertext;
						$lat                = strip_tags($latitude_longitude[0])*1;
						$lon                = strip_tags($latitude_longitude[1])*1;
						if(stripos($coords, "LS") !== false) $lat = $lat * -1;
						if(stripos($coords, "BB") !== false) $lon = $lon * -1;
						$cells = array(
							'time' => strip_tags($datetime),
							'coordinate'=>array(
								'lat' => strip_tags($latitude_longitude[0])*1,
								'lon' => strip_tags($latitude_longitude[1])*1),
							'magnitude' => strip_tags($magnitude)*1,
							'depth' => strip_tags($depth),
							'zone' => strip_tags($region)
						);
						$result['data'][] = $cells;
					}
					$i++;
				}
			}
			catch(Exception $e)
			{
			}
        }
        return $result;
    }
}
?>
