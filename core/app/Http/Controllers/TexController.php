<?php

namespace App\Http\Controllers;

use App\Models\Tex;
use Illuminate\Http\Request;

class TexController extends Controller
{
    public function TexReturn($id)
    {
        $texs = Tex::where('ls_case_id', $id)->get();
        return view('admin.port_manage.tex', compact('id', 'texs'));
    }

    public function AddTex($id)
    {
        return view('admin.port_manage.add_tex', compact('id'));
    }

    public function saveTex(Request $request)
    {
        $tex_file = null;
        if ($request->tex_file) {
            
            $path = 'core/storage/app/public/documents/';
            $request->tex_file->store('documents','public');
            $tex_file = $path . $request->tex_file->hashName();
        }
        $tex = Tex::create([
            'ls_case_id' => $request->id,
            'amount'    => $request->amount,
            'date'    => $request->date,
            'document' => $tex_file,
        ]);

        if($tex){
            return redirect()->route('ls_case_tax', $request->id);
        }else{
            dd("something is wrong");
        }
    }
}
