<?php

namespace App\Http\Controllers\Admin;
use App\Model\Category;
use App\SubCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        // return view('admin.firebase');

        $token = "fgZDxMOVSiSviVmZWplIeK:APA91bEdfZa4_sBAhPYzRLdHzXReD1DgS3N71RAAx9pU_qyj7W3oOnehOx4sg_V9KixBoT-BrTYoJ2kMW__MmgYjBaL7LHlQghtY-sKvGgy796lowgh7eyfsIHvAEVvpYGu77OcgTvKy";  
        $from = "AAAAJCqGG44:APA91bEvhQbUnElsmKXrWKOxZbdwYALOvhK6jhQbYX5LPkLTzhAMFlOfY-RJNQjc8OPkTVdwyxMASjH71OxfnpiOshEWPJswUG3CdkUNHIKEN-lNirkycfTy0YYslCEfbbnOfKDmov1Z";
        $msg = array
              (
                'body'  => "Testing Testing",
                'title' => "Hi, From Whitescastle",
                // 'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",
                // 'sound' => 'mySound'
              );

              // $data = [
              //       "registration_ids" => $firebaseToken,
                    
              //   ];
              //   $dataString = json_encode($data);
        $fields = array
                (
                    'to'        => $token,
                    "notification" => [
                        "title" => 'basit',
                        "body" => 'body',  
                    ]
                );

        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        
        $result = curl_exec($ch);
        curl_close( $ch );
    }
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.category.index')->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file('img_url'))
        {   
            $path = $request->file('img_url')->store('/uploads');
        }else{
            $path = '';
        }
        
        if($request->category_id)
        {
            $category = Category::find($request->category_id);
        }else{
            $category = new Category;
        }
        
        $category->name = $request->name;
        $category->currency_symbol = $request->currency_symbol;
        if(!empty($path))
        {
            $subcategory->image_url = $path;
        }
        $category->save();

        return redirect()->back()->with('success', 'your message,here');   
    }


    public function subcategorystore(Request $request)
    {
        if($request->file('img_url'))
        {   
            $path = $request->file('img_url')->store('/uploads');
        }else{
            $path = '';
        }
        
        // $path = Storage::putFile('uploads', $request->file('img_url'));
        if($request->subcategory_id)
        {
            $subcategory = SubCategories::find($request->subcategory_id);
        }else{
            $subcategory = new SubCategories;
        }
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        if(!empty($path))
        {
            $subcategory->image_url = $path;
        }
        $subcategory->save();

        return redirect()->back()->with('success', 'your message,here');   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Category::find($id);
        return view('admin.category.sub-category')->with(compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
