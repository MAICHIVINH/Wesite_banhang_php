import http from 'k6/http';
import { check, sleep, group } from 'k6';
import { Rate, Trend } from 'k6/metrics';
import exec from 'k6/execution';

// Custom Metrics
const errorRate = new Rate('custom_error_rate');
const registrationDuration = new Trend('registration_duration');
const loginDuration = new Trend('login_duration');
const inventoryCheckDuration = new Trend('inventory_check_duration');
const checkoutDuration = new Trend('checkout_duration');
const orderSuccessRate = new Rate('order_success_rate');

export const options = {
  stages: [
    { duration: '30s', target: 50 },   // Khởi động 50 VUs
    { duration: '1m',  target: 200 },  // Tăng lên 200 VUs
    { duration: '3m',  target: 200 },  // Duy trì 200 VUs đặt hàng đồng thời
    { duration: '30s', target: 0 },    // Ramp down về 0 VUs
  ],
  thresholds: {
    http_req_failed: ['rate<0.05'],       // Tỷ lệ lỗi HTTP < 5%
    http_req_duration: ['p(95)<2000'],    // 95% số request < 2000ms
    custom_error_rate: ['rate<0.05'],
  },
};

const BASE_URL = __ENV.BASE_URL || 'http://localhost/DevPHP_V2';

export default function () {
  // Tạo email và sđt độc nhất cho mỗi lượt chạy người dùng ảo
  const vuId = exec.vu.idInTest;
  const iterId = exec.scenario.iterationInTest;
  const timestamp = Date.now();
  
  const testUser = {
    fullname: `Khách hàng k6 ${vuId}`,
    email: `k6_buyer_${vuId}_${iterId}_${timestamp}@test.com`,
    phone: `09${Math.floor(10000000 + Math.random() * 90000000)}`,
    address: '123 Đường Tôn Đức Thắng, Quận 1, TP.HCM',
    password: 'Password123!',
  };

  const formHeaders = {
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
  };

  // ID Sản phẩm có sẵn dữ liệu và tồn kho trong Database (ID: 36, 27, 37)
  const productId = '36'; 
  const productName = 'MacBook Pro 16 M4 Max 2024';
  const productPrice = '93790000';

  // Bước 1: Đăng ký tài khoản người dùng
  group('01_Register', function () {
    const payload = {
      register: '1',
      fullname: testUser.fullname,
      email: testUser.email,
      phone: testUser.phone,
      address: testUser.address,
      password: testUser.password,
    };

    const res = http.post(`${BASE_URL}/index.php`, payload, formHeaders);
    const success = check(res, {
      'register status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
    registrationDuration.add(res.timings.duration);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // Think time 1-2s

  // Bước 2: Đăng nhập vào hệ thống
  group('02_Login', function () {
    const payload = {
      login: '1',
      email: testUser.email,
      password: testUser.password,
    };

    const res = http.post(`${BASE_URL}/index.php`, payload, formHeaders);
    const success = check(res, {
      'login status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
    loginDuration.add(res.timings.duration);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // Think time 1-2s

  // Bước 3: Duyệt Trang chủ (HomePage)
  group('03_HomePage', function () {
    const res = http.get(`${BASE_URL}/index.php`);
    const success = check(res, {
      'home status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // Think time 1-2s

  // Bước 4: Tìm kiếm sản phẩm
  group('04_SearchProduct', function () {
    const res = http.get(`${BASE_URL}/index.php?act=product&keyword=MacBook`);
    const success = check(res, {
      'search status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // Think time 1-2s

  // Bước 5: Xem chi tiết sản phẩm & Kiểm tra tồn kho tại các kho hàng/chi nhánh
  let productInStock = false;

  group('05_ProductDetail_InventoryCheck', function () {
    const res = http.get(`${BASE_URL}/index.php?subpage=modules/Users/page/Detail.php&id=${productId}`);
    
    // Kiểm tra xem sản phẩm có tồn kho trong DB hay không
    const hasInventory = res.body && !res.body.includes('HẾT HÀNG TẠI TẤT CẢ CỬA HÀNG') && res.body.includes('Còn');
    productInStock = hasInventory || (res.body && res.body.includes('THÊM VÀO GIỎ HÀNG'));

    const success = check(res, {
      'detail status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
    inventoryCheckDuration.add(res.timings.duration);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // Think time 1-2s

  // Bước 6: Thêm sản phẩm vào giỏ hàng
  group('06_AddToCart', function () {
    const payload = {
      addCart: '1',
      id: productId,
      name: productName,
      price: productPrice,
      image: 'uploads/product.jpg',
    };

    const res = http.post(`${BASE_URL}/index.php?subpage=modules/Users/page/Cart.php`, payload, formHeaders);
    const success = check(res, {
      'add to cart status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // Think time 1-2s

  // Bước 7: Đặt hàng - Chọn phương thức Thanh toán khi nhận hàng (COD)
  group('07_Checkout_COD', function () {
    const payload = {
      action: 'checkout',
      'selected[]': productId,
      branch_id: '1',                  // Chọn Chi nhánh 1
      payment_method: 'cod',           // Thanh toán khi nhận hàng (COD)
      note: 'Đơn hàng mô phỏng k6 load test',
    };

    const res = http.post(`${BASE_URL}/index.php?subpage=modules/Users/page/Cart.php`, payload, formHeaders);
    const isSuccess = res.status === 200 && res.body.includes('Mua hàng thành công');

    const success = check(res, {
      'checkout COD status is 200': (r) => r.status === 200,
      'order recorded in database': () => isSuccess,
    });

    errorRate.add(!success);
    orderSuccessRate.add(isSuccess);
    checkoutDuration.add(res.timings.duration);
  });

  sleep(Math.floor(Math.random() * 3) + 2); // Think time 2-5s
}
