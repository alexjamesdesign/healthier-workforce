# 🗺️ Location Secure Switch (LSS) WordPress Plugin

**Location Secure Switch (LSS)** dynamically personalises WordPress content based on a visitor’s detected location.  
It securely connects to the Cloudflare-hosted **LSS API** to fetch region-specific data and apply fallback logic when no match is found.

---

## 📦 Overview

This plugin helps marketers and developers display localised landing pages — for example, automatically showing “Garage Conversions in *Manchester*” when the visitor’s location matches that region.

The plugin connects to a secure API using a unique **Site ID** and **Site Secret** to retrieve location data.

---

## ⚙️ Requirements

- WordPress **6.0+**
- PHP **7.4+**
- **cURL** enabled on your hosting environment
- A **Site ID** and **Site Secret** (issued by your administrator)
- An **API Endpoint** (usually `https://api.locationsecureswitch.com`)

---

## 🚀 Installation

### Option A — Manual Upload
1. Download or clone the plugin folder `location-secure-switch/`.
2. Upload it to `/wp-content/plugins/` on your WordPress site.
3. Activate it via **Plugins → Installed Plugins** in the WordPress Admin.

### Option B — Upload ZIP
1. Compress the plugin folder into `location-secure-switch.zip`.
2. Go to **Plugins → Add New → Upload Plugin**.
3. Upload and click **Activate**.

---

## ⚙️ Configuration

1. Navigate to **Settings → Location Secure Switch** in the WordPress Admin.
2. Enter your credentials:
   - **Site ID**
   - **Site Secret**
   - **API Endpoint** (defaults to your Cloudflare Worker URL)
3. *(Optional)* Enable **Local Test Map** for local development (e.g. `localhost:8080`).
4. Save your changes.

---

## 🧩 Placeholder Usage

You can add placeholders anywhere in WordPress pages, posts, or templates.  
The plugin will replace them dynamically with the correct location.

**Example:**
```html
<h1>Welcome to {{Location}}</h1>
<p>We provide services across {{Location}}.</p>
