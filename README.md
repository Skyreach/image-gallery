image-gallery

Preface:
This is a project built for supporting the Info-Tech Developer Project which can be found here https://github.com/InfoTech/infotech-project-skyreach.

It was requested to build the project using PHP, and for some unknown reason I decided to use Laravel in order to set up the core project framework.

Only after being a ways in had I realized that Ruby would have been a significantly more appropriate framework to use, but at that point in time I'd made my peace. I apologize for any inconvenience this will cause, as I'm not sure how the magic differs between them yet.

I would also like to mention that I did try to get the AWS S3 bucket working, but was getting denied access, possibly due to a missing cert. I did leave the code in case you wanted to look, it is benign. During PR this would absolutely be removed.

It's also worth noting that I've intentionally omitted the .env file from .gitignore; I realize you must never do this, however there are no configs that are dangerous being exposed, and this will hopefully make your runtime lives a bit easier. RE: CSRF_Token

Settings not placed in .env file:
AWS_BUCKET=
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=eu-west-1        // I presumed eu-west-1, based on the permanent redirect.

PHP.ini flags:
upload_max_filesize = Set respectable upper limit based on images being uploaded
extension=curl
extension=fileinfo
extension=gd2
extension=mysqli
extension=pdo_mysql

Technical requirements:
MySQL
Composer (https://getcomposer.org/)
npm, and by proxy nodejs (https://nodejs.org/en/   8.12.0 LTS)

Run these commands in order to build:
> composer update --no-dev
> npm install --no-bin-links
> php artisan migrate

To run the project:
> php artisan serve

Other notes:
File handling is missing some checks: Possible collision on file name related to TempFileName generated, missing MD5 for collision handling of different file names
S3 content left in for discussion, but is not used
File size limit for image upload based on PHP.ini flag. An image larger than this will create an error in the file handling check. Chalked up as todo
