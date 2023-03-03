<?php

namespace App\Http\Controllers;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class frontendController extends Controller
{
    function Index(){
        return view('index');
    }
    public function Resep(){
        $resep = Resep::all();
        return view('admin.resep', compact('resep'));
    }
    public function Add(){
        return view('admin.add');
    }
    public function Insert(Request $request){
        $resep = new Resep();
        if($request->hasFile('Image')){
            $file = $request->file('Image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/resep/',$filename);
            $resep->Image = $filename;
        }
        $resep->Nama_Tumbuhan = $request->input('Nama_Tumbuhan');
        $resep->Penyakit = $request->input('Penyakit');
        $resep->Jenis = $request->input('Jenis');
        $resep->save();
        return redirect('/resep')->with("status", "Resep Added Succesfully");

    }
    public function Edit($id){
        $resep = Resep::find($id);
        return view('admin.edit', compact('resep'));
    }
    public function Update(Request $request, $id){
        $resep = Resep::find($id);
        if($request->hasFile('Image')){
            $path = 'assets/uploads/resep/'.$resep->Image;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('Image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/resep/',$filename);
            $resep->Image = $filename;
        }
        $resep->Nama_Tumbuhan = $request->input('Nama_Tumbuhan');
        $resep->Penyakit = $request->input('Penyakit');
        $resep->Jenis = $request->input('Jenis');
        $resep->update();
        return redirect('/resep')->with("status", "Resep Updated Succesfully");

    }
    public function Destroy($id){
        $resep = Resep::find($id);
        $path = 'assets/uploads/resep/'.$resep->Image;
        //if(File::exists($path)){
            File::delete($path);
        //}
        $resep->delete();
        return redirect('/resep')->with('status', 'Resep Deleted Succesfully');
    }
}
