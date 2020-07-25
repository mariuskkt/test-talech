<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        return view('products', ['h1' => 'Hello']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = [
            'attributes' => [
                'action' => route('products.store'),
                'class' => 'form-custom-style'
            ],
            'fields' => [
                'name' => [
                    'type' => 'text',
                    'label' => 'Product name: '
                ],
                'EAN' => [
                    'type' => 'number',
                    'value' => '',
                    'label' => 'EAN: '
                ],
                'type' => [
                    'type' => 'text',
                    'label' => 'Type: '
                ],
                'weight' => [
                    'type' => 'number',
                    'label' => 'Weight: '
                ],
                'color' => [
                    'type' => 'color',
                    'label' => 'Color: '
                ],
                'image' => [
                    'type' => 'url',
                    'label' => 'Image URL: '
                ]
            ],
            'buttons' => [
                'submit' => [
                    'title' => 'Submit'
                ]
            ]
        ];
        return view('products_create', ['h1' => 'Add a new product', 'form' => $form]);
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
        return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
