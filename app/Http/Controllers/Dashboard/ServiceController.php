<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Service;
use App\Models\AdvantageService;
use App\Models\Tagline;
use App\Models\AdvantageUser;
use App\Models\ThumbnailService;
use App\Models\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;
use App\Http\Requests\Dashboard\Service\StoreServiceRequest;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.Dashboard.service.index', [
            'services' => $service
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $service = Service::create($data);

        // save to advantage service
        foreach ($data['advantage-service'] as $key => $value) {
            $advantageService = new AdvantageService;
            $advantageService->service_id = $service->id;
            $advantageService->advantage = $value;
            $advantageService->save();
        }

        // save to advantage user
        foreach ($data['advantage-user'] as $key => $value) {
            $advantageUser = new AdvantageUser;
            $advantageUser->service_id = $service->id;
            $advantageUser->advantage = $value;
            $advantageUser->save();
        }

        // save to tagline
        if (isset($data['tagline'])) {
            foreach ($data['tagline'] as $key => $value) {
                $tagline = new Tagline;
                $tagline->service_id = $service->id;
                $tagline->tagline = $value;
                $tagline->save();
            }
        }

        // save to thumbnail service

        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {
                $path = $file->store('assets/service/thumbnail', 'public');

                $thumbnailService = new ThumbnailService;
                $thumbnailService->service_id = $service->id;
                $thumbnailService->thumbnail = $path;
                $thumbnailService->save();
            }
        }

        toast()->success('Service Berhasil Ditambahkan');
        return redirect()->route('member.service.index');
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
    public function edit(Service $service)
    {
        $advantageService = AdvantageService::where('service_id', $service->id)->get();
        $advantageUser = AdvantageUser::where('service_id', $service->id)->get();
        $tagline = Tagline::where('service_id', $service->id)->get();
        $thumbnailService = ThumbnailService::where('service_id', $service->id)->get();

        return view('pages.Dashboard.service.edit', [
            'service' => $service,
            'advantageService' => $advantageService,
            'advantageUser' => $advantageUser,
            'tagline' => $tagline,
            'thumbnailService' => $thumbnailService
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->all();

        // update service
        $service->update($data);

        // update advantage service
        foreach ($data['advantage-services'] as $key => $value) {
            $advantageService = AdvantageService::find($key);
            $advantageService->advantage = $value;
            $advantageService->save();
        }

        // add new advantage service
        if (isset($data['advantage-service'])) {
            foreach ($data['advantage-service'] as $key => $value) {
                $advantageService = new AdvantageService;
                $advantageService->service_id = $service->id;
                $advantageService->advantage = $value;
                $advantageService->save();
            }
        }

        // update advantage user
        foreach ($data['advantage-users'] as $key => $value) {
            $advantageUser = AdvantageUser::find($key);
            $advantageUser->advantage = $value;
            $advantageUser->save();
        }

        // add new advantage user
        if (isset($data['advantage-user'])) {
            foreach ($data['advantage-user'] as $key => $value) {
                $advantageUser = new AdvantageUser;
                $advantageUser->service_id = $service->id;
                $advantageUser->advantage = $value;
                $advantageUser->save();
            }
        }

        // update tagline
        if (isset($data['taglines'])) {
            foreach ($data['taglines'] as $key => $value) {
                $tagline = Tagline::find($key);
                $tagline->tagline = $value;
                $tagline->save();
            }
        }

        // add new tagline
        if (isset($data['tagline'])) {
            foreach ($data['tagline'] as $key => $value) {
                $tagline = new Tagline;
                $tagline->service_id = $service->id;
                $tagline->tagline = $value;
                $tagline->save();
            }
        }

        // update thumbnail service
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $file) {

                // get old thumbnail
                $oldThumbnail = ThumbnailService::where('service_id', $service->id)->first();

                // store thumbnail
                $path = $file->store('assets/service/thumbnail', 'public');

                // update thumbnail
                $thumbnailService = new ThumbnailService;
                $thumbnailService->thumbnail = $path;
                $thumbnailService->save();

                // delete old thumbnail
                $data = 'storage/' . $oldThumbnail->thumbnail;
                if (File::exists($data)) {
                    File::delete($data);
                } else {
                    File::delete('storage/app/public' . $oldThumbnail->thumbnail);
                }
            }
        }

        // add new thumbnail service
        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {
                $path = $file->store('assets/service/thumbnail', 'public');

                $thumbnailService = new ThumbnailService;
                $thumbnailService->service_id = $service->id;
                $thumbnailService->thumbnail = $path;
                $thumbnailService->save();
            }
        }

        toast()->success('Service Berhasil Diubah');
        return redirect()->route('member.service.index');
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
}
