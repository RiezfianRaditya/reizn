<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function all(request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            $product = ProductCategory::with(['products'])->find($id);

            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data Kategori Berhasil Diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Kategori Tidak Ada',
                    404
                );
            }
        }
        $category = ProductCategory::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data List Kategori Berhasil Diambil'
        );
    }
}
