# Design Specification: k6 Load Testing for GARENA E-Commerce System

## 1. Overview
This document specifies the design for load testing the GARENA E-Commerce Store PHP application (`DevPHP_V2`) using Grafana k6. The load test will evaluate system performance under progressive load increments of 500, 1,000, and 5,000 concurrent Virtual Users (VUs).

## 2. Load Testing Profile & Stages
The k6 test script will execute a ramping VUs profile across 7 stages:

| Stage | Target VUs | Duration | Description |
|-------|------------|----------|-------------|
| 1 | 500 | 1m | Ramp up from 0 to 500 VUs |
| 2 | 500 | 2m | Sustained load at 500 VUs |
| 3 | 1,000 | 1m | Ramp up from 500 to 1,000 VUs |
| 4 | 1,000 | 2m | Sustained load at 1,000 VUs |
| 5 | 5,000 | 2m | Ramp up from 1,000 to 5,000 VUs (Peak Stress) |
| 6 | 5,000 | 3m | Sustained peak load at 5,000 VUs |
| 7 | 0 | 1m | Ramp down to 0 VUs |

**Total Execution Time**: ~12 minutes

## 3. User Journey & Scenario Simulation
Each Virtual User will iteratively execute a full e-commerce browsing and interaction journey:

1. **Homepage Access**: `GET /index.php` (Verify 200 OK & response time)
2. **User Think Time**: `sleep(random 1-3s)`
3. **Product Search / Listing**: `GET /index.php?act=search&keyword=laptop` or `GET /index.php?act=product`
4. **Product Detail View**: `GET /index.php?act=product_detail&id=1`
5. **Cart Interaction**: `POST /index.php?act=add_to_cart` with item payload
6. **User Think Time**: `sleep(random 2-4s)`

## 4. Performance Thresholds (SLA)
- **HTTP Failure Rate (`http_req_failed`)**: `< 5%`
- **Response Time 95th Percentile (`http_req_duration` p(95))**: `< 2000ms`
- **Response Time 99th Percentile (`http_req_duration` p(99))**: `< 5000ms`

## 5. Environment & Script Artifacts
- **Script Location**: `scripts/k6_load_test.js`
- **Configuration File**: Environment configurable via `__ENV.BASE_URL` (defaulting to `http://localhost/DevPHP_V2`)
- **Execution Guide**: Documented commands for `k6 run`, summary HTML generation, and OS-specific setup (Windows PowerShell / CMD / Docker).
