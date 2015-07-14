<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Provider;
use App\Http\Templates;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Mail;
use App\Notice;
use Illuminate\Http\RedirectResponse;


class NoticesController extends Controller
{

    /**
     * Create a new notices controller instance.
     *
     */

    public function __construct()
    {

        $this->middleware('auth');

        parent::__construct();

    }


    /*
     * Show all notices.
     *
     * @return string
     */

    public function index()
    {

        //return Notice::all();

       $notices = $this->user->notices;

        return view ('notices.index', compact('notices'));

    }

    /**
     * Show a page to create a new notice.
     *
     * @return \Response
     *
     *
     */


    public function create()
    {

        // get list of providers

        $providers = Provider::lists('name', 'id');

        // load a view to create a new notice

        return view ('notices.create', compact('providers'));

    }

    /**
     *
     * Ask the user to confirm the DMCA that Will be delivered.
     *
     * @param Requests\PrepareNoticeRequest $request
     * @param Guard
     * @return \Response
     *
     */

    public function confirm(Requests\PrepareNoticeRequest $request )
    {
        $template=$this->compileDmcaTemplate($data = $request->all());

       session()->flash('dmca', $data);

        return view('notices.confirm', compact('template'));
    }

    /**
     *
     *Store a new DMCA notice.
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector.
     *
     */


    public function store(Request $request)
    {

       $notice= $this->createNotice($request);


        Mail::queue(['text'=>'emails.dmca'], compact('notice'), function($message) use($notice){

            $message->from($notice->getOwnerEmail())
                    ->to($notice->getRecipientEmail())
                    ->subject('DMCA Notice');

        });

        flash('Your DMCA notice has been delivered!');

        return redirect('notices');



    }

    /**
     *
     *
     * @param $noticeId
     * @param Request $request
     * @return mixed
     *
     */
    public function update($noticeId, Request $request)
    {

        $isRemoved = $request ->has('content_removed');

        Notice::findOrFail($noticeId)
            ->update(['content_removed' => $isRemoved]);


    }


    /**
     *
     *
     * Compile DMCA Template from the form data.
     *
     * @param $data

     *
     * @return  mixed
     *
     *
     *
     */

    public function compileDmcaTemplate($data)
    {

        $data=$data+[

                'name'=> $this->user->name,
                'email'=> $this->user->email,

            ];

        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }

    /**
     * Create and persist a new DMCA notice.
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createNotice(Request $request)
    {
        $notice = session()->get('dmca')+['template' => $request -> input('template')];

        //  return \Request::input('template');

      //  $notice = Notice::open($data)
      //      ->useTemplate($request->input('template'));

       $notice = $this->user->notices()->create($notice);


        return $notice;

    }

}
