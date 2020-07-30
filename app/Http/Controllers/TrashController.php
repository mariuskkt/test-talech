<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'restore':
                $this->restore_product($request->input('field_value'));
                break;
            case 'delete':
                $this->hard_delete($request->input('field_value'));
                break;
        }
        
        $trash = Product::onlyTrashed()->get();

        $table = [
            'attr' => [
                'class' => 'product_index_table'
            ],
            'header' =>
                [
                    'id', 'name', 'type'
                ],
            'rows' =>
                [
                ]
        ];

        foreach ($trash as $trash_item) {
            $table['rows'][] = [
                $trash_item->id,
                $trash_item->name,
                $trash_item->type,
                view('components/a', [
                    'href' => route('products.show', $trash_item->id),
                    'name' => 'Details'
                ]),
                view('components/form', [
                    'attributes' => [
                    ],
                    'fields' => [
                        '_method' => [
                            'type' => 'hidden',
                            'value' => 'GET'
                        ],
                        'field_value' => [
                            'type' => 'hidden',
                            'value' => $trash_item->id
                        ]
                    ],
                    'buttons' => [
                        'delete' => [
                            'title' => 'Delete'
                        ]
                    ]
                ]),
                view('components/form', [
                    'attributes' => [
                    ],
                    'fields' => [
                        '_method' => [
                            'type' => 'hidden',
                            'value' => 'GET'
                        ],
                        'field_value' => [
                            'type' => 'hidden',
                            'value' => $trash_item->id
                        ]
                    ],
                    'buttons' => [
                        'restore' => [
                            'title' => 'Restore'
                        ],
                    ]
                ])
            ];
        }


        return view('trash', ['h1' => 'Delete permanently/restore', 'table' => $table]);
    }

    public function restore_product($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->first();
        $product->restore();
    }

    public function hard_delete($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->first();
        $product->forceDelete();
    }
}
