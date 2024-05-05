<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Models\EmailMarketing;
use Illuminate\Support\Facades\Mail;

class EmailMarketingController extends AccountBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Email Marketing';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('email-marketing.index', $this->data);
    }
}
