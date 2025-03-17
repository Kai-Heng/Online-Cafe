# **Nana Cafe - Online Ordering System**
A simple **PHP-based cafe ordering system** that allows customers to place orders online. This project is designed to run on **AWS EC2** with a **MariaDB / AWS RDS MySQL database** and uses **Amazon S3 for image storage**.

---

## **📌 Features**
- **User Registration & Login** (Secure password hashing)
- **Admin Panel** (Manage orders and users)
- **Online Ordering System** (Customers select products and confirm orders)
- **AWS RDS Integration** (Database hosted on Amazon RDS)
- **AWS S3 Integration** (Images stored in S3)

---

## **🚀 Tech Stack**
- **Frontend:** HTML, CSS, JavaScript, jQuery
- **Backend:** PHP, MySQL/MariaDB
- **Database:** MariaDB (Local) / AWS RDS (Cloud)
- **Storage:** AWS S3 (For storing product images)
- **Cloud Services:** AWS EC2, AWS RDS, AWS Systems Manager (SSM) Parameter Store

---

## **📂 Project Structure**
```
/nana-cafe
│── /DATABASE             # Contains SQL dump for local setup
│── /images               # Local product images (Migrated to S3)
│── /src                  # JavaScript & Facebox modal library
│── /css                  # Stylesheets
│── /lib                  # jQuery dependencies
│── /febe                 # Additional frontend assets
│── index.php             # Landing page
│── admin.php             # Admin dashboard
│── connection.php        # Database connection
│── get-parameters.php    # AWS SSM Parameter Store integration
│── order.php             # Order management
│── confirm.php           # Order confirmation logic
│── loginindex.php        # User login page
│── register.php          # User registration page
│── addmem.php            # Backend script for user signup
│── logout.php            # User logout script
│── README.md             # Project documentation
```

---

## **🔧 Local Development Setup (MariaDB)**
### **1️⃣ Install Required Software**
- **Apache** (`httpd` for Linux)
- **PHP** (`php`, `php-mysqli`, `php-curl`)
- **MariaDB/MySQL**
  
### **2️⃣ Setup Local Database**
1. Start MariaDB:
   ```bash
   sudo systemctl start mariadb
   sudo mysql_secure_installation
   ```
2. Create Database:
   ```sql
   CREATE DATABASE wings;
   ```
3. Import SQL dump:
   ```bash
   mysql -u root -p wings < DATABASE/wings.sql
   ```

### **3️⃣ Configure Local `connection.php`**
Modify `connection.php` with **local database credentials**:
```php
$conn = new mysqli("localhost", "root", "password", "wings");
```

### **4️⃣ Start Apache Server**
```bash
sudo systemctl start httpd
```
Then, access the site at **http://localhost/nana-cafe/**.

---

## **🌐 Deploy to AWS Cloud (EC2 + RDS + S3)**

### **1️⃣ Launch EC2 Instance**
- **Amazon Linux 2** or **Ubuntu**
- Install LAMP stack:
  ```bash
  sudo yum install -y httpd mariadb-server php php-mysqli php-curl unzip
  sudo systemctl enable httpd && sudo systemctl start httpd
  ```

### **2️⃣ Setup AWS RDS (MySQL)**
1. Create an **RDS MySQL instance** in AWS.
2. Find the **RDS endpoint** in the AWS console.
3. Modify `connection.php`:
   ```php
   require 'get-parameters.php';
   $conn = new mysqli($ep, $un, $pw, $db);
   ```

### **3️⃣ Store Credentials in AWS SSM Parameter Store**
1. Open **AWS Systems Manager > Parameter Store**.
2. Create parameters:
   ```
   /onlinecafe/endpoint   = <your-rds-endpoint>
   /onlinecafe/username   = <your-db-username>
   /onlinecafe/password   = <your-db-password>
   /onlinecafe/database   = wings
   ```
3. Verify parameters:
   ```bash
   aws ssm get-parameters-by-path --path "/onlinecafe/" --with-decryption
   ```

### **4️⃣ Configure S3 for Image Storage**
1. **Create an S3 Bucket** (`onlinecafe-bucket`).
2. **Make objects public** (optional for easy access).
3. **Update `connection.php` to use S3 URLs**.

### **5️⃣ Upload Project Files to EC2**
Transfer your project to EC2:
```bash
scp -i key.pem -r nana-cafe/ ec2-user@<EC2-PUBLIC-IP>:/var/www/html/
```

### **6️⃣ Configure Apache Virtual Host**
Edit `/etc/httpd/conf/httpd.conf`:
```apache
<VirtualHost *:80>
    DocumentRoot "/var/www/html"
    <Directory "/var/www/html">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Restart Apache:
```bash
sudo systemctl restart httpd
```

---

## **✅ Testing & Verification**
### **1️⃣ Check Database Connection**
```php
<?php
require 'connection.php';
if ($conn) {
    echo "Connected to AWS RDS!";
} else {
    echo "Connection failed!";
}
?>
```
Run it inside EC2:
```bash
php test_db.php
```

### **2️⃣ Upload and Access Images from S3**
Modify product images to use S3:
```php
<img src="https://onlinecafe-bucket.s3.amazonaws.com/images/burger.jpg" />
```

---

## **🔒 Security Best Practices**
- **DO NOT store AWS credentials in `connection.php`**. Use **AWS SSM Parameter Store** instead.
- **Enable RDS Security Groups** to allow access only from EC2.
- **Use IAM roles** instead of hardcoded credentials.
- **Block public access to S3** (unless needed for image hosting).

---

## **📌 Common Issues & Troubleshooting**
| Issue | Solution |
|--------|---------|
| `Access denied for user to MySQL RDS` | Check **RDS Security Group** allows **EC2 IP** |
| `Could not connect to SSM Parameter Store` | Ensure **IAM role has `ssm:GetParameters`** |
| `S3 images not loading` | Make sure **bucket policy allows public read** |
| `403 Forbidden` on Apache | Ensure `/var/www/html` has correct **permissions (`chmod -R 755 /var/www/html`)** |

---

## **📜 License**
This project is open-source and can be used for educational purposes. **Please give credit if used commercially**.

---

## **📞 Need Help?**
For any issues, feel free to **create an issue** or **contact me**.
