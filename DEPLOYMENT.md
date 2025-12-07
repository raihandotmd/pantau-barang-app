# Deployment Guide (Ubuntu VPS)

This guide walks you through deploying the **Pantau Barang** application to a fresh Ubuntu VPS using Docker.

## Prerequisites

-   A VPS running Ubuntu 22.04 or 24.04.
-   Root or sudo access.
-   A domain name pointing to your VPS IP address (optional but recommended).

## 1. Install Docker & Docker Compose

Run these commands on your VPS to install the latest version of Docker:

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

## 2. Setup Project

You can either clone your repository (if using Git) or copy the files directly.

### Option A: Using Git (Recommended)

```bash
git clone https://github.com/your-username/pantau-barang-app.git
cd pantau-barang-app
```

### Option B: Copy Files (SCP)

If you don't use Git, copy your project folder from your local machine:

```bash
scp -r /path/to/pantau-barang-app user@your-vps-ip:/home/user/
```

## 3. Configuration

Create your production environment file:

```bash
cp .env.example .env
nano .env
```

**Crucial Production Settings:**

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

# Database (Must match docker-compose.prod.yml)
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=pantau_barang
DB_USERNAME=pantau_user
DB_PASSWORD=your_secure_password  # Change this!

# Redis (Recommended for Queue/Cache if you add Redis container later)
# For now, we use database/file as per simplifiction
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

**Note:** If you change the DB password in `.env`, make sure to also update it in `docker-compose.prod.yml` or use an environment variable substitution.

## 4. Run Deployment

Start the application in detached mode:

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

This command will:

1.  Build the app image (compile assets, install PHP dependencies).
2.  Start the PostGIS database.
3.  Start the App container.
4.  Run migrations (automatically via `entrypoint.sh`).

## 5. Verify

Check if containers are running:

```bash
docker compose -f docker-compose.prod.yml ps
```

View logs if something goes wrong:

```bash
docker compose -f docker-compose.prod.yml logs -f
```

## 6. (Optional) SSL with Certbot

To serve your app over HTTPS, you should install Nginx on the host machine as a reverse proxy, or use a tool like Caddy or Traefik.

**Simple Host Nginx Proxy Setup:**

1.  Install host Nginx: `sudo apt install nginx`
2.  Create config: `sudo nano /etc/nginx/sites-available/pantau`
    ```nginx
    server {
        server_name your-domain.com;
        location / {
            proxy_pass http://localhost:8000;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
        }
    }
    ```
3.  Enable: `sudo ln -s /etc/nginx/sites-available/pantau /etc/nginx/sites-enabled/` and `sudo service nginx restart`
4.  Get SSL: `sudo apt install certbot python3-certbot-nginx` then `sudo certbot --nginx`
