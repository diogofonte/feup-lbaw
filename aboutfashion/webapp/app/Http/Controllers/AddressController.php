<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;

class AddressController extends Controller
{
    public function __construct(){
        $this->middleware('auth:web');
      }

  
      public function create(){
        $countries = Country::all();
        return view('pages.addresses.create', compact('countries'));
      }
  
      public function store(Request $request)
      {
        if(!is_null($request['nif']) && !is_numeric($request['nif'])){
            return redirect()->back(); // adicionar mensagens de erro
        } 
  
        $validator = Validator::make($request->all(),[
          'name'=> 'required|string|max:100',
          'company' => 'nullable|string|max:100',
          'nif' => 'nullable|string|size:9',
          'street'=> 'required|string',
          'number'=> 'required|integer', 
          'apartment'=> 'required|string',
          'note'=> 'nullable|string',
          'id_country'=> 'required|integer',
        ]);
        if($validator->fails()){
          return redirect()->back(); // adicionar mensagens de erro
        }

        $country = Country::find($request['id_country']);
        if(is_null($country)){
            return redirect()->back();
        }
        
        $address = new Address();
  
        $address->name = $request['name'];
        $address->company = $request['company'];
        $address->nif = $request['nif'];
        $address->street = $request['street'];
        $address->number = $request['number'];
        $address->apartment = $request['apartment'];
        $address->note = $request['note'];
        $address->id_country = $request['id_country'];
        $address->id_user = Auth::user()->id;

  
        if($address->save()){
          return Redirect::route('userView', array('id'=>Auth::user()));
        }else{
          return redirect()->back(); // adicionar mensagens de erro
        }
      }
  
      public function delete(Request $request, $id)
      {
        $address = Address::find($id);
        if(is_null($address)){
          return abort('404');
        }
        $this->authorize('delete', $address);
        $address->delete();
  
        return Redirect::route('userView', array('id'=>Auth::user()));
      }
  
      public function edit($id){
        $address = Address::find($id);
        $this->authorize('update', $address);
        if(is_null($address)){
          return abort('404');
        }
        $countries = Country::all();
        return view('pages.addresses.edit', ['address' => $address, 'countries' => $countries]);
      }
  
      public function update(Request $request, $id){
          $address = Address::find($id);
          if(is_null($address)){
            return abort('404');
          }
          $this->authorize('update', $address);

          
          if(!is_null($request['nif']) && !is_numeric($request['nif'])){
            return redirect()->back(); // adicionar mensagens de erro
        } 
  
        $validator = Validator::make($request->all(),[
          'name'=> 'nullable|string|max:100',
          'company' => 'nullable|string|max:100',
          'nif' => 'nullable|string|size:9',
          'street'=> 'nullable|string',
          'number'=> 'nullable|integer', 
          'apartment'=> 'nullable|string',
          'note'=> 'nullable|string',
          'id_country'=> 'nullable|integer',
        ]);
        if($validator->fails()){
          return redirect()->back(); // adicionar mensagens de erro
        }
  
          if(!is_null($request['name'])){
            $address->name = $request['name'];
          }
          if(!is_null($request['company'])){
            $address->company = $request['company'];
          }
          if(!is_null($request['nif'])){
            $address->nif = $request['nif'];
          }
          if(!is_null($request['street'])){
            $address->street = $request['street'];
          }
          if(!is_null($request['number'])){
            $address->number = $request['number'];
          }
          if(!is_null($request['apartment'])){
            $address->apartment = $request['apartment'];
          }
          if(!is_null($request['note'])){
            $address->note = $request['note'];
          }
          if(!is_null($request['id_country'])){
            $address->id_country = $request['id_country'];
          }
                
  
          if($address->save()){
            return Redirect::route('userView', array('id'=>Auth::user()));
          }else{
            return redirect()->back(); // Adicionar mensagens de erro
          }
      }
}