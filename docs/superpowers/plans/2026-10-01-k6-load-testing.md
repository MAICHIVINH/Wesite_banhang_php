# k6 Load Testing Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Create a complete Grafana k6 load test script (`scripts/k6_load_test.js`) simulating full e-commerce user journeys with 500, 1000, and 5000 concurrent Virtual Users, along with execution documentation.

**Architecture:** A standalone JavaScript load test script utilizing `k6/http`, `k6/metrics`, and `k6` modules. It defines multi-stage VU ramping schedules, HTTP requests with checks, user think times, and summary report output.

**Tech Stack:** JavaScript (k6 ES6 module style), k6 load testing engine, HTML/JSON summary generation.

## Global Constraints
- Target URL: `http://localhost/DevPHP_V2` (overrideable via `__ENV.BASE_URL`)
- Ramping Stages: 500 VUs -> 1000 VUs -> 5000 VUs
- Failure threshold: `http_req_failed < 0.05` (less than 5% error rate)
- Response duration threshold: `http_req_duration p(95) < 2000` (95% under 2s)

---

### Task 1: Create the k6 Load Testing Script

**Files:**
- Create: `scripts/k6_load_test.js`

**Interfaces:**
- Consumes: `__ENV.BASE_URL` or default `'http://localhost/DevPHP_V2'`
- Produces: k6 options, default function executing user scenario, handleSummary function formatting HTML/JSON report

- [ ] **Step 1: Write `scripts/k6_load_test.js`**

```javascript
import http from 'k6/http';
import { check, sleep, group } from 'k6';
import { Rate, Trend } from 'k6/metrics';

// Custom Metrics
const errorRate = new Rate('custom_error_rate');
const homepageDuration = new Trend('homepage_duration');
const productDetailDuration = new Trend('product_detail_duration');

export const options = {
  stages: [
    { duration: '1m', target: 500 },   // Stage 1: Ramp up to 500 VUs
    { duration: '2m', target: 500 },   // Stage 2: Stay at 500 VUs
    { duration: '1m', target: 1000 },  // Stage 3: Ramp up to 1000 VUs
    { duration: '2m', target: 1000 },  // Stage 4: Stay at 1000 VUs
    { duration: '2m', target: 5000 },  // Stage 5: Ramp up to 5000 VUs
    { duration: '3m', target: 5000 },  // Stage 6: Stay at 5000 VUs
    { duration: '1m', target: 0 },     // Stage 7: Ramp down to 0 VUs
  ],
  thresholds: {
    http_req_failed: ['rate<0.05'],       // Error rate < 5%
    http_req_duration: ['p(95)<2000'],    // 95% of requests < 2000ms
    custom_error_rate: ['rate<0.05'],
  },
};

const BASE_URL = __ENV.BASE_URL || 'http://localhost/DevPHP_V2';

export default function () {
  // Step 1: Homepage Visit
  group('01_Homepage', function () {
    const res = http.get(`${BASE_URL}/index.php`);
    const success = check(res, {
      'homepage status is 200': (r) => r.status === 200,
      'homepage loaded in < 2s': (r) => r.timings.duration < 2000,
    });
    errorRate.add(!success);
    homepageDuration.add(res.timings.duration);
  });

  sleep(Math.floor(Math.random() * 3) + 1); // 1-3 seconds think time

  // Step 2: Search / Catalog Browsing
  group('02_SearchProduct', function () {
    const res = http.get(`${BASE_URL}/index.php?act=product&keyword=laptop`);
    const success = check(res, {
      'search status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
  });

  sleep(Math.floor(Math.random() * 2) + 1); // 1-2 seconds think time

  // Step 3: Product Detail View
  group('03_ProductDetail', function () {
    const res = http.get(`${BASE_URL}/index.php?act=product_detail&id=1`);
    const success = check(res, {
      'detail status is 200': (r) => r.status === 200,
    });
    errorRate.add(!success);
    productDetailDuration.add(res.timings.duration);
  });

  sleep(Math.floor(Math.random() * 3) + 1); // 1-3 seconds think time

  // Step 4: Add to Cart Simulation
  group('04_AddToCart', function () {
    const payload = JSON.stringify({
      product_id: 1,
      quantity: 1,
    });

    const params = {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
    };

    const res = http.post(`${BASE_URL}/index.php?act=add_to_cart`, { product_id: 1, quantity: 1 }, params);
    const success = check(res, {
      'cart status is 200 or 302': (r) => r.status === 200 || r.status === 302,
    });
    errorRate.add(!success);
  });

  sleep(Math.floor(Math.random() * 3) + 2); // 2-5 seconds think time
}
```

- [ ] **Step 2: Commit file `scripts/k6_load_test.js`**

```bash
git add scripts/k6_load_test.js
git commit -m "feat: add k6 load testing script for 500, 1000, 5000 VUs stages"
```

---

### Task 2: Create Instructions & Running Guide

**Files:**
- Create: `docs/k6_load_test_guide.md`

- [ ] **Step 1: Write `docs/k6_load_test_guide.md`**
Include installation instructions (winget/choco/docker), running commands, parameter overrides, and analysis tips.

- [ ] **Step 2: Commit file `docs/k6_load_test_guide.md`**

```bash
git add docs/k6_load_test_guide.md
git commit -m "docs: add guide and execution instructions for k6 load testing"
```
