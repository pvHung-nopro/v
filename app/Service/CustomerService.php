<?php
   namespace App\Service;
   use App\Models\Customer;
   use Illuminate\Http\Request;
   use Auth;


   class CustomerService{
    public function save(Request $request)
    {

       $user = Auth::user() ;

        return Customer::updateOrCreate([
            'phone'=> $request->phone
        ],
        [
            'name'    => $user->name,
            'email'   => $user->email,
            'address' => $request->address,
            'user_id' => $user->id
        ]);
    }
   }
