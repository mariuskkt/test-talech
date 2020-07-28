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
        $products = Product::all()->sortBy('id');

        $table = [
            'attr' => [
                'class' => 'product_index_table'
            ],
            'header' =>
                [
                    'id', 'name', 'EAN'
                ],
            'rows' =>
                [
                ]
        ];
        foreach ($products as $product) {
            $table['rows'][] = [
                $product->id,
                $product->name,
                $product->EAN,
                view('components/a', [
                    'href' => route('products.show', $product->id),
                    'name' => 'Details'
                ]),
//                $product->type,
//                $product->weight,
//                view('components/color_container', ['color' => $product->color]),
//                view('components/img', ['class' => 'index-table-img', 'src' => $product->image]),
                view('components/a', [
                    'href' => route('products.edit', $product->id),
                    'name' => 'EDIT'
                ]),
                view('components/form', [
                    'attributes' => [
                        'action' => route('products.destroy', $product->id)
                    ],
                    'fields' => [
                        '_method' => [
                            'type' => 'hidden',
                            'value' => 'DELETE'
                        ]
                    ],
                    'buttons' => [
                        'delete' => [
                            'title' => 'Delete'
                        ]
                    ]
                ])
            ];
        }
        return view('products', ['h1' => 'List of products', 'table' => $table]);
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
     * @param Product $product
     * @return Response
     */
    public function show($id)
    {
        $product = Product::withTrashed()->where('id', $id)->first();
        $table = [
            'attr' => [
                'class' => 'product_index_table'
            ],
            'header' =>
                [
                    'id', 'name', 'EAN', 'type', 'weight', 'color', 'image'
                ],
            'rows' =>
                [
                    [
                        $product->id,
                        $product->name,
                        $product->EAN,
                        $product->type,
                        $product->weight,
                        view('components/color_container', ['color' => $product->color]),
                        view('components/img', ['class' => 'index-table-img', 'src' => $product->image]),
                        view('components/a', [
                            'href' => route('products.edit', $product->id),
                            'name' => 'EDIT'
                        ]),
                        view('components/form', [
                            'attributes' => [
                                'action' => route('products.destroy', $product->id)
                            ],
                            'fields' => [
                                '_method' => [
                                    'type' => 'hidden',
                                    'value' => 'DELETE'
                                ]
                            ],
                            'buttons' => [
                                'delete' => [
                                    'title' => 'Delete'
                                ]
                            ]
                        ])
                    ]
                ]
        ];

        return view('products', ['h1' => 'Details of product #' . $product->id, 'table' => $table]);
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

        $form = [
            'attributes' => [
                'action' => route('products.update', $product->id),
                'class' => 'form-custom-style'
            ],
            'fields' => [
                'name' => [
                    'type' => 'text',
                    'value' => $current_product->name,
                    'label' => 'Product name: '
                ],
                'EAN' => [
                    'type' => 'number',
                    'value' => $current_product->EAN,
                    'label' => 'EAN: '
                ],
                'type' => [
                    'type' => 'text',
                    'value' => $current_product->type,
                    'label' => 'Type: '
                ],
                'weight' => [
                    'type' => 'number',
                    'value' => $current_product->weight,
                    'label' => 'Weight: '
                ],
                'color' => [
                    'type' => 'color',
                    'value' => $current_product->color,
                    'label' => 'Color: '
                ],
                'image' => [
                    'type' => 'url',
                    'value' => $current_product->image,
                    'label' => 'Image URL: '
                ],
                '_method' => [
                    'type' => 'hidden',
                    'value' => 'PUT'
                ]
            ],
            'buttons' => [
                'submit' => [
                    'title' => 'Submit'
                ]
            ]
        ];

        return view('products_create', ['h1' => 'Edit chosen product', 'form' => $form]);
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
        $product->color = $request->input('color');
        $product->image = $request->input('image');
        $product->save();
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

    public function hard_delete()
    {
        dd('destroy');
    }
}
