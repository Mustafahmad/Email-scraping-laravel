<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ScrapingController extends Controller
{
    public function show()
    {
        $scrapedData = json_decode(Storage::get('scraped_data.json'), true);
    
        // Check if there is data to be stored
        if (!empty($scrapedData)) {
            $model = new Post();
            $model->data = $scrapedData;
            $model->save();
        }
    
        return view('emailScrapedData')->with('scrapedData', $scrapedData);
    }
    
    public function index()
    {
        $scrapedData = Post::all();
        return response()->json(['data' => $scrapedData]);
    }
 
    public function runCommand()
    {
        try {
            Artisan::call('email:scrape-imap');
            $output = Artisan::output();
            return response()->json(['message' => 'Command executed successfully', 'output' => $output]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: Command execution failed', 'error' => $e->getMessage()], 500);
        }
    }
    

}
