# Deploy Pantau Barang to Ubuntu VPS (Start to Finish)

This is the **Master Guide** to deploying your project from scratch. Follow these steps in order.

## Phase 1: Domain & DNS Setup (Crucial!)

Before touching the server, your domain must point to it.

1.  **Get your VPS IP Address** from Google Cloud Console (e.g., `34.101.xx.xx`).
2.  **Login to Rumahweb Clientzone**.
3.  Go to **Domains** > **Manage Domain** > **DNS Management**.
4.  **Create/Edit Record**:
    -   **Host**: `@` (or leave blank)
    -   **Type**: `A`
    -   **Value**: Your VPS IP Address.
5.  **Wait**: DNS propagation can take 5-60 minutes.
6.  **Verify**: Run this on your computer:
    ```bash
    ping pantaubarang.my.id
    ```
    _If it returns your VPS IP, proceed. If not, wait._

---

## Phase 2: Server Preparation

Login to your VPS:

```bash
ssh user@your-ip
```

### 1. Open Firewall ports (GCP)

Ensure your GCP Firewall allows traffic on ports **80** and **443**:

1.  Go to **VPC Network** > **Firewall**.
2.  Create a rule allowing `tcp:80,443` for `0.0.0.0/0`.

### 2. Install Docker

```bash
# Add Docker's official GPG key:
sudo apt-get update
sudo apt-get install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# Add the repository to Apt sources:
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker packages:
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

---

## Phase 3: Project Setup

### 1. Get the Code

```bash
git clone https://github.com/your-username/pantau-barang-app.git
cd pantau-barang-app
```

_(Or upload files via SCP)_

### 2. Configure Environment

```bash
cp .env.example .env
nano .env
```

**Edit these values:**

```ini
APP_ENV=production
APP_URL=https://pantaubarang.my.id
DB_CONNECTION=pgsql
DB_HOST=db
DB_PASSWORD=your_secure_password
```

### 3. Start Application (Docker)

This starts the App (on port 8000) and Database.

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

_Check if running:_ `docker compose -f docker-compose.prod.yml ps`

---

## Phase 4: Host Nginx & SSL

We use Nginx on the host to route traffic from port 80/443 -> 8000.

### 1. Install Nginx

```bash
sudo apt update
sudo apt install nginx
```

### 2. Configure Site

```bash
sudo nano /etc/nginx/sites-available/pantau
```

**Paste this content:**

```nginx
server {
    server_name pantaubarang.my.id;

    location / {
        proxy_pass http://localhost:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### 3. Enable Site

```bash
sudo ln -s /etc/nginx/sites-available/pantau /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl restart nginx
```

_At this point, `http://pantaubarang.my.id` should work._

### 4. Enable HTTPS

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d pantaubarang.my.id
```

**Success! Your site is now live at https://pantaubarang.my.id**

---

## Troubleshooting

### "Address already in use" (Port 80)

If `nginx` fails to start with `bind() to 0.0.0.0:80 failed`, it means something else is using port 80 (likely Apache or an old Docker container).

**Fix:**

1.  **Stop Apache** (if running):
    ```bash
    sudo systemctl stop apache2
    sudo systemctl disable apache2
    ```
2.  **Clear Docker Containers** (removes old Caddy or App containers):
    ```bash
    docker compose -f docker-compose.prod.yml down
    ```
3.  **Find the blocker**:
    ```bash
    sudo ss -tulpn | grep :80
    ```
    If you see a `docker-proxy`, it means your Docker container is still holding the port. Run the `down` command again.
4.  **Restart Nginx**:
    ```bash
    sudo systemctl restart nginx
    ```
