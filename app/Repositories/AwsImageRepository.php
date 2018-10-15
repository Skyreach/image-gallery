<?php namespace App\Repositories;

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use App\Repositories\ImageRepositoryInterface;

class AwsImageRepository implements ImageRepositoryInterface {

    private $s3Client;
    private $bucket;
    public function __construct()
    {
        $this->bucket = env('AWS_BUCKET');

        //connect to AWS, Laravel has some built in connectors but using the AWS SDK instead to keep it closer to native PHP 
        try {
            $credentials = new Aws\Credentials\Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

            $this->s3Client = S3Client::factory(
                array(
                    'credentials' => $credentials,
                    'version' => 'latest',
                    'region' => 'us-east-2'
                )
            );
        } catch (Exception $ex) {
            // the boat stops here. Maybe consider json?
            die("Critical error establishing S3 connection!" . $ex.getMessage());
        }
    }

    public function processImages()
    {
        $file = $_FILES['fileToUpload']['tmp_name'];
        $filePath = 'images/' . $file;

        return $filePath;
        //upload raw image
        $this->upload($filePath, $file);

        //create thumb, using imagick 
        $image = new Imagick($file);
        $image->resizeImage(200, 200, Imagick::FILTER_CATROM, 0);

        //upload thumb
        $parts = explode('.', $filePath);
        $this->upload($parts[0] . '_thumb.' . $parts[1], $image->getImageBlob());
    }

    private function upload($path, $blob)
    {
        try {
            $medatata = array(
                'Caption' => $_POST['Caption'],
                'Description' => $_POST['Description'],
                'AltText' => $_POST['AltText']
            );

            //upload raw image
            $s3Client->putObject(
                array(
                    'ACL' => 'public-read',
                    'Bucket' => $bucket,
                    'ContentType' => $_FILES['fileToUpload']['type'],
                    'Key' => $path,
                    'SourceFile' => $blob,
                    'Metadata' => $medatata
                )
            );
        } catch (S3Exception $ex) {
            die('error uploading image! ' . $ex.getMessage());
        }
    }

    //Benign function, remove at anytime. Left so I could ask what I was doing incorrectly
    public function getAll(){
        $iter = $s3Client->getIterator('ListObjects', array(
            'Bucket' => $bucket
        ));

        $arr = array();
        foreach ($iter as $object){
            $arr[] = $s3Client->getObjectUrl($bucket, $object['Key']);
        }
    }
}