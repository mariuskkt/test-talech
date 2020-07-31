<?php

namespace App\Http\Controllers;

use App\Charts\PriceHistoryChart;
use App\PriceQuantityHistory;
use App\Product;
use App\Http\Requests\ProductRequest;
use App\Services\DisplayChart;
use App\Services\Products\ProductForm;
use App\Services\Products\ProductTable;
use Illuminate\Http\Response;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $table = new ProductTable();

        return view('products', ['h1' => 'List of products', 'table' => $table->index()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = new ProductForm();

        return view('products_create', ['h1' => 'Add a new product', 'form' => $form->create()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product($request->all());
        $product->save();

        $history = new PriceQuantityHistory();
        $history->product_id = $product->id;
        $history->price = $product->price;
        $history->quantity = $product->quantity;
        $history->created_at = date('Y-m-d H:i:s');
        $history->updated_at = date('Y-m-d H:i:s');
        $history->save();
        return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     * @throws \Exception
     */
    public function show($id)
    {
        $product = Product::withTrashed()->where('id', $id)->first();

        $table = new ProductTable();

        $price_chart = new DisplayChart();

        $quantity_chart = new DisplayChart();

        return view('products_show', [
            'h1' => 'Details of product #' . $product->id,
            'title' => 'History',
            'table' => $table->show($product),
            'price_chart' => $price_chart->priceChart($product),
            'quantity_chart' => $quantity_chart->quantityChart($product),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function edit(Product $product)
    {
        $current_product = Product::find($product->id);

        $form = new ProductForm();

        return view('products_create', ['h1' => 'Edit chosen product', 'form' => $form->edit($product, $current_product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->name = $request->input('name');
        $product->EAN = $request->input('EAN');
        $product->type = $request->input('type');
        $product->weight = $request->input('weight');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->color = $request->input('color');
        $product->image = $request->input('image');
        $product->save();

        $history = new PriceQuantityHistory();
        $history->product_id = $product->id;
        $history->price = $request->input('price');
        $history->quantity = $request->input('quantity');
        $history->updated_at = date('Y-m-d H:i:s');
        $history->save();

        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('products');
    }
}
