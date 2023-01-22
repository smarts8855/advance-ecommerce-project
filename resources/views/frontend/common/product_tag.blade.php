@php
$tag_en = App\Models\Product::groupBy('product_tag_en')->select('product_tag_en')->get();
$tag_hin = App\Models\Product::groupBy('product_tag_hin')->select('product_tag_hin')->get();


@endphp


<div class="sidebar-widget product-tag wow fadeInUp">
          <h3 class="section-title">Product tags</h3>
          <div class="sidebar-widget-body outer-top-xs">
            <div class="tag-list">
            @if(session()->get('language') == 'hindi')

            @foreach($tag_hin as $tag)
            <a class="item active" title="Phone" href="{{ url('product/tag/'.$tag->product_tag_hin) }}">{{ str_replace(',',' ',$tag->product_tag_hin)  }}</a>
            @endforeach

            @else

            @foreach($tag_en as $tag)
            <a class="item active" title="Phone" href="{{ url('product/tag/'.$tag->product_tag_en) }}">{{ str_replace(',',' ',$tag->product_tag_en) }}</a>
            @endforeach

            @endif 
                
            </div>
            <!-- /.tag-list --> 
          </div>
          <!-- /.sidebar-widget-body --> 
        </div>
        <!-- /.sidebar-widget --> 