@extends('layouts.layout')

@section('content')
<form action="{{ action('ImageController@store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div >
        <label>Please choose an image to upload</label>
        <br />
        <input type="file" name="fileToUpload" id="fileToUpload"/>
    </div>

    <div class="grid flex-center">
        <textarea name="caption" placeholder="Enter a caption"></textarea>
        <textarea name="description" placeholder="Enter a discription"></textarea>
        <textarea name="alttext" placeholder="Enter some alt text..."></textarea>
    </div>

    <div class="submit">
        <input type="submit" value="Upload Image" name="submit" />
    </div>
</form>
@endsection()