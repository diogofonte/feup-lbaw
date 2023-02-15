<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Address;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ChangeOrderStatus;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PendingConfirmationPayment;

class OrderController extends Controller
{



  public function show($id)
  {
    $this->middleware('auth:web');
    $order = Order::find($id);
    $this->authorize('show', $order);
    return view('pages.order', ['order' => $order]);
  }

  public function create(Request $request)
  {
  }

  public function store(Request $request)
  {
  }

  public function edit(Request $request)
  {
    $this->authorize('updateOrder', Auth::guard('admin')->user());
    $order = Order::find($request->id);
    $products = Product::all();
    // REVER O QUE ENVIAR PARA A VIEW DE EDIÇÃO DAS ORDERS
    // ADDRESS, CARD, STOCK ??
    return view('pages.admin.editOrder', ['order' => $order, 'products' => $products]);
  }

  public function update(Request $request, $id)
  {
  }

  public function editStatus(Request $request)
  {
    $this->middleware('guard:admin');

    $order = Order::find($request->id);
    if (is_null($order)) {
      abort('404');
    }

    $this->authorize('updateOrderStatus',  $order);

    $status_enum = ['Shopping Cart', 'Pending', 'In Progress', 'Completed', 'Cancelled'];

    return view('pages.admin.editOrderStatus', ['order' => $order, 'status_enum' => $status_enum]);
  }

  public function updateStatus(Request $request, $id)
  {
    if (!$order = Order::find($id)) {
      return Redirect::back()->withErrors(array('error'=>'error'));
    }
    $this->authorize('updateOrderStatus',  $order);

    $status_enum = ['Shopping Cart', 'Pending', 'In Progress', 'Completed', 'Cancelled'];

    $validator = Validator::make($request->all(), [
      'status' => 'required|string|in:' . implode(',', $status_enum),
    ]);

    if ($validator->fails()) {
      return Redirect::back()->withErrors(array('error'=>'error'));
    }

    $order['status'] = $request->input('status');

    if ($order->save()) {
      $user = $order->user;
      Notification::send($user, new ChangeOrderStatus($order));
      return Redirect::route('ordersAdminPanel');
    } else {
      return Redirect::back()->withErrors(array('error'=>'error'));
    }
  }

  public function delete($id)
  {
    $this->middleware('auth:web');
    if (!is_numeric($id)) {
      return Response::json(array('status' => 'error', 'message' => 'Error!'), 400);
    }

    $this->authorize('updateOrder', Auth::guard('admin')->user());
    $order = Order::find($id);
    if (is_null($order)) {
      return Response::json(array('status' => 'error', 'message' => 'Order not found!'), 404);
    }

    if ($order->delete()) {
      return Response::json(array('status' => 'success', 'message' => 'OK!'), 200);
    } else {
      return Response::json(array('status' => 'error', 'message' => 'Something happens!'), 500);
    }
  }

  public function checkout(Request $request)
  {
    $this->middleware('auth:web');
    $validator = Validator::make($request->all(), [
      'id_card' => 'required|integer',
      'id_address' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors(array('status' => 'error', 'message' => 'Error!'));
    }

    $user = Auth::user();
    $order = $user->orders()->where('status', 'Shopping Cart')->first();
    if (is_null($order)) {
      return redirect()->back()->with('status', 'Shopping Cart Empty!');
    }

    $details = $order->details;
    if (count($details) == 0) {
      return redirect()->back()->with('status', 'Shopping Cart Empty!');
    }

    if (!$card = Card::find($request['id_card'])) {
      return redirect()->back()->with('status', 'Card not found!');
    }

    if (!$address = Address::find($request['id_address'])) {
      return redirect()->back()->with('status', 'Address not found!');
    }

    $this->authorize('checkout', $card);
    $this->authorize('checkout', $address);

    $order1 = Order::find($order->id);
    $order1->id_card = $card->id;
    $order1->id_address = $address->id;
    $order1->save();

    $errors = array();
    foreach ($details as $detail) {
      $filters = array(['id_product', $detail['id_product']], ['id_color', $detail['id_color']], ['id_size', $detail['id_size']]);
      $stock = Stock::where($filters)->first();
      if ($stock['stock'] < $detail['quantity']) {
        array_push($errors, array('id_detail' => $detail, 'stock' => $stock['stock']));
      }
    }
    if (count($errors) != 0) {
      return redirect()->back()->with('error', $errors);
    }

    try {
      DB::select('SELECT checkout(?)', array($order->id));
    } catch (Exception $e) {
      return redirect()->back()->with('status', 'Something went wrong! Please try again!');
    }

    $user->notify(new PendingConfirmationPayment($order1->id));
    return redirect()->route('orderDetails', ['id' => $order->id]);
  }

  public function cancel(int $id){
    $this->middleware('auth:web');

    if(!is_numeric($id)){
      return redirect()->back();
    }
    
    $order = Order::find($id);
    if(is_null($order)){
      return redirect()->back();
    }

    if($order->status == 'Completed' || $order->status == 'Shopping Cart'){
      return redirect()->back();
    }

    $this->authorize('cancelOrder', $order);
    
    try {
      DB::select('SELECT cancel_order(?)', array($order->id));
    } catch (Exception $e) {
      return redirect()->back()->with('status', 'Something went wrong! Please try again!');
    }
    return redirect()->route('orderDetails', ['id' => $order->id]);
  }
  
  public function showCheckout()
  {
    $this->middleware('auth:web');
    $user = Auth::user();
    $order = $user->orders()->where('status', 'Shopping Cart')->first();
    if (is_null($order)) {
      return redirect()->back()->withErrors('status', 'Empty cart!');
    }

    $details = $order->details;
    if (count($details) == 0) {
      return redirect()->back()->withErrors('status', 'Empty cart!');
    }

    return view('pages.user.checkout', array('order' => $order,'user'=>$user, 'details' => $details, 'addresses' => $user->addresses, 'cards' => $user->cards));
  }
}

  