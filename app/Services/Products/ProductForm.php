<?php


namespace App\Services\Products;


class ProductForm
{
    public function create()
    {
        return $form = [
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
    }

    public function edit($product, $current_product)
    {
        return $form = [
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
    }
}
