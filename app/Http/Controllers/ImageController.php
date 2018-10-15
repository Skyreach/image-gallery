<?php

namespace App\Http\Controllers;

use App\Image;
//use App\Services\ImageService;
//use App\Repositories\AwsImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as ImageManager;

class ImageController extends Controller
{
    public function index(){
        return view('upload.index');
    }

    public function store()
    {
        // This has been commented out because Laravel has some dependency issues using S3 outside of the built in Storage::disk()
        //  $imageService = new ImageService(new AwsImageRepository);
        //  $result = $imageService->processImages();

        //caption, description, alttext
        $caption = request('caption');
        $description = request('description');
        $altText = request('alttext');

        $file = $_FILES['fileToUpload']['tmp_name'];
        $fileName = basename($_FILES['fileToUpload']['name']);
        
        //todo: upload raw image to s3, investigate access denied to S3...
        //$storagePath = Storage::disk('s3')->put("images", $file, 'public');

        // upload the image
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
        $target_file = $target_dir . $fileName;
        $url = "/uploads/" . $fileName;

        // Check if validation was set to 0 by an error
        if ($this->validateImage($target_file) == 0) {
            return;
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Store image to db
        $image = new Image();

        $image->name = $fileName;
        $image->caption = $caption;
        $image->description = $description;
        $image->alttext = $altText;
        $image->url = $url;

        $image->save();

        // return $target_file;

        //create thumb
        // $parts = explode('.', $url);
        // $thumbPath = $parts[0] . '_thumb.' . $parts[1];
        $thumbUrl = '/uploads/thumbnail/' . $fileName;
        
        //scale image
        //$scaledImage = imagescale($target_file, 200, 200);
        
        $image_resize = ImageManager::make($target_file)->resize(200,200);
                
        //Save thumb to Uploads dir, 80% quality. You'll never miss it.
        $image_resize->save($_SERVER['DOCUMENT_ROOT'] . $thumbUrl, 80);

        //save thumb to db
        $imageThumb = new Image();

        $imageThumb->name = $fileName;
        $imageThumb->caption = $caption;
        $imageThumb->description = $description;
        $imageThumb->alttext = $altText;
        $imageThumb->url = $thumbUrl;

        $imageThumb->save();
        
        $images = Image::where('url', 'like', '%thumbnail%')->get();

        // return request()->all();
        return view('gallery.index', ['images' => $images]);
    }

    //Shamelessly borrowed from https://www.w3schools.com/php/php_file_upload.asp
    private function validateImage($target_file){
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
            //todo: this throws an exception if tmp_name is null, which occurs when the file is larger than php.ini limits
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 1000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }

            return $uploadOk;
        }
        return 0;
    }

    // The rest of these methods are to appease the Route::resource diety. 
    public function create(){
        return view('welcome');
    }

    public function show(){
        return view('welcome');
    }

    public function edit(){
        return view('welcome');
    }

    public function update(){
        return view('welcome');
    }

    public function destroy(){
        return view('welcome');
    }
}
