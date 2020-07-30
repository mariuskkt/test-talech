<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
           aria-controls="nav-home" aria-selected="true">Product details</a>
        <a class="nav-item nav-link" id="nav-price-tab" data-toggle="tab" href="#nav-price" role="tab"
           aria-controls="nav-price" aria-selected="false">Price history</a>
        <a class="nav-item nav-link" id="nav-quantity-tab" data-toggle="tab" href="#nav-quantity" role="tab"
           aria-controls="nav-quantity" aria-selected="false">Quantity history</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <h1>{{$h1}}</h1>
        @table($table)
    </div>
    <div class="tab-pane fade" id="nav-price" role="tabpanel" aria-labelledby="nav-profile-tab">
        @price_graph(['price_chart'=>$price_chart])
    </div>
    <div class="tab-pane fade" id="nav-quantity" role="tabpanel" aria-labelledby="nav-contact-tab">
        @quantity_graph(['quantity_chart'=>$quantity_chart])
    </div>
</div>
