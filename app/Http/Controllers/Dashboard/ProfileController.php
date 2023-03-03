<?php

namespace App\Http\Controllers\Dashboard;

// use auth;
// use file;

use App\Models\User;
use App\Models\DetailUser;
use App\Models\ExperienceUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;
use App\Http\Requests\Dashboard\Profile\UpdateDetailUserRequest;

class ProfileController extends Controller
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
        $user = User::where('id', Auth::user()->id)->first();
        $experience = ExperienceUser::where('user_detail_id', $user->detail_user->id)
            ->orderBy('id', 'asc')
            ->get();

        return view('pages.dashboard.profile', [
            'user' => $user,
            'experience' => $experience
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
    public function update(UpdateProfileRequest $request_profile, UpdateDetailUserRequest $request_detail, $id)
    {
        $data = $request_profile->all();
        $data_detail = $request_detail->all();

        // get user photo
        $getPhoto = DetailUser::where('user_id', Auth::user()->id)->first();
        $photo = str_replace('assets/photo_profile/', '', $getPhoto['photo']);

        // delete old photo
        if ($photo != NULL) {
            if (Storage::disk('photo_profile')->exists($photo)) {
                unlink(storage_path('app\public\\' . $getPhoto['photo']));
            }
        }


        // store photo to storage
        if (isset($data_detail['photo'])) {
            $data_detail['photo'] = $request_detail->file('photo')->store(
                'assets/photo_profile',
                'public'
            );
        }

        // update user
        $user = User::find(Auth::user()->id);
        $user->update($data);

        // update detail user
        $detail_user = DetailUser::find($user->detail_user->id);
        $detail_user->update($data_detail);
        $detail_user['contact_number'] = $data_detail['contact_number'];
        $detail_user->save();


        // update experience user
        $experience = ExperienceUser::where('user_detail_id', $detail_user->id)->first();
        if (isset($experience)) {

            foreach ($data['experience'] as $key => $value) {
                $experience_user = ExperienceUser::find($key);
                $experience_user->user_detail_id = $detail_user->id;
                $experience_user->experience = $value;
                $experience_user->save();
            }
        } else {

            foreach ($data['experience'] as $key => $value) {
                $experience_user = new ExperienceUser();
                $experience_user->user_detail_id = $detail_user->id;
                $experience_user->experience = $value;
                $experience_user->save();
            }
        }

        toast()->success('Profile berhasil diperbarui');

        return back();
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


    public function delete()
    {
        // get user photo
        $get_user_photo = DetailUser::where('user_id', Auth::user()->id)->first();

        // update photo to NULL
        $data = DetailUser::find($get_user_photo['id']);
        $data->photo = NULL;
        $data->save();

        $photo = str_replace('assets/photo_profile/', '', $get_user_photo['photo']);

        if ($get_user_photo['photo'] != NULL) {
            if (Storage::disk('photo_profile')->exists($photo)) {
                unlink(storage_path('app\public\\' . $get_user_photo['photo']));
            }
        }

        toast()->success('Foto berhasil dihapus');

        return back();
    }
}
