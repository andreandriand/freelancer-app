<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Service;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\Tagline;
use App\Models\ThumbnailService;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('pages.landing.index', [
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }


    public function explore()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('pages.landing.explorer', [
            'services' => $services
        ]);
    }

    public function detail($id)
    {
        $service = Service::where('id', $id)->first();

        $advantage_service = AdvantageService::where('service_id', $id)->get();
        $advantage_user = AdvantageUser::where('service_id', $id)->get();
        $tagline = Tagline::where('service_id', $id)->get();
        $thumbnail = ThumbnailService::where('service_id', $id)->get();

        return view('pages.landing.detail', [
            'service' => $service,
            'advantage_service' => $advantage_service,
            'advantage_user' => $advantage_user,
            'tagline' => $tagline,
            'thumbnail' => $thumbnail
        ]);
    }

    public function booking($id)
    {
        $service = Service::where('id', $id)->first();
        $buyer = Auth::user()->id;

        // validation booking
        if ($service->user_id == $buyer) {
            toast()->warning('Kamu tidak bisa memesan service milikmu sendiri');
            return back();
        }

        $order = new Order;
        $order->buyer_id = $buyer;
        $order->freelancer_id = $service->user->id;
        $order->service_id = $service->id;
        $order->file = NULL;
        $order->note = NULL;
        $order->order_status_id = 4;
        $order->save();

        $order_detail = Order::where('id', $order->id)->first();

        return redirect()->route('detail.booking.landing', $order->id);
    }

    public function detail_booking($id)
    {
        $order = Order::where('id', $id)->first();
        return view('pages.landing.booking', [
            'order' => $order
        ]);
    }
}
