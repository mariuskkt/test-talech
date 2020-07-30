<?php

namespace App\Http\Controllers;

use App\Charts\PriceChart;
use App\Charts\PriceHistoryChart;
use App\PriceQuantityHistory;
use App\Product;
use App\Http\Requests\ProductRequest;
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
                'quantity' => [
                    'type' => 'number',
                    'label' => 'Quantity: '
                ],
                'price' => [
                    'type' => 'number',
                    'label' => 'Price: '
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
                    'id', 'name', 'EAN', 'type', 'weight', 'quantity', 'price', 'color', 'image'
                ],
            'rows' =>
                [
                    [
                        $product->id,
                        $product->name,
                        $product->EAN,
                        $product->type,
                        $product->weight,
                        $product->quantity,
                        $product->price,
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

        $price_history = PriceQuantityHistory::where('product_id', $product->id)->pluck('updated_at', 'price');

        $up_to_90days_old = [];

        foreach ($price_history as $price => $date) {

            $now = new \DateTime(now());
            $editing_day = new \DateTime($date);
            $difference = $editing_day->diff($now);
            if ($difference->days < 90) {
                $up_to_90days_old[$price] = $date;
                asort($up_to_90days_old);
            }
        }

        $price_chart = new PriceHistoryChart;
        $price_chart->labels(array_values($up_to_90days_old));
        $price_chart->dataset('Price history of the last 90 days', 'line', array_keys($up_to_90days_old));

        $quantity_history = PriceQuantityHistory::where('product_id', $product->id)->pluck('updated_at', 'quantity');

        $up_to_90days_old = [];

        foreach ($quantity_history as $quantity => $date) {

            $now = new \DateTime(now());
            $editing_day = new \DateTime($date);
            $difference = $editing_day->diff($now);
            if ($difference->days < 90) {
                $up_to_90days_old[$quantity] = $date;
                asort($up_to_90days_old);
            }
        }

        $quantity_chart = new PriceHistoryChart;
        $quantity_chart->labels(array_values($up_to_90days_old));
        $quantity_chart->dataset('Quantity history of the last 90 days', 'line', array_keys($up_to_90days_old));


        return view('products_show', [
            'h1' => 'Details of product #' . $product->id,
            'title' => 'History',
            'table' => $table,
            'price_chart' => $price_chart,
            'quantity_chart' => $quantity_chart,
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
                'quantity' => [
                    'type' => 'number',
                    'value' => $current_product->quantity,
                    'label' => 'Quantity: '
                ],
                'price' => [
                    'type' => 'number',
                    'value' => $current_product->price,
                    'label' => 'Price: '
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
//        dd($product->updated_at);
//        DB::table('table')->insertGetId(array(
//            'price'=>$request->input('price')
//        ));
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
