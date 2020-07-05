<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    /**
     * @var App\Product
     */
    private $product;
    /**
     * @var App\Repository\ProductRepository
     */
    private $repository;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->repository = new ProductRepository(Product::class);
    }

    public function index(Request $request)
    {
        // filtros
        if($request->has('filters') && !empty($request->filters)) {
            $products = $this->repository->filterBy($request->filters);
        }
        // especificando campos
        if($request->has('fields') && !empty($request->fields)) {
            $products = $this->repository->selectFields($request->fields);
        }
        //$products = $this->product->all();
        // return response()->json($products);
        return new ProductCollection($this->repository->get(10));
    }

    public function save(ProductRequest $request)
    {
        $data = $request->all();
        $product = $this->product->create($data);
        return response()->json($product);
    }

    public function show($id)
    {
        $product = $this->product->find($id);
        //return response()->json($product);
        return new ProductResource($product);
    }

    public function update(ProductRequest $request)
    {
        $data = $request->all();
        $product = $this->product->find($data['id']);
        $product->update($data);
        return response()->json($product);
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();
        return response()->json(['data' => ['msg' => 'Produto removido com sucesso!']]);
    }
}
