<?php

declare(strict_types=1);

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\Brand;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Milon\Barcode\Facades\DNS1DFacade;
use PDF;
use App\Models\Category;


class Barcode extends Component
{
    use LivewireAlert;

    public $brands;
    public $selectedBrandId;
    public $products = [];
    public $barcodes = [];
    public $paperSize = 'A4';
    public $categories;
    public $selectedCategoryId;


    protected $listeners = ['productSelected'];

    protected $rules = [
        'products.*.barcodeSize' => 'required|in:small,medium,large,extra,huge',
    ];

    public function updatedSelectedBrandId($value)
    {
        $this->emit('brandSelected', $this->selectedBrandId);
    }

    public function productSelected($productId)
    {
        $brand = Brand::find($this->selectedBrandId);

        if ($brand) {
            $products = $brand->products;
            dd($products);

            // Add the related products to the $products array
            foreach ($products as $product) {
                array_push($this->products, [
                    'id'                => $product->id,
                    'name'              => $product->name,
                    'code'              => $product->code,
                    'price'             => $product->price,
                    'quantity'          => 1,
                    'barcode_symbology' => $product->barcode_symbology,
                    'barcodeSize'       => 1,
                ]);
            }
        }
    }


    public function generateBarcodes()
    {
        if (empty($this->products)) {
            $this->alert('error', __('Please select at least one product to generate barcodes!'));

            return;
        }

        $this->barcodes = [];

        foreach ($this->products as  $product) {
            $quantity = $product['quantity'];
            $name = $product['name'];
            $price = $product['price'];
            $c=$product['price'].$product['name'].$product['quantity'];

            if ($quantity > 100) {
                $this->alert('error', __('Max quantity is 100 per barcode generation for product :name!', ['name' => $name]));

                continue;
            }

            for ($i = 0; $i < $quantity; $i++) {
                $barcode = DNS1DFacade::getBarCodeSVG($product['code'], $product['barcode_symbology'], $product['barcodeSize'], 60, 'black', false);

                array_push($this->barcodes, ['barcode' => $barcode, 'name' => $name, 'price' => $price, 'c' => $c]);
            }
        }
    }

    public function downloadBarcodes()
    {
        $data = [
            'barcodes' => $this->barcodes,
        ];

        $stylesheet = file_get_contents(public_path('print/bootstrap.min.css'));

        $pdf = PDF::loadView('admin.barcode.print', $data, [
            'format' => $this->paperSize,
        ]);

        $pdf->getMpdf()->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

        return $pdf->download('barcodes-'.date('Y-m-d').'.pdf');
    }

    public function deleteProduct($productId)
    {
        $index = null;

        foreach ($this->products as $key => $product) {
            if ($product['id'] === $productId) {
                $index = $key;

                break;
            }
        }

        if ( ! is_null($index)) {
            unset($this->products[$index]);
            $this->products = array_values($this->products); // Reset array keys
        }
    }

    //public function getWarehousesProperty()
    //{
     //   return Warehouse::pluck('name', 'id')->toArray();
    //}


    public function getBrandsProperty()
{
    // Assuming you have a Brand model, adjust this based on your actual model and data structure
    return Brand::pluck('name', 'id')->toArray();
}
public function render()
    {
        $this->brands = $this->getBrandsProperty();
    $this->categories = $this->getCategoriesProperty(); // Make sure this method is defined
    $brandOptions = $this->brands;
    $categoryOptions = $this->categories;

    return view('livewire.products.barcode', compact('brandOptions', 'categoryOptions'));
        $this->brands = $this->getBrandsProperty(); // Make sure getBrandsProperty is still relevant for products
        $options = $this->brands;

        return view('livewire.products.barcode', compact('options'));
    }
}

