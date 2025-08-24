# 🏠 Laravel Real Estate CRM (NSW)

A Laravel-based CRM for managing landlords, their properties, tenants, and payment history — designed for real estate needs in NSW.

---

## 📦 Core Features

### ✅ Landlord Management
- Add and manage landlord profiles
- Each landlord can own multiple properties

### 🏘️ Property Management
- Add and manage properties linked to a landlord
- Track lease status (leased or vacant)

### 👤 Tenant Management
- Assign tenants to properties
- Store tenant details
- Optionally unassign tenants when lease ends

### 💵 Payment History Tracking
- Add payments to specific properties
- Track payment date, amount, status, and tenant
- Mobile-friendly cards and desktop tables

---

## 🚀 Tech Stack

- **Backend:** Laravel
- **Frontend:** Blade + Bootstrap
- **Database:** MySQL
- **Version Control:** Git + GitHub

---

## 🔧 Setup Instructions

Follow these steps to set up the project locally.

### 1. Clone the Repository

```bash
git clone https://github.com/jericosaile/laravel-realestatecrm-nsw.git
cd laravel-realestatecrm-nsw
```

## 2. Install PHP Dependencies


```bash
composer install
```

## 3. Copy the example .env file


```bash
cp .env.example .env
```

## 4. Open .env and update your database credentials


```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

## 5. Generate Application Key


```bash
php artisan key:generate
```

## 6. Run Database Migrations


```bash
php artisan migrate
```

## 7. Serve the Application


```bash
php artisan serve
