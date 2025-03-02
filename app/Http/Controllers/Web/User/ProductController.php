<?php

namespace App\Http\Controllers\Web\User;

use App\Enums\ProductStatus;
use App\Enums\Tagtype;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $userProducts = QueryBuilder::for(Product::class)
            ->where('user_id', $userId)
            ->allowedFilters([
                'name',
            ])
            ->with(['media', 'user', 'tags'])
            ->orderBy('updated_at', 'desc')
            ->paginate(3)
            ->withQueryString();

        return view('user.products.index', compact('userProducts'));
    }

    public function create()
    {
        $tags = Tag::whereIn('type', [Tagtype::Grade, Tagtype::Semester, Tagtype::Subject, Tagtype::Category])->get();

        return view('user.products.create', ['tags' => $tags]);
    }

    public function store(Request $request)
    {
        // 基本驗證規則
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999'],
            'description' => ['required', 'string', 'max:50'],
            'grade' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Grade)],
            'semester' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Semester)],
            'subject' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Subject)],
            'category' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Category)],
            'encrypted_image_path' => ['required', 'array'],
            'encrypted_image_path.*' => ['required', 'string'],
        ];

        // 驗證
        $validated = $request->validate($rules, trans('product'));

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
        ]);

        if ($request->has('encrypted_image_path')) {
            // 取出所有加密的圖片路徑
            $encryptedPaths = $request->input('encrypted_image_path');

            // 遍歷所有的加密圖片
            foreach ($encryptedPaths as $encryptedPath) {
                // 解密圖片路徑
                $decryptedImagePath = 'temp/'.decrypt($encryptedPath);

                // 讀取圖片內容
                $fileContent = Storage::disk('local')->get($decryptedImagePath);

                // 生成新路徑
                $newImagePath = 'images/compressed_'.uniqid().'.jpg';

                // 存儲圖片到 public 目錄
                Storage::disk('public')->put($newImagePath, $fileContent);

                // 將圖片添加到媒體庫
                $product->addMedia(storage_path("app/public/{$newImagePath}"))->toMediaCollection('images');

                // 刪除臨時圖片
                Storage::disk('local')->delete($decryptedImagePath);
            }
        }

        // 獲取並附加新的標籤
        $tagIds = [
            $request->input('grade'),
            $request->input('semester'),
            $request->input('subject'),
            $request->input('category'),
        ];

        // 同步標籤到產品
        $product->tags()->sync($tagIds);

        return redirect()->route('user.products.create')->with('success', '產品已成功創建！');
    }

    public function edit(Request $request, Product $product)
    {
        abort_unless($product->user_id == auth()->id(), 403, '您無權編輯此商品。');

        $productTags = $product->tags;
        $gradeTag = $productTags->where('type', Tagtype::Grade)->first();
        $semesterTag = $productTags->where('type', Tagtype::Semester)->first();
        $subjectTag = $productTags->where('type', Tagtype::Subject)->first();
        $categoryTag = $productTags->where('type', Tagtype::Category)->first();
        $tags = Tag::get();

        return view('user.products.edit', compact('product', 'tags', 'gradeTag', 'semesterTag', 'categoryTag', 'subjectTag'));
    }

    public function update(Request $request, Product $product)
    {
        abort_unless($product->user_id == auth()->id(), 403, '您無權編輯此商品。');

        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:50'],
            'grade' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Grade)],
            'semester' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Semester)],
            'subject' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Subject)],
            'category' => ['required', Rule::exists('tags', 'id')->where('type', Tagtype::Category)],
            'encrypted_image_path' => ['nullable', 'array'],
            'encrypted_image_path.*' => ['required', 'string'],
            'image_ids' => ['nullable', 'array', 'max:5'],
            'deleted_image_ids' => ['nullable', 'string'],
        ];

        $request->validate($rules, trans('product'));

        $deletedImageIds = json_decode($request->input('deleted_image_ids', '[]'), true);
        $existingImages = $product->getMedia('images');

        // 刪除標記為刪除的圖片
        $existingImages->whereIn('id', $deletedImageIds)->each(function ($image) use ($product) {
            if ($image->model_id === $product->id) {
                $image->delete();
            }
        });

        // 更新產品資料
        $product->update($request->only(['name', 'description']));

        if ($request->has('encrypted_image_path')) {
            foreach ($request->input('encrypted_image_path') as $encryptedPath) {
                try {
                    $decryptedImagePath = 'temp/'.decrypt($encryptedPath);
                    if (Storage::disk('local')->exists($decryptedImagePath)) {
                        $fileContent = Storage::disk('local')->get($decryptedImagePath);
                        $newImagePath = 'images/compressed_'.uniqid().'.jpg';
                        Storage::disk('public')->put($newImagePath, $fileContent);
                        $product->addMedia(storage_path("app/public/{$newImagePath}"))->toMediaCollection('images');
                        Storage::disk('local')->delete($decryptedImagePath);
                    } else {
                        \Log::error("解密後的圖片不存在：{$decryptedImagePath}");
                    }
                } catch (\Exception $e) {
                    \Log::error('圖片處理失敗：'.$e->getMessage());
                }
            }
        }

        // 更新圖片順序
        $imageIds = $request->input('image_ids', []);
        foreach ($product->getMedia('images') as $image) {
            if (($index = array_search($image->id, $imageIds)) !== false) {
                $image->setCustomProperty('order_column', $index + 1);
                $image->save();
            }
        }

        // 更新標籤
        $tagIds = [
            $request->input('grade'),
            $request->input('semester'),
            $request->input('subject'),
            $request->input('category'),
        ];
        $product->tags()->sync($tagIds);
        $product->save();

        return redirect()->route('user.products.index')->with('success', '商品更新成功！');
    }

    public function destroy(Product $product)
    {
        // 軟刪除產品，保留記錄但標記為已刪除
        $product->delete();

        // 重新導向到產品清單頁面，並標註成功訊息
        return redirect()->route('user.products.index')->with('success', '產品已成功刪除');
    }

    public function inactive(Product $product)
    {
        // 根據當前狀態切換到相反的狀態
        $newStatus = $product->status === ProductStatus::Active
            ? ProductStatus::Inactive
            : ProductStatus::Active;

        // 更新商品的狀態
        $product->update([
            'status' => $newStatus,
        ]);

        $message = "商品{$newStatus->name()}！";

        return redirect()->route('user.products.index')->with('success', $message);
    }
}
