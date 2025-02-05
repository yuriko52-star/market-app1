<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
   public function downloadImage()
    {
        $imageUrl = 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg';
        $fileName = basename($imageUrl);
       

        // S3から画像を取得
        $response = Http::get($imageUrl);

        if ($response->successful()) {
            // storage/app/public/images/ に保存
            Storage::disk('public')->put("images/{$fileName}", $response->body());

            return "画像が storage/images/{$fileName} に保存されました！";
        }  
}
}