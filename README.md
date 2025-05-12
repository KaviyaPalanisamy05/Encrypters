# 🔐 Passwordless Authentication System

A secure and modern passwordless authentication system built with **PHP**, **JavaScript**, **WebAuthn**, **JWT**, and **Email OTP**.  
Users can register with an email OTP and authenticate using biometrics like fingerprint, Face ID, or device PIN.

---

## 🚀 Features

- 🔒 **WebAuthn Biometric Login** (Fingerprint, Face ID, PIN)
- 📩 **Email OTP Verification** before account creation
- 🔐 **JWT Token-based Sessions** with auto-expiry (e.g., 15 minutes)
- 💻 **Single Trusted Device Login** enforced
- 🔁 **Session Management & Logout**
- 🛡️ Resistant to phishing, password leaks, and replay attacks

---

## 🛠️ Tech Stack

### Programming Languages
- **JavaScript** – WebAuthn API, form handling, AJAX
- **PHP** – OTP generation, credential verification, JWT management

### Development Environment
- **Visual Studio Code**
- **XAMPP** (Apache + PHP + MySQL)
- **Postman** – API testing
- **Google Chrome** – WebAuthn testing

### Database
- User credentials (including WebAuthn public keys and metadata) are stored in a **`users.json`** file.
- **MySQL** may be optionally used to track sessions or additional metadata.
- OTP email verification uses **PHPMailer**. To enable this:
  1. Download [PHPMailer](https://github.com/PHPMailer/PHPMailer) and include it in your project.
  2. Create an **App Password** from your email account (e.g., Gmail).
  3. Configure the app password and SMTP settings in `otp.php`.

---

## ✨ Author

**Kaviya Palanisamy**  
GitHub: [@KaviyaPalanisamy05](https://github.com/KaviyaPalanisamy05)
