<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileInformationController extends Controller
{
    //por lo que cómo prueba que esto funciona en backend? en fronts eria optimo
    // private string $ui_avatar_api = "https://ui-avatars.com/api/?name=*+*&size=128";

    //por lo que es backend y no tendría parte visual para ver el el view de edit
    // public function edit()
    // {
    //     return view('profile.show', [
    //         'user' => Auth::user(),
    //     ]);
    // }

    public function update(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'alpha','min:3', 'max:35'],
            'second_name' => ['required', 'string', 'min:3', 'max:35'],
            'birthdate' => ['nullable', 'string', 'date_format:d/m/Y',
                'after_or_equal:' . date('Y-m-d', strtotime('-70 years')),
                'before_or_equal:' . date('Y-m-d', strtotime('-18 years'))],
            'personal_phone' => ['required', 'numeric', 'digits:10'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ]);


        $user = $request->user();




        /*Update the model using Eloquent*/
        $user->first_name = $request['first_name'];
        $user->second_name = $request['last_name'];
        $user->birthdate = $this->verifyDateFormat($request['birthdate']);
        $user->personal_phone = $request['personal_phone'];
        $user->address = $request['address'];
        $user->save();

        //por lo que es backend y no tendría parte visual para ver el avatar
        // $this->updateUIAvatar($user);

        return back()->with('status', 'Profile update successfully');
    }

   //por lo que es backend y no tendría parte visual para ver el avatar
    // private function updateUIAvatar(User $user): void
    // {
    //     $user_image = $user->image;
    //     $image_path = $user_image->path;
    //     if (Str::startsWith($image_path, 'https://')) {
    //         $user_image->path = Str::replaceArray(
    //             '*',
    //             [
    //                 $user->first_name,
    //                 $user->second_name
    //             ],
    //             $this->ui_avatar_api
    //         );
    //         $user_image->save();
    //     }
    // }


    private function verifyDateFormat(?string $date): ?string
    {
        return isset($date)
            ? $this->changeDateFormat($date, 'd/m/Y')
            : null;
    }


    public static function changeDateFormat(
        string $date,
        string $date_format,
        string $expected_format = 'Y-m-d'
    ): string
    {
        return Carbon::createFromFormat($date_format, $date)->format($expected_format);
    }

}
