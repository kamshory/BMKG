<?php
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
    
    private function latlon()
    {
		$lokasi = array(
            "Banda_Aceh" => array(
                "lat" => 5.5482904,
                "lon" => 95.3237559
            ),
            "Medan" => array(
                "lat" => 3.5951956,
                "lon" => 98.6722227
            ),
            "Pekanbaru" => array(
                "lat" => 0.5070677,
                "lon" => 101.4477793
            ),
            "Batam" => array(
                "lat" => 1.0456264,
                "lon" => 104.0304535
            ),
            "Padang" => array(
                "lat" => -0.9470832,
                "lon" => 100.417181
            ),
            "Jambi" => array(
                "lat" => -1.6101229,
                "lon" => 103.6131203
            ),
            "Palembang" => array(
                "lat" => -2.9760735,
                "lon" => 104.7754307
            ),
            "Pangkal_Pinang" => array(
                "lat" => -2.1316266,
                "lon" => 106.1169299
            ),
            "Bengkulu" => array(
                "lat" => -3.7928451,
                "lon" => 102.2607641
            ),
            "Bandar_Lampung" => array(
                "lat" => -5.3971396,
                "lon" => 105.2667887
            ),
            "Pontianak" => array(
                "lat" => -0.0263303,
                "lon" => 109.3425039
            ),
            "Samarinda" => array(
                "lat" => -0.4948232,
                "lon" => 117.1436154
            ),
            "Palangkaraya" => array(
                "lat" => -2.2161048,
                "lon" => 113.913977
            ),
            "Banjarmasin" => array(
                "lat" => -3.3186067,
                "lon" => 114.5943784
            ),
            "Manado" => array(
                "lat" => 1.4748305,
                "lon" => 124.8420794
            ),
            "Gorontalo" => array(
                "lat" => 0.5435442,
                "lon" => 123.0567693
            ),
            "Palu" => array(
                "lat" => -0.9002915,
                "lon" => 119.8779987
            ),
            "Kendari" => array(
                "lat" => -3.9984597,
                "lon" => 122.5129742
            ),
            "Makassar" => array(
                "lat" => -5.1476651,
                "lon" => 119.4327314
            ),
            "Majene" => array(
                "lat" => -3.0297251,
                "lon" => 118.9062794
            ),
            "Ternate" => array(
                "lat" => 0.7898868,
                "lon" => 127.3753792
            ),
            "Ambon" => array(
                "lat" => -3.6553932,
                "lon" => 128.1907723
            ),
            "Jayapura" => array(
                "lat" => -2.5916025,
                "lon" => 140.6689995
            ),
            "Sorong" => array(
                "lat" => -0.8819986,
                "lon" => 131.2954834
            ),
            "Biak" => array(
                "lat" => -1.0381022,
                "lon" => 135.9800848
            ),
            "Manokwari" => array(
                "lat" => -0.8614531,
                "lon" => 134.0620421
            ),
            "Merauke" => array(
                "lat" => -8.4991117,
                "lon" => 140.4049814
            ),
            "Kupang" => array(
                "lat" => -10.1771997,
                "lon" => 123.6070329
            ),
            "Sumbawa_Besar" => array(
                "lat" => -8.504043,
                "lon" => 117.428497
            ),
            "Mataram" => array(
                "lat" => -8.5769951,
                "lon" => 116.1004894
            ),
            "Denpasar" => array(
                "lat" => -8.6704582,
                "lon" => 115.2126293
            ),
            "Jakarta" => array(
                "lat" => -6.2087634,
                "lon" => 106.845599
            ),
            "Jakarta_Pusat" => array(
                "lat" => -6.2087634,
                "lon" => 106.845599
            ),
            "Serang" => array(
                "lat" => -6.1103661,
                "lon" => 106.1639749
            ),
            "Bandung" => array(
                "lat" => -6.9174639,
                "lon" => 107.6191228
            ),
            "Semarang" => array(
                "lat" => -7.0051453,
                "lon" => 110.4381254
            ),
            "Yogyakarta" => array(
                "lat" => -7.7955798,
                "lon" => 110.3694896
            ),
            "Surabaya" => array(
                "lat" => -7.2574719,
                "lon" => 112.7520883
            )
        );
		return $lokasi;
    }
    
    function weather()
    {
        $data = $this->remote_data('cuaca/prakiraan-cuaca-indonesia.bmkg');
        $lokasi = $this->latlon();
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
            $html                 = str_get_html($data);
			
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
				$nweather = count($table[0]->find('tr', 2)->find('td')) - 3;
				$ndata = count($table[0]->find('tr', 2)->find('td'));
				$weather_time = array();
				foreach($table[0]->find('tr', 1)->find('th') as $key=>$val)
				{
					$weather_time[] = str_replace(
						array('pagi', 'siang', 'sore', 'malam', 'dini_hari'), 
						array('morning', 'daylight', 'afternoon', 'night', 'dawn'), 
						strtolower(str_replace(" ", "_", trim($val->innertext))));
				}
				
				for($day = 0; $day < $idx; $day++)
				{
					$collection = array();
					$collection['date'] = @$date[$day];
					$collection['data'] = array();
					foreach ($table[$day]->find('tr') as $i=>$tr) 
					{
						if ($i > 1) 
						{
							$city = trim(strip_tags(@$tr->find('td', 0)->innertext, " \r\n\t "));
							if(strlen($city) > 1)
							{
								$weather = array();
								for($xx = 0; $xx<$nweather; $xx++)
								{
									$weather[$weather_time[$xx]] = strip_tags(@$tr->find('td', $xx+1)->innertext);
								}
								$temperature              = @$tr->find('td', $ndata-2)->innertext;
								$temperature_minmax       = explode(" - ", @$temperature);
								$humidity        = @$tr->find('td', $ndata-1)->innertext;
								$humidity_minmax = explode(" - ", @$humidity);
								
								$cells            = array(
									'city' => $city,
									'coordinate'=> @$lokasi[str_replace(" ", "_", $city)],
									'weather' => @$weather,
									'temperature' => array(
										'min' => strip_tags(@$temperature_minmax[0])*1,
										'max' => strip_tags(@$temperature_minmax[1])*1
									),
									'humidity' => array(
										'min' => strip_tags(@$humidity_minmax[0])*1,
										'max' => strip_tags(str_replace(" %", "", @$humidity_minmax[1]))*1
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
        return $result;
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
            $html                 = str_get_html($data);
			if(stripos($html, '<table class="table table-hover table-striped">') === false)
			{
				$result['status']     = "error";
				$result['message']    = "invalid_data";
				$result['timestamp']  = time();
				return $result;
			}
			//$content              = $html->find('div[class="container content"]', 0);
            //$table                = $content->find('table', 0);
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
            $html                 = str_get_html($data);
			
			if(stripos($html, '<table class="table table-hover table-striped">') === false)
			{
				$result['status']     = "error";
				$result['message']    = "invalid_data";
				$result['timestamp']  = time();
				return $result;
			}
			//$content              = $html->find('div[class="container content"]', 0);
            //$table                = $content->find('table', 0);
			$table                = $html->find('table[class="table-hover"]', 0);
            $i = 0;
			try
			{
				foreach ($table->find('tr') as $tr) {
					if ($i != 0) {
						
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