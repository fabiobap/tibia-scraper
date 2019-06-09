<?php

namespace App\Services;

use App\Boss;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BossFileUploader
{
    public function upload($request){
        
       $name = $request->name;
        
        $fileExists = $request->hasFile('image');
        $fileIsValid = $request->file('image')->isValid();
        
        if($fileExists && $fileIsValid){
            
            // Random timestamp
            $fileNameNew = $name.'-'.uniqid(date('HisYmd'));
 
            // Retrieve extension
            $extension = $request->image->extension();
 
            // Define the name
            $fileNameNew .= ".".$extension;
            
            $finalPath = 'bosses'.'/'.$fileNameNew;
            // Upload
            $upload = $request->image->storeAs('bosses', $fileNameNew);
            // If it's working the file will be at storage/app/public/bosses/filename.extension
 
            // Verify if the upload didn't work and send it back
            if (!$upload){
                return redirect()
                    ->back()
                    ->with('error', 'An error occured during the upload!')
                    ->withInput();
            }
        }
        $this->createBossRecord($name, $finalPath);
    }
    
    private function createBossRecord($name, $pathToImg){
        
        $boss = Boss::create(['name'=>$name, 'image'=>$pathToImg]);
    }
}