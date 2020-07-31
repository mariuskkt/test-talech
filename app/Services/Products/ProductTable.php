<?php


namespace App\Services\Products;


use App\Product;

class ProductTable
{
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

        return $table;
    }

    public function show($product)
    {
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

        return $table;
    }
}
