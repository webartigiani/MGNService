<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
// #region Constructor
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
// #endregion Constructor

// #region API Methods
    /**
     * Return the user data
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $response = [
            'success' => true,
            'data'    => auth('api')->user(),
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the profile by users
     *
     * @param  \App\Http\Requests\Users\ProfileUpdateRequest  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = auth('api')->user();
        $user->update($request->all());
        $response = [
            'success' => true,
            'data'    => $user,
            'message' => 'Profilo utente aggiornato con successo',
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\ChangePasswordRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        User::find(auth('api')->user()->id)->update(['password' => Hash::make($request->new_password)]);
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Password modificata con successo',
        ];
        return response()->json($response, 200);
    }
// #region API Methods

// #region Public Methods
// #endregion Public Methods

// #region Private Methods
    /*
     * Normalizes worker data
     */
    private function normalizeData($data) {
        return $data;
    }
// #endregion Private Methods
}
