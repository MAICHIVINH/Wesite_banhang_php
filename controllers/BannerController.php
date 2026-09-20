<?php

require_once './models/Banner.php';
require_once './core/RedisCache.php';

class BannerController
{
    private $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new Banner();
    }

    public function getPositions()
    {
        return [
            'slider_main' => 'Carousel chính (Top Slider Trang chủ)',
            'side_banner' => 'Banner phụ (Bên hông Slider)',
            'middle_home' => 'Banner giữa trang chủ (Khuyến mãi)',
            'footer_banner' => 'Banner chân trang (Footer)'
        ];
    }

    public function getByPosition($position)
    {
        $active = $this->getAllActive();
        $filtered = [];
        foreach ($active as $b) {
            $pos = $b['position'] ?? 'slider_main';
            if ($pos === $position) {
                $filtered[] = $b;
            }
        }
        return $filtered;
    }

    public function getAll()
    {
        $key = 'banners:all';
        if (RedisCache::exists($key)) {
            $cached = json_decode(RedisCache::get($key), true);
            if (is_array($cached)) return $cached;
        }

        $all = $this->bannerModel->all();
        $activeBanners = [];
        foreach ($all as $b) {
            $isDel = isset($b['isDeleted']) ? (int)$b['isDeleted'] : 0;
            if ($isDel === 0) {
                $activeBanners[] = $b;
            }
        }
        RedisCache::set($key, json_encode($activeBanners));
        return $activeBanners;
    }

    private function parseStatus($val)
    {
        if ($val === null) return 1;
        if (is_numeric($val)) return (int)$val;
        if (is_string($val) && strlen($val) === 1) return ord($val);
        return (int)$val;
    }

    public function getAllActive()
    {
        $all = $this->getAll();
        $list = [];
        foreach ($all as $b) {
            $status = isset($b['status']) ? $this->parseStatus($b['status']) : 1;
            if ($status === 1) {
                $list[] = $b;
            }
        }
        return $list;
    }

    public function getById($id)
    {
        return $this->bannerModel->find($id);
    }

    public function add($data, $file = null)
    {
        $imagePath = '';

        if ($file && isset($file['tmp_name']) && $file['tmp_name'] !== '') {
            $uploadDir = './uploads/banners/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'banner_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            $target = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $imagePath = $target;
            }
        } elseif (isset($data['image_url']) && trim($data['image_url']) !== '') {
            $imagePath = trim($data['image_url']);
        }

        if ($imagePath === '') {
            return ['success' => false, 'message' => 'Vui lòng cung cấp hình ảnh hoặc URL hình ảnh.'];
        }

        $insertData = [
            'title' => trim($data['title'] ?? ''),
            'image' => $imagePath,
            'link' => trim($data['link'] ?? ''),
            'position' => trim($data['position'] ?? 'slider_main'),
            'status' => isset($data['status']) ? (int)$data['status'] : 1,
            'isDeleted' => 0
        ];

        $res = $this->bannerModel->insert($insertData);
        RedisCache::delete('banners:all');

        return [
            'success' => true,
            'message' => 'Thêm banner thành công!',
            'data' => $res
        ];
    }

    public function update($id, $data, $file = null)
    {
        $existing = $this->bannerModel->find($id);
        if (!$existing) {
            return ['success' => false, 'message' => 'Không tìm thấy banner.'];
        }

        $imagePath = $existing['image'];

        if ($file && isset($file['tmp_name']) && $file['tmp_name'] !== '') {
            $uploadDir = './uploads/banners/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'banner_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            $target = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $imagePath = $target;
            }
        } elseif (isset($data['image_url']) && trim($data['image_url']) !== '') {
            $imagePath = trim($data['image_url']);
        }

        $updateData = [
            'title' => trim($data['title'] ?? ($existing['title'] ?? '')),
            'image' => $imagePath,
            'link' => trim($data['link'] ?? ($existing['link'] ?? '')),
            'position' => trim($data['position'] ?? ($existing['position'] ?? 'slider_main')),
            'status' => isset($data['status']) ? (int)$data['status'] : (int)($existing['status'] ?? 1),
            'isDeleted' => (int)($existing['isDeleted'] ?? 0)
        ];

        $this->bannerModel->update($id, $updateData);
        RedisCache::delete('banners:all');

        return [
            'success' => true,
            'message' => 'Cập nhật banner thành công!'
        ];
    }

    public function toggleStatus($id)
    {
        $existing = $this->bannerModel->find($id);
        if (!$existing) return ['success' => false, 'message' => 'Không tìm thấy banner.'];

        $currentStatus = isset($existing['status']) ? $this->parseStatus($existing['status']) : 1;
        $newStatus = ($currentStatus === 1) ? 0 : 1;
        $this->bannerModel->update($id, ['status' => $newStatus]);
        RedisCache::delete('banners:all');

        return ['success' => true, 'message' => 'Đổi trạng thái banner thành công!'];
    }

    public function delete($id)
    {
        $this->bannerModel->updateDeleted($id);
        RedisCache::delete('banners:all');
        return ['success' => true, 'message' => 'Xóa banner thành công!'];
    }
}
