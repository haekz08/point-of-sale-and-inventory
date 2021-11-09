<?php

namespace App\Http\Controllers;

use App\Brand;
use App\LocationStartingInventory;
use App\PriceCategory;
use App\Product;
use App\ProductLocation;
use App\ProductUnit;
use App\ProductUnitPrice;
use App\Supplier;
use App\SupplierProduct;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $request;
    protected $search='';
    protected $per_page;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->per_page = isset($request->per_page) ? $request->per_page : $this->per_page;
        $this->search = isset($request->search) ? $request->search : $this->search;
    }
    public function getUserId(){
        return Auth::id();
    }
    public function all(){
        if(isset($this->request->per_page))
        {
            $data = Product::with([
                'supplier_products' => function ($query) {
                    $query->with('supplier');
                },
                'product_units' => function ($query) {
                    $query->with([
                        'product_unit_prices'=> function ($query) {
                            $query->with('price_category');
                        },
                        'unit'
                    ]);
                }
                ])
                ->where('name', 'like', '%'.$this->search.'%')
                ->paginate($this->per_page);
        }else
        {
            $search_key=$this->search;
            $data = Product::with([
                'supplier_products' => function ($query) {
                    $query->with('supplier');
                },
                'product_units' => function ($query) {
                    $query->with([
                        'product_unit_prices'=> function ($query) {
                            $query->with('price_category');
                        },
                        'unit'
                    ]);
                }
            ])
                ->when(!empty($search_key), function($query) use ($search_key){
                    $query->where('name', 'like', '%'.$search_key.'%');
                })
                ->get();
        }
        return response($data);
    }
    public function search(){
        $search_key=$this->search;
        if(isset($search_key) and !empty($search_key))
        {
            $data = Product::with([
                    'supplier_products' => function ($query) {
                        $query->with('supplier');
                    },
                    'product_units' => function ($query) {
                        $query->with([
                            'product_unit_prices'=> function ($query) {
                                $query->with('price_category');
                            },
                            'unit'
                        ]);
                    },
                    'location_starting_inventories' => function ($query) {
                        $query->with('product_location');
                    }
                ])
                ->where('name', 'like', '%'.$search_key.'%')
                ->get();
            return response($data);
        }
    }
    public function save(){
        $data = $this->request->all();

        DB::beginTransaction();
        try {
            $product_data = [
                'brand_id' => $data['brand_id'],
                'name' => $data['name'],
                'code' => $data['code'],
                'capital' => $data['capital']
            ];
            if (isset($data['id']) && $data['id'] != -1) {
                $product_data['updated_by'] = $this->getUserId();
                $this->deleteChildRecords($data['id']);
            } else {
                $product_data['created_by'] = $this->getUserId();
                $product_data['updated_by'] = $this->getUserId();
            }
            $product = Product::updateOrCreate(['id'=>$data['id']],$product_data);

            $this->insertProductUnit($product['id'],$data['default_unit']);
            if(!empty($data['product_units'])){
                foreach ($data['product_units'] as $row){
                    $this->insertProductUnit($product['id'],$row);
                }
            }
            if(!empty($data['supplier_products'])){
                foreach ($data['supplier_products'] as $row){
                    $this->insertSupplierProduct($product['id'],$row);
                }
            }DB::commit();
            return response('Success',200);
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 422);
        }
        //return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function insertProductUnit($product_id,$product_unit_data)
    {
        $data = [
            'product_id' => $product_id,
            'unit_id' => $product_unit_data['unit_id'],
            'is_base_unit' => $product_unit_data['is_base_unit'],
            'price' => $product_unit_data['price'],
            'created_by' => $this->getUserId(),
            'updated_by' => $this->getUserId()
        ];
        if(isset($product_unit_data['base_unit_qty']))
            $data['base_unit_qty'] = $product_unit_data['base_unit_qty'];
        $product_unit = ProductUnit::create($data);

        if(!empty($product_unit_data['product_unit_prices'])){
            foreach($product_unit_data['product_unit_prices'] as $row){
                $data = [
                    'product_unit_id' => $product_unit['id'],
                    'price_category_id' => $row['price_category']['id'],
                    'price' => $row['price'],
                    'created_by' => $this->getUserId(),
                    'updated_by' => $this->getUserId()
                ];
                ProductUnitPrice::create($data);
            }
        }
    }
    public function insertSupplierProduct($product_id,$supplier_product_data)
    {
        $data = [
            'product_id' => $product_id,
            'supplier_id' => $supplier_product_data['supplier_id'],
            'created_by' => $this->getUserId(),
            'updated_by' => $this->getUserId()
        ];
        SupplierProduct::create($data);
    }
    public function deleteChildRecords($product_id)
    {
        $product = Product::with([
            'supplier_products' => function ($query) {
                $query->with('supplier');
            },
            'product_units' => function ($query) {
                $query->with([
                    'product_unit_prices'=> function ($query) {
                        $query->with('price_category');
                    },
                    'unit'
                ]);
            }
        ])->find($product_id);

        $product_unit_prices_ids=[];
        $product_units_ids = $product->product_units->pluck('id');
        $supplier_products_ids = $product->supplier_products->pluck('id');
        $plucked_product_unit_prices = $product->product_units->map(function ($item, $key){
            return $item->product_unit_prices->pluck('id');
        });
        foreach($plucked_product_unit_prices as $row){
            foreach ($row as $another_row){
                array_push($product_unit_prices_ids,$another_row);
            }

        }
        ProductUnitPrice::destroy($product_unit_prices_ids);
        ProductUnit::destroy($product_units_ids);
        SupplierProduct::destroy($supplier_products_ids);
    }
    public function delete(){
        $data = $this->request->all();
        $result = Unit::find( $data['id'] );
        $result->updated_by = $this->getUserId();
        $result->save();
        $result->delete();
        return empty($result) ? response('Internal Server Error',500) : response('Successfully Deleted Record',200);
    }
    public function get(){
        $data = $this->request->all();
        $product = Product::with([
                    'supplier_products' => function ($query) {
                        $query->with('supplier');
                    },
                    'product_units' => function ($query) {
                        $query->with([
                            'product_unit_prices'=> function ($query) {
                                $query->with('price_category');
                            },
                            'unit'
                        ]);
                    },
                    'location_starting_inventories' => function ($query) {
                        $query->with('product_location');
                    }
                ])->find($data['id']);

        $brands = Brand::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        $price_categories = PriceCategory::all();
        $product_locations = ProductLocation::all();
        $result=array(
            'brands'=>$brands,
            'units'=>$units,
            'suppliers'=>$suppliers,
            'price_categories'=>$price_categories,
            'product_locations'=>$product_locations,
            'product'=>$product,
        );
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
    public function resetInventory(){
        $data = $this->request->all();
        //return $data;

//        LocationStartingInventory::where('product_id', $data['id'])
//            ->update(['updated_by' => $this->getUserId()]);
//        LocationStartingInventory::where('product_id', $data['id'])->delete();

        foreach($data['location_starting_inventories'] as $row){

            $row['created_by']=$this->getUserId();
            $row['updated_by']=$this->getUserId();
            if (isset($row['id']) && $row['id'] != -1 && $row['reset']) {
                $result = LocationStartingInventory::find($row['id']);
                $result->updated_by = $this->getUserId();
                $result->save();
                $result->delete();
            }
            if($row['reset'])
            LocationStartingInventory::create($row);
        }
    }
    public function fields(){
        $brands = Brand::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        $price_categories = PriceCategory::all();
        $product_locations = ProductLocation::all();
        $result=array(
            'brands'=>$brands,
            'units'=>$units,
            'suppliers'=>$suppliers,
            'price_categories'=>$price_categories,
            'product_locations'=>$product_locations,
        );
        return empty($result) ? response('Internal Server Error',500) : response($result,200);
    }
}
