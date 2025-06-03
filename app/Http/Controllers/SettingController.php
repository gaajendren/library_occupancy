<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
   
    public function index()
    {
        $setting = Setting::first();

        return view('staff.setting.setting' , compact('setting'));
    }

    public function update(Request $request)
    {

        $setting = Setting::first();
       
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            'banner_2' => 'mimetypes:image/png,image/jpeg,image/gif,image/svg+xml,image/webp|max:2048',
            'banner_3' => 'mimetypes:image/png,image/jpeg,image/gif,image/svg+xml,image/webp|max:2048',
            'img.*' => 'mimetypes:image/png,image/jpeg,image/gif,image/svg+xml,image/webp|max:2048',
        ]);

        $setting->title = $request->title;
        $setting->description = $request->description;

        $setting->start_time = $request->start_time;
        $setting->end_time = $request->end_time;
        $setting->is_manual = $request->is_manual;

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('img'), $imageName); 
            $setting->logo = 'img/' . $imageName; 
        }

        try{ 

            $filenames = [];
            
            $banner = json_decode($setting->banner, true);

            $filenames = $banner['slider_image'];

           
            if ($request->hasFile('img') ) {
    
                foreach ($request->file('img') as $image) {
                    $filename = $image->getClientOriginalName();
                    $uniqueFilename = time() . '_' . $filename; 
                    $image->move(public_path('img'), $uniqueFilename);
                    $filenames[] = $uniqueFilename;
                }
            }   

            if($request->hasFile('banner_3')){
                $sideBannerName_3 = $request->file('banner_3');
                $BannerName_3 = time() . '.' . $sideBannerName_3->getClientOriginalExtension(); 
                $sideBannerName_3->move(public_path('img'), $BannerName_3);
            } else {
                $BannerName_3 = $banner['banner_3']; 
            }
           
            if($request->hasFile('banner_2')){
                $sideBannerName_2 = $request->file('banner_2');
                $BannerName_2 = time() . '.' . $sideBannerName_2->getClientOriginalExtension(); 
                $sideBannerName_2->move(public_path('img'), $BannerName_2);
            } else {
                $BannerName_2 = $banner['banner_2']; 
            }


            $setting->banner = json_encode(['slider_image' => $filenames, 'banner_2' => $BannerName_2, 'banner_3' => $BannerName_3]);
            
            $setting->save();

            try {
                Http::timeout(5)->get('http://127.0.0.1:5000/setting_update');
                \Log::info('✅ Flask setting update triggered');
            }catch(\Exception $e) {
                \Log::error('❌ Failed to call Flask: ' . $e->getMessage());
            }

        
            return redirect()->route('staff.setting')->with('success', 'Setting updated successfully!');

        }catch(\Exception $e){
            return redirect()->route('staff.setting')->with('error', $e->getMessage());

         }
    }


    public function delete(Request $request){
        
        $setting = Setting::first();

        $key = $request->key;

        $banner_json =  json_decode($setting->banner, true);

        unset($banner_json['slider_image'][$key]);

        $banner_json['slider_image'] = array_values($banner_json['slider_image']);

        $setting->banner = json_encode($banner_json, JSON_UNESCAPED_SLASHES);

        $setting->save();

        return redirect()->back()->with('success', 'Successfully removed the banner');

    }

    public function img_store(Request $request)
    {
        $request->validate([
            'enter_frame' => 'required',
            'exit_frame' => 'required'
        ]);

       
        $enterImage = base64_decode($request->enter_frame);
        $exitImage = base64_decode($request->exit_frame);

        // Define file paths (inside public/img)
        $enterPath = 'img/enter_' . time() . '.jpg';
        $exitPath = 'img/exit_' . time() . '.jpg';

        
        file_put_contents(public_path($enterPath), $enterImage);
        file_put_contents(public_path($exitPath), $exitImage);

        $setting = Setting::first();

        
        $setting->frame = [
            'enter_frame' => $enterPath,
            'exit_frame' =>  $exitPath
        ];

        $setting->save();
        

        return response()->json(['message' => 'Frame saved successfully']);
    }


    public function update_roi(Request $request){
        try{
            $setting = Setting::first();

            $setting->roi = $request->roi;

            $setting->save();

            return response()->json(['message' => 'Succesfully Updated']);
        }catch(\Exception $e){
            return response()->json(['message' => $e]);
        } 
    }

    public function update_roi_exit(Request $request){

        try{
            $setting = Setting::first();

            $setting->exit_roi = $request->roi;

            $setting->save();

            return response()->json(['message' => 'Succesfully Updated']);
        }catch(\Exception $e){
            return response()->json(['message' => $e]);
        } 

    }


}
