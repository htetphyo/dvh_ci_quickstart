<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
   public function index()
 	{
    $name = 'myanmar';

    // //Read JSON file
    // $filepath = "json_set/dashboard.json";
    // if (! file_exists($filepath) ) {
    //   die("Cann't find Json file");
    // }
    //
    // $json = file_get_contents($filepath);
    // //Decode JSON
    // $json_data = json_decode($json,true);
    //
    // //Print data
    // print_r($json_data);
    //
    // // $lang = $this->config->item('gender');
    // // var_dump($lang);
    //
    //
    //   die();
    //



    $url_base =   "http://192.168.10.52/dvh_api/public/api/boundary/".$name;

    $returndata    =  $this->curl->simple_get($url_base);
    $arr_data    = json_decode( $returndata , true);

    $data['regions'] =  $arr_data[$name];

    //  var_dump($return_data);
    $this->load->view('includes/header');
    $this->load->view('home',$data);
    $this->load->view('includes/footer');
 	}


	public function regions()
	{
$name = 'myanmar';
  $url_base =   "http://192.168.10.52/dvh_api/public/api/boundary/".$name;

  $returndata    =  $this->curl->simple_get($url_base);
  $arr_data    = json_decode( $returndata , true);

  $data['regions'] =  $arr_data[$name];

//  var_dump($return_data);
    $this->load->view('includes/header');
		$this->load->view('all_region',$data);
    $this->load->view('includes/footer');
	}


  public function each_region($name){

    $point_arr =  array('ayeyarwaddy' =>  array(
                          'lat' => 17.0265275 ,
                          'lng' => 94.960546
                        )
                  );
    $data['point_arr']  = $point_arr;

    $url_base =   "http://192.168.10.52/dvh_api/public/api/boundary?reg=".$name;
    $returndata    =  $this->curl->simple_get($url_base);
    $arr_data  = json_decode( $returndata , true);
    $data['points'] =  $arr_data[$name];


    $district = array();


  $uri_data = $this->uri->segment(2);
  if(  $uri_data == "ayeyarwaddy"){
    $ayeay_url_base =   "http://192.168.10.52/dvh_api/public/api/dataset?reg=ayarwady&tb=A-7";
    $ayeayreturndata    =  $this->curl->simple_get($ayeay_url_base);
    $ayeayarr_data  = json_decode( $ayeayreturndata , true);
    if(count($ayeayarr_data)>0){
      foreach ($ayeayarr_data as $value) {
         if($value['level'] == "district"){
            $district[] = $value;
         }
      }
    }

  }
    $data['district'] =  $district;
    // echo "<pre>";
    // var_dump();
    // die();


    // var_dump($data['points']);
    $this->load->view('includes/header');
    $this->load->view('region_each',$data);
    $this->load->view('includes/footer');

  }
}
