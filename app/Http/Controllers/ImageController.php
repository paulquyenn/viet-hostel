<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('images');
        $resource = QueryBuilder::for(Image::class)
            ->allowedSorts($columns)
            ->allowedFilters($columns)
            ->paginate()
            ->appends($request->query());

        return view('image.index', [
            'images' => ImageResource::collection($resource)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('image.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        try {
            $disk_name = 'public';
            $folder = 'upload';
            $files = $request->file('file');
            $image = [];

            foreach ($files as $file) {
                try {
                    // Lấy extension gốc của file
                    $originalExtension = strtolower($file->getClientOriginalExtension());

                    // Kiểm tra định dạng file hợp lệ
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($originalExtension, $allowedExtensions)) {
                        continue;
                    }

                    // Tạo tên file ngẫu nhiên - giữ nguyên extension nếu GD không hoạt động
                    $extension = extension_loaded('gd') ? 'jpg' : $originalExtension;
                    $filename = uniqid('img_') . '.' . $extension;
                    $path = $folder . '/' . $filename;

                    // Tối ưu hình ảnh trước khi lưu
                    $optimizedImageData = $this->optimizeImage($file);
                    Storage::disk($disk_name)->put($path, $optimizedImageData);

                    // Tính kích thước file sau khi tối ưu
                    $fileSize = Storage::disk($disk_name)->size($path);

                    // Xác định MIME type
                    $mimeType = extension_loaded('gd') ? 'image/jpeg' : $file->getMimeType();

                    $data = [
                        'path' => $path,
                        'name' => $file->getClientOriginalName(),
                        'size' => $fileSize,
                        'type' => $mimeType,
                        'isMain' => $request->input('isMain', 0)
                    ];

                    $img = Image::create($data);

                    $image[] = $img;

                    // Nếu có room_id, tạo liên kết ngay
                    if ($request->filled('room_id')) {
                        try {
                            $room_id = $request->room_id;

                            $roomImage = \App\Models\RoomImage::create([
                                'room_id' => $room_id,
                                'image_id' => $img->id
                            ]);

                        } catch (\Exception $e) {
                            // Có thể thêm xử lý lỗi ở đây nếu cần
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            return response()->json([
                'data' => $image,
                'message' => 'Tải ảnh lên thành công'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi tải ảnh lên'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return view('image.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        return view('image.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        try {
            // Xóa file từ storage
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            // Xóa bản ghi trong database
            $image->delete();

            return response()->json([
                'message' => 'Đã xóa ảnh thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi xóa ảnh'
            ], 500);
        }
    }

    /**
     * Tối ưu hình ảnh trước khi lưu sử dụng PHP GD library hoặc copy trực tiếp
     */
    protected function optimizeImage($file)
    {
        // Kiểm tra xem GD extension có được kích hoạt không
        if (!extension_loaded('gd')) {
            return file_get_contents($file->getRealPath());
        }

        try {
            // Đọc file upload
            $imageInfo = getimagesize($file->getRealPath());

            if (!$imageInfo) {
                return file_get_contents($file->getRealPath());
            }

            // Tạo image resource từ file dựa trên MIME type
            switch ($imageInfo['mime']) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($file->getRealPath());
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($file->getRealPath());
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($file->getRealPath());
                    break;
                case 'image/webp':
                    if (function_exists('imagecreatefromwebp')) {
                        $sourceImage = imagecreatefromwebp($file->getRealPath());
                    } else {
                        return file_get_contents($file->getRealPath());
                    }
                    break;
                default:
                    return file_get_contents($file->getRealPath());
            }

            if (!$sourceImage) {
                return file_get_contents($file->getRealPath());
            }

            $originalWidth = imagesx($sourceImage);
            $originalHeight = imagesy($sourceImage);

            // Giới hạn kích thước tối đa
            $maxWidth = 2048;
            $maxHeight = 2048;

            // Tính toán kích thước mới nếu cần resize
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;

            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                $aspectRatio = $originalWidth / $originalHeight;

                if ($originalWidth > $originalHeight) {
                    $newWidth = $maxWidth;
                    $newHeight = intval($maxWidth / $aspectRatio);
                } else {
                    $newHeight = $maxHeight;
                    $newWidth = intval($maxHeight * $aspectRatio);
                }
            } else {
                // Nếu không cần resize, sử dụng file gốc
                imagedestroy($sourceImage);
                return file_get_contents($file->getRealPath());
            }

            // Tạo canvas mới với kích thước đã tính toán
            $optimizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Giữ trong suốt cho PNG
            if ($imageInfo['mime'] === 'image/png') {
                imagealphablending($optimizedImage, false);
                imagesavealpha($optimizedImage, true);
                $transparent = imagecolorallocatealpha($optimizedImage, 255, 255, 255, 127);
                imagefill($optimizedImage, 0, 0, $transparent);
            } else {
                // Đặt nền trắng cho các định dạng khác
                $white = imagecolorallocate($optimizedImage, 255, 255, 255);
                imagefill($optimizedImage, 0, 0, $white);
            }

            // Resize image
            imagecopyresampled(
                $optimizedImage, $sourceImage,
                0, 0, 0, 0,
                $newWidth, $newHeight,
                $originalWidth, $originalHeight
            );

            // Chuyển đổi thành JPEG và lưu vào buffer
            ob_start();
            imagejpeg($optimizedImage, null, 85); // Chất lượng 85%
            $imageData = ob_get_contents();
            ob_end_clean();

            // Giải phóng memory
            imagedestroy($sourceImage);
            imagedestroy($optimizedImage);

            return $imageData;

        } catch (\Exception $e) {
            // Trường hợp có lỗi, trả về file gốc
            return file_get_contents($file->getRealPath());
        }
    }

    /**
     * Dọn dẹp các ảnh không được sử dụng
     */
    public function cleanupUnusedImages()
    {
        try {
            // Tìm các ảnh không có liên kết với phòng nào
            $unusedImages = Image::doesntHave('roomImage')
                ->where('created_at', '<', now()->subHours(24))
                ->get();

            $count = 0;
            foreach ($unusedImages as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
                $count++;
            }

            return response()->json([
                'message' => "Đã xóa $count ảnh không sử dụng"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi dọn dẹp ảnh không sử dụng'
            ], 500);
        }
    }
}
