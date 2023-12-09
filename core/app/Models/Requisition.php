<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Requisition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function requisition_details(){
        return $this->hasMany(RequisitionDetails::class, 'requisition_id', 'id');
    }
    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function saveRequisitionData($request)
    {
        $requisition = Requisition::create([
            'user_id' => Auth::guard('web')->user()->id,
            'date' => $request->date ? $request->date : Carbon::now(),
            'status' => 0,
        ]);
        if($request->product_id && is_array($request->product_id)){
            foreach ($request->product_id as $key => $value) {
                if ($value != null || $value != "") {
                    RequisitionDetails::create([
                        'requisition_id' => $requisition->id,
                        'product_id' => $request->product_id[$key],
                        'product_need' => $request->product_need[$key],
                        'previous_date' => $request->previous_date[$key],
                        'comment' => $request->comment[$key],
                    ]);
                }
            }
        }
    }
    public static function updateRequisitiondata($request)
    {
        $news = Requisition::find($request->id);
        $news->name = $request->name;
        $news->des = $request->des;
        $news->status = $request->status;
        $news->save();
    }

    public static function deleteRequisitionData($request){
        $requisition = Requisition::find($request->id);
        if ($requisition) {
            $requisition->delete();
        }
    }
}
