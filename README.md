Here is the modified **README.md** incorporating all your AWS services, setup instructions, and improvements.

---

# **Nana Cafe - Cloud-Based Online Ordering System**
A **scalable, high-availability café ordering system** running on **AWS Cloud** with **EC2, RDS, Auto Scaling, Load Balancer, S3, Systems Manager (SSM), WAF, and CloudWatch**.

---

## **📌 Features**
- **User Authentication** (Registration, Login with hashed passwords)
- **Online Ordering System** (Customers place orders)
- **Admin Panel** (Manage users and orders)
- **AWS RDS MySQL** (Centralized, secure database)
- **AWS S3** (Static file & image storage)
- **Auto Scaling** (Dynamically adjusts EC2 instances)
- **Application Load Balancer** (Traffic distribution)
- **AWS WAF (Web ACL)** (Security against attacks)
- **AWS CloudWatch** (Monitoring & Log Analytics)

---

## **🚀 Tech Stack**
- **Frontend:** HTML, CSS, JavaScript, jQuery  
- **Backend:** PHP, MySQL (AWS RDS)  
- **Storage:** Amazon S3  
- **Cloud Services:** AWS EC2, RDS, ALB, Auto Scaling, SSM, CloudWatch, WAF  

---

## **📂 Project Structure**
```
/online-cafe
│── /DATABASE             # SQL schema (migrated to AWS RDS)
│── /images               # Stored in Amazon S3
│── /src                  # JavaScript & Facebox modal library
│── /css                  # Stylesheets
│── /lib                  # jQuery dependencies
│── /febe                 # Additional frontend assets
│── index.php             # Homepage
│── admin.php             # Admin dashboard
│── connection.php        # Database connection (SSM-integrated)
│── get-parameters.php    # Fetch credentials from AWS Systems Manager
│── order.php             # Order processing
│── confirm.php           # Order confirmation
│── loginindex.php        # Login page
│── register.php          # User signup
│── addmem.php            # Store new user details
│── logout.php            # Session logout
│── README.md             # Project documentation
```

---

## **🌍 AWS Cloud Setup**
### **Architecture Diagram**
```
Client → Application Load Balancer (ALB) → Auto Scaling EC2 Instances → RDS MySQL  
                         ↘ S3 (Images & Static Files)  
                         ↘ Systems Manager (Secure Credentials)  
                         ↘ CloudWatch (Monitoring & Logging)  
                         ↘ AWS WAF (Security Layer)  
```

---

## **🔧 Local Setup (MariaDB)**
### **1️⃣ Install Required Software**
- **Apache, PHP, MariaDB**
  ```bash
  sudo yum install -y httpd mariadb-server php php-mysqli unzip
  sudo systemctl start httpd
  sudo systemctl enable httpd
  ```
  
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

### **3️⃣ Configure `connection.php` for Local Development**
```php
$conn = new mysqli("localhost", "root", "password", "wings");
```

### **4️⃣ Start Apache Server**
```bash
sudo systemctl restart httpd
```
Then, access the site at **http://localhost/nana-cafe/**.

---

## **🚀 Deploy to AWS Cloud (EC2 + RDS + S3)**

### **1️⃣ Launch EC2 Instance**
- **Amazon Linux 2** (t2.micro, Free Tier)
- Install software:
  ```bash
  sudo yum update -y
  sudo yum install -y httpd php php-mysqli unzip aws-cli
  sudo systemctl start httpd
  sudo systemctl enable httpd
  ```

### **2️⃣ Set Up AWS RDS MySQL**
1. Create **RDS MySQL instance**.
2. Configure **Security Group** (allow EC2 connections).
3. Retrieve **RDS endpoint**.
4. Modify `connection.php`:
   ```php
   require 'get-parameters.php';
   $conn = new mysqli($ep, $un, $pw, $db);
   ```

### **3️⃣ Store Credentials in AWS Systems Manager (SSM)**
```bash
aws ssm put-parameter --name "/onlinecafe/endpoint" --value "your-rds-endpoint" --type "String"
aws ssm put-parameter --name "/onlinecafe/username" --value "admin" --type "String"
aws ssm put-parameter --name "/onlinecafe/password" --value "your-db-password" --type "SecureString"
aws ssm put-parameter --name "/onlinecafe/database" --value "wings" --type "String"
```

### **4️⃣ Configure S3 for Image Storage**
```php
<img src="https://onlinecafe-bucket.s3.amazonaws.com/images/burger.jpg" />
```

### **5️⃣ Upload Files to EC2**
```bash
scp -i key.pem -r nana-cafe/ ec2-user@<EC2-PUBLIC-IP>:/var/www/html/
```

### **6️⃣ Configure Auto Scaling & Load Balancer**
- Created **Application Load Balancer**.
- Configured **Auto Scaling Group** for 1-4 instances.
- **User Data for Auto Scaling Instances**:
```bash
#!/bin/bash
yum update -y
yum install -y httpd php php-mysqli unzip aws-cli
systemctl start httpd
systemctl enable httpd
aws s3 sync s3://your-bucket-name /var/www/html/
(crontab -l 2>/dev/null; echo "*/5 * * * * aws s3 sync s3://your-bucket-name /var/www/html/ --delete") | crontab -
```

### **7️⃣ Configure CloudWatch & Logs**
```bash
aws logs create-log-group --log-group-name "/aws/ec2/nana-cafe"
aws logs create-log-stream --log-group-name "/aws/ec2/nana-cafe" --log-stream-name "app-log"
```

---

## **🛠 Code Modifications**
### **🔹 `connection.php`**
```php
require 'vendor/autoload.php';
use Aws\Ssm\SsmClient;
$ssm = new SsmClient(['version' => 'latest', 'region' => 'us-east-1']);
$params = $ssm->getParametersByPath(['Path' => '/nana-cafe/', 'WithDecryption' => true]);
foreach ($params['Parameters'] as $p) {
    $values[str_replace('/nana-cafe/', '', $p['Name'])] = $p['Value'];
}
$conn = new mysqli($values['endpoint'], $values['username'], $values['password'], $values['database']);
```

### **🔹 `style.css` (Updated for S3)**
```css
body {
    background: url('https://onlinecafe-bucket.s3.amazonaws.com/background.jpg') no-repeat center top;
}
```

---

## **🔒 Security Enhancements**
✅ **Removed Hardcoded DB Credentials**  
✅ **AWS WAF to Prevent Attacks**  
✅ **RDS Security Group (Restricted Access)**  

---

## **📜 License**
This project is **open-source** and available for educational purposes.

---

## **📞 Need Help?**
If you encounter any issues, feel free to **create an issue** in this repository.

---