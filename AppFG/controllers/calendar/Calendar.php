<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');

        // $prefs = array(
        //     'start_day' => 'monday',
        //     'month_type' => 'long',
        //     'day_type' => 'long',
        //     'show_next_prev' => true,
        //     'next_prex_url' => base_url('calendar/calendar/'),
        //     'show_other_days' => true
        // );

        $prefs['template'] = array(
            'table_open'           => '<table class="calendar">',
            'cal_cell_start'       => '<td class="day">',
            'cal_cell_start_today' => '<td class="today">'
    );

        $this->load->library('calendar',$prefs);
        
        
    }

    public function index()
    {
        echo $this->calendar->generate();
    }
    
    
    public function fullcalendar()
    {
        $this->load->view('calendar/view_home');
    }

    
}