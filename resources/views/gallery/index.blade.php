@extends('layouts.layout')

@section('content')
<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <div id="caption"></div>
  <img class="modal-content" id="img01">
  <div id="description"></div>
</div>

<div class="grid flex-center" >
    @foreach ($images as $image)
        <img id="{{ $image->id }}" class="asset" src="{{ asset($image->url) }}" alt="{{ $image->alttext }}" />
        <!-- <div class="overlay">
            <div>
                <h3>{{ $image->caption }}</h3>
                <img src="{{ asset('/uploads/' . $image->name) }}" alt="{{ $image->alttext }}"/>
                <p>{{ $image->description }}</p>
            </div>
        </div> -->
        <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById({{ $image->id }});
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            var descriptionText = document.getElementById("description");
            img.onclick = function(){
                modal.style.display = "block";
                //modalImg.src = this.src;
                modalImg.src = "{{ asset('/uploads/' . $image->name) }}";
                modalImg.alt = "{{ $image->alttext }}";
                //captionText.innerHTML = this.alt;
                captionText.innerHTML = "{{ $image->caption }}";
                descriptionText.innerHTML = "{{ $image->description }}";
            }

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() { 
                modal.style.display = "none";
            }
            </script>
    @endforeach
</div>
@endsection()