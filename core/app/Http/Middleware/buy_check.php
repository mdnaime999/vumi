<?php

namespace App\Http\Middleware;

use App\Libraries\Encryption;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Auth;
use DB;
class buy_check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard("user")->check()) {
            $id = Encryption::decodeId($request->route('id'));
            $product = Product::find($id);
            $check = DB::table('orders')
                    ->join('order_details','orders.id','=','order_details.order_id')
                    ->where("orders.user_id",Auth::guard("user")->user()->id)
                    ->where("orders.payment_status","complete")
                    ->where('order_details.product_id',$id)
                    ->first(); 
                    if($product->price == 0 || $check){
                        return $next($request);
                    }
                    else{
                        return redirect()->back();
                    }
        }
        else{
            return redirect('/login');
        }
    }
}
