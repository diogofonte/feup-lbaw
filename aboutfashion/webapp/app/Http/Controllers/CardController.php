<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use App\Models\Card;

class CardController extends Controller
{
    public function __construct(){
      $this->middleware('auth:web');
    }

    public function list()
    {
      $cards = Auth::user()->cards()->orderBy('id')->get();
      $this->authorize('list', $cards);
      return view('pages.cards', ['cards' => $cards]);
    }

    public function create(){
      return view('pages.cards.create');
    }

    public function store(Request $request)
    {
      if(!is_null($request['number']) && !is_numeric($request['number'])){
          return redirect()->back(); // adicionar mensagens de erro
      }

      if(!is_null($request['code']) && !is_numeric($request['code'])){
        return redirect()->back(); // adicionar mensagens de erro
      } 

      $validator = Validator::make($request->all(),[
        'nickname'=> 'nullable|string|max:100',
        'name' => 'required|string|max:100',
        'number' => 'required|unique:card,number|size:16',
        'month'=> 'required|integer|between:1,12',
        'year'=> 'required|integer|between:22,50', 
        'code'=> 'required|string|size:3', 
      ]);
      if($validator->fails()){
        return redirect()->back(); // adicionar mensagens de erro
      }
      
      $card = new Card();

      if(!is_null($request['nickname'])){
        $card->nickname = $request['nickname'];
      }

      $card->name = $request['name'];
      $card->number = $request['number'];
      $card->month = $request['month'];
      $card->year = $request['year'];
      $card->code = $request['code'];
      $card->id_user = Auth::user()->id;

      if($card->save()){
        return Redirect::route('userView', array('id'=>Auth::user()));
      }else{
        return redirect()->back(); // adicionar mensagens de erro
      }
    }

    public function delete(Request $request, $id)
    {
      $card = Card::find($id);
      if(is_null($card)){
        return abort('404');
      }
      $this->authorize('delete', $card);
      $card->delete();

      return Redirect::route('userView', array('id'=>Auth::user()));
    }

    public function edit($id){
      $card = Card::find($id);
      $this->authorize('update', $card);
      if(is_null($card)){
        return abort('404');
      }
      
      return view('pages.cards.edit', ['card' => $card]);
    }

    public function update(Request $request, $id){
        $card = Card::find($id);
        if(is_null($card)){
          return abort('404');
        }
        $this->authorize('update', $card);
        
        if(!is_null($request['number'])){
          if(strlen($request['number']) != 16){
            return redirect()->back(); // adicionar mensagens de erro
          }
          if(!is_numeric($request['number'])){
            return redirect()->back(); // adicionar mensagens de erro
          }
        } 

        $validator = Validator::make($request->all(),[
          'nickname'=> 'nullable|string|max:100',
          'name' => 'nullable|string|max:100',
          'number' => 'nullable|unique:card,number',
          'month'=> 'nullable|integer|between:1,12',
          'year'=> 'nullable|integer|between:22,50', 
          'code'=> 'nullable|integer|digits_between:1,3', 
        ]);

        if($validator->fails()){
          return redirect()->back(); // adicionar mensagens de erro
        }

        if(!is_null($request['nickname'])){
          $card->nickname = $request['nickname'];
        }
        if(!is_null($request['name'])){
          $card->name = $request['name'];
        }
        if(!is_null($request['number'])){
          $card->number = $request['number'];
        }
        if(!is_null($request['month'])){
          $card->month = $request['month'];
        }
        if(!is_null($request['year'])){
          $card->year = $request['year'];
        }
        if(!is_null($request['code'])){
          $card->code = $request['code'];
        }      

        if($card->save()){
          return Redirect::route('userView', array('id'=>Auth::user()));
        }else{
          return redirect()->back(); // Adicionar mensagens de erro
        }
    }
}