@extends(Helper::setExtendFrontend())
@section('content')
<hr>
<article class="post-single">
   
    <div class="post-details container">
        
        <h4 class="post-title"><a href="{{ route('page', ['slug' => $data->marketing_page_slug]) }}">{{ $data->marketing_page_name }}</a></h4>
       
        <div class="post-body mb-7">

            {!! $data->marketing_page_description !!}
            
        </div>
       
      
    </div>
</article>

@endsection