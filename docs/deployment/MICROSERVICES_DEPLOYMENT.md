# Microservices Deployment Guide

## Overview

This guide provides comprehensive deployment instructions for the microservice architecture in the Hotel & Restaurant Administrative Management System.

## Deployment Architecture

### System Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Load Balancer │────│   API Gateway   │────│   Web Frontend  │
│    (Nginx)      │    │   (Laravel)     │    │      (Vue)      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │
                ┌───────────────┼───────────────┐
                │               │               │
        ┌───────▼──────┐ ┌──────▼──────┐ ┌─────▼──────┐
        │ Document     │ │ Visitor     │ │ Facility   │
        │ Service      │ │ Service     │ │ Service    │
        │ (Port 8001)  │ │ (Port 8002) │ │ (Port 8003)│
        └──────────────┘ └─────────────┘ └────────────┘
                │               │               │
        ┌───────▼──────┐ ┌──────▼──────┐ ┌─────▼──────┐
        │ Legal        │ │ Notification│ │ Auth       │
        │ Service      │ │ Service     │ │ Service    │
        │ (Port 8004)  │ │ (Port 8005) │ │ (Port 8006)│
        └──────────────┘ └─────────────┘ └────────────┘
                │
        ┌───────▼──────┐
        │ AI Service   │
        │ (Port 8007)  │
        └──────────────┘
```

## Prerequisites

### Infrastructure Requirements

#### Minimum Requirements
- **CPU**: 4 cores per service
- **RAM**: 8GB per service
- **Storage**: 50GB SSD per service
- **Network**: 1Gbps internal network
- **Load Balancer**: Nginx/HAProxy

#### Recommended Requirements
- **CPU**: 8 cores per service
- **RAM**: 16GB per service
- **Storage**: 100GB SSD per service
- **Network**: 10Gbps internal network
- **Load Balancer**: Nginx Plus/HAProxy Enterprise

### Software Requirements

#### Base Software
- **Operating System**: Ubuntu 20.04+ / CentOS 8+ / RHEL 8+
- **Docker**: 20.10+
- **Docker Compose**: 2.0+
- **PHP**: 8.1+
- **Node.js**: 16+
- **Nginx**: 1.20+

#### Database & Cache
- **MySQL**: 8.0+ / PostgreSQL 13+
- **Redis**: 6.0+
- **Elasticsearch**: 7.0+ (optional for search)

#### Monitoring
- **Prometheus**: 2.30+
- **Grafana**: 8.0+
- **Jaeger**: 1.30+ (optional for tracing)

## Deployment Options

### Option 1: Docker Compose (Development/Small Production)

#### Create Docker Compose File

Create `docker-compose.microservices.yml`:

```yaml
version: '3.8'

services:
  # Main Application
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "8000:8000"
    environment:
      - APP_ENV=production
      - DB_HOST=mysql
      - REDIS_HOST=redis
      - DOCUMENT_SERVICE_URL=http://document-service:8001
      - VISITOR_SERVICE_URL=http://visitor-service:8002
      - FACILITY_SERVICE_URL=http://facility-service:8003
      - LEGAL_SERVICE_URL=http://legal-service:8004
      - NOTIFICATION_SERVICE_URL=http://notification-service:8005
      - AUTH_SERVICE_URL=http://auth-service:8006
      - AI_SERVICE_URL=http://ai-service:8007
    depends_on:
      - mysql
      - redis
      - document-service
      - visitor-service
      - facility-service
      - legal-service
      - notification-service
      - auth-service
      - ai-service
    networks:
      - microservices

  # Document Service
  document-service:
    build:
      context: ./services/document
      dockerfile: Dockerfile
    ports:
      - "8001:8001"
    environment:
      - SERVICE_NAME=document
      - DB_HOST=mysql
      - REDIS_HOST=redis
    depends_on:
      - mysql
      - redis
    networks:
      - microservices

  # Visitor Service
  visitor-service:
    build:
      context: ./services/visitor
      dockerfile: Dockerfile
    ports:
      - "8002:8002"
    environment:
      - SERVICE_NAME=visitor
      - DB_HOST=mysql
      - REDIS_HOST=redis
    depends_on:
      - mysql
      - redis
    networks:
      - microservices

  # Facility Service
  facility-service:
    build:
      context: ./services/facility
      dockerfile: Dockerfile
    ports:
      - "8003:8003"
    environment:
      - SERVICE_NAME=facility
      - DB_HOST=mysql
      - REDIS_HOST=redis
    depends_on:
      - mysql
      - redis
    networks:
      - microservices

  # Legal Service
  legal-service:
    build:
      context: ./services/legal
      dockerfile: Dockerfile
    ports:
      - "8004:8004"
    environment:
      - SERVICE_NAME=legal
      - DB_HOST=mysql
      - REDIS_HOST=redis
    depends_on:
      - mysql
      - redis
    networks:
      - microservices

  # Notification Service
  notification-service:
    build:
      context: ./services/notification
      dockerfile: Dockerfile
    ports:
      - "8005:8005"
    environment:
      - SERVICE_NAME=notification
      - DB_HOST=mysql
      - REDIS_HOST=redis
      - SMTP_HOST=smtp
    depends_on:
      - mysql
      - redis
      - smtp
    networks:
      - microservices

  # Auth Service
  auth-service:
    build:
      context: ./services/auth
      dockerfile: Dockerfile
    ports:
      - "8006:8006"
    environment:
      - SERVICE_NAME=auth
      - DB_HOST=mysql
      - REDIS_HOST=redis
      - JWT_SECRET=${JWT_SECRET}
    depends_on:
      - mysql
      - redis
    networks:
      - microservices

  # AI Service
  ai-service:
    build:
      context: ./services/ai
      dockerfile: Dockerfile
    ports:
      - "8007:8007"
    environment:
      - SERVICE_NAME=ai
      - REDIS_HOST=redis
      - PYTHON_ENV=production
    depends_on:
      - redis
    networks:
      - microservices

  # Database
  mysql:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=${DB_ROOT_PASSWORD}
      - MYSQL_DATABASE=${DB_DATABASE}
      - MYSQL_USER=${DB_USERNAME}
      - MYSQL_PASSWORD=${DB_PASSWORD}
    volumes:
      - mysql_data:/var/lib/mysql
      - ./docker/mysql/init.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3306:3306"
    networks:
      - microservices

  # Cache
  redis:
    image: redis:6.2-alpine
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data
    networks:
      - microservices

  # Message Queue
  rabbitmq:
    image: rabbitmq:3.9-management
    environment:
      - RABBITMQ_DEFAULT_USER=${RABBITMQ_USER}
      - RABBITMQ_DEFAULT_PASS=${RABBITMQ_PASSWORD}
    ports:
      - "5672:5672"
      - "15672:15672"
    volumes:
      - rabbitmq_data:/var/lib/rabbitmq
    networks:
      - microservices

  # SMTP Server (for development)
  smtp:
    image: mailhog/mailhog
    ports:
      - "1025:1025"
      - "8025:8025"
    networks:
      - microservices

  # Load Balancer
  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./docker/nginx/nginx.conf:/etc/nginx/nginx.conf
      - ./docker/nginx/ssl:/etc/nginx/ssl
    depends_on:
      - app
    networks:
      - microservices

  # Monitoring
  prometheus:
    image: prom/prometheus:latest
    ports:
      - "9090:9090"
    volumes:
      - ./docker/prometheus/prometheus.yml:/etc/prometheus/prometheus.yml
      - prometheus_data:/prometheus
    networks:
      - microservices

  grafana:
    image: grafana/grafana:latest
    ports:
      - "3000:3000"
    environment:
      - GF_SECURITY_ADMIN_PASSWORD=${GRAFANA_PASSWORD}
    volumes:
      - grafana_data:/var/lib/grafana
      - ./docker/grafana/dashboards:/etc/grafana/provisioning/dashboards
    networks:
      - microservices

volumes:
  mysql_data:
  redis_data:
  rabbitmq_data:
  prometheus_data:
  grafana_data:

networks:
  microservices:
    driver: bridge
```

#### Environment File

Create `.env.microservices`:

```env
# Application
APP_NAME=Hotel Restaurant Admin System
APP_ENV=production
APP_KEY=base64:your_app_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=hotel_admin
DB_USERNAME=hotel_admin
DB_PASSWORD=your_db_password
DB_ROOT_PASSWORD=your_root_password

# Cache
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Services
DOCUMENT_SERVICE_URL=http://document-service:8001
DOCUMENT_SERVICE_API_KEY=your_document_service_key

VISITOR_SERVICE_URL=http://visitor-service:8002
VISITOR_SERVICE_API_KEY=your_visitor_service_key

FACILITY_SERVICE_URL=http://facility-service:8003
FACILITY_SERVICE_API_KEY=your_facility_service_key

LEGAL_SERVICE_URL=http://legal-service:8004
LEGAL_SERVICE_API_KEY=your_legal_service_key

NOTIFICATION_SERVICE_URL=http://notification-service:8005
NOTIFICATION_SERVICE_API_KEY=your_notification_service_key

AUTH_SERVICE_URL=http://auth-service:8006
AUTH_SERVICE_API_KEY=your_auth_service_key

AI_SERVICE_URL=http://ai-service:8007
AI_SERVICE_API_KEY=your_ai_service_key

# JWT
JWT_SECRET=your_jwt_secret_here

# RabbitMQ
RABBITMQ_USER=admin
RABBITMQ_PASSWORD=your_rabbitmq_password

# Monitoring
GRAFANA_PASSWORD=your_grafana_password

# Microservice Settings
MICROSERVICE_ENABLE_FALLBACK=true
MICROSERVICE_LOG_REQUESTS=true
MICROSERVICE_CACHE_RESPONSES=true
MICROSERVICE_MONITORING_ENABLED=true
```

#### Deployment Commands

```bash
# Build and start all services
docker-compose -f docker-compose.microservices.yml --env-file .env.microservices up -d

# Scale specific services
docker-compose -f docker-compose.microservices.yml up -d --scale document-service=3 --scale visitor-service=2

# Check service status
docker-compose -f docker-compose.microservices.yml ps

# View logs
docker-compose -f docker-compose.microservices.yml logs -f app

# Stop all services
docker-compose -f docker-compose.microservices.yml down
```

### Option 2: Kubernetes (Production)

#### Namespace Configuration

Create `k8s/namespace.yaml`:

```yaml
apiVersion: v1
kind: Namespace
metadata:
  name: hotel-admin
  labels:
    name: hotel-admin
```

#### ConfigMap

Create `k8s/configmap.yaml`:

```yaml
apiVersion: v1
kind: ConfigMap
metadata:
  name: microservices-config
  namespace: hotel-admin
data:
  APP_ENV: "production"
  APP_DEBUG: "false"
  DB_HOST: "mysql-service"
  REDIS_HOST: "redis-service"
  DOCUMENT_SERVICE_URL: "http://document-service:8001"
  VISITOR_SERVICE_URL: "http://visitor-service:8002"
  FACILITY_SERVICE_URL: "http://facility-service:8003"
  LEGAL_SERVICE_URL: "http://legal-service:8004"
  NOTIFICATION_SERVICE_URL: "http://notification-service:8005"
  AUTH_SERVICE_URL: "http://auth-service:8006"
  AI_SERVICE_URL: "http://ai-service:8007"
  MICROSERVICE_ENABLE_FALLBACK: "true"
  MICROSERVICE_LOG_REQUESTS: "true"
  MICROSERVICE_CACHE_RESPONSES: "true"
```

#### Secrets

Create `k8s/secrets.yaml`:

```yaml
apiVersion: v1
kind: Secret
metadata:
  name: microservices-secrets
  namespace: hotel-admin
type: Opaque
data:
  APP_KEY: <base64_encoded_app_key>
  DB_PASSWORD: <base64_encoded_db_password>
  DB_ROOT_PASSWORD: <base64_encoded_root_password>
  JWT_SECRET: <base64_encoded_jwt_secret>
  DOCUMENT_SERVICE_API_KEY: <base64_encoded_document_key>
  VISITOR_SERVICE_API_KEY: <base64_encoded_visitor_key>
  FACILITY_SERVICE_API_KEY: <base64_encoded_facility_key>
  LEGAL_SERVICE_API_KEY: <base64_encoded_legal_key>
  NOTIFICATION_SERVICE_API_KEY: <base64_encoded_notification_key>
  AUTH_SERVICE_API_KEY: <base64_encoded_auth_key>
  AI_SERVICE_API_KEY: <base64_encoded_ai_key>
```

#### Main Application Deployment

Create `k8s/app-deployment.yaml`:

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: hotel-admin-app
  namespace: hotel-admin
spec:
  replicas: 3
  selector:
    matchLabels:
      app: hotel-admin-app
  template:
    metadata:
      labels:
        app: hotel-admin-app
    spec:
      containers:
      - name: app
        image: your-registry/hotel-admin:latest
        ports:
        - containerPort: 8000
        envFrom:
        - configMapRef:
            name: microservices-config
        - secretRef:
            name: microservices-secrets
        resources:
          requests:
            memory: "512Mi"
            cpu: "250m"
          limits:
            memory: "1Gi"
            cpu: "500m"
        livenessProbe:
          httpGet:
            path: /health
            port: 8000
          initialDelaySeconds: 30
          periodSeconds: 10
        readinessProbe:
          httpGet:
            path: /ready
            port: 8000
          initialDelaySeconds: 5
          periodSeconds: 5

---
apiVersion: v1
kind: Service
metadata:
  name: hotel-admin-service
  namespace: hotel-admin
spec:
  selector:
    app: hotel-admin-app
  ports:
  - protocol: TCP
    port: 80
    targetPort: 8000
  type: ClusterIP
```

#### Document Service Deployment

Create `k8s/document-service.yaml`:

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: document-service
  namespace: hotel-admin
spec:
  replicas: 2
  selector:
    matchLabels:
      app: document-service
  template:
    metadata:
      labels:
        app: document-service
    spec:
      containers:
      - name: document-service
        image: your-registry/document-service:latest
        ports:
        - containerPort: 8001
        envFrom:
        - configMapRef:
            name: microservices-config
        - secretRef:
            name: microservices-secrets
        resources:
          requests:
            memory: "256Mi"
            cpu: "200m"
          limits:
            memory: "512Mi"
            cpu: "400m"
        livenessProbe:
          httpGet:
            path: /health
            port: 8001
          initialDelaySeconds: 30
          periodSeconds: 10

---
apiVersion: v1
kind: Service
metadata:
  name: document-service
  namespace: hotel-admin
spec:
  selector:
    app: document-service
  ports:
  - protocol: TCP
    port: 8001
    targetPort: 8001
  type: ClusterIP
```

#### Ingress Configuration

Create `k8s/ingress.yaml`:

```yaml
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: hotel-admin-ingress
  namespace: hotel-admin
  annotations:
    kubernetes.io/ingress.class: nginx
    cert-manager.io/cluster-issuer: letsencrypt-prod
    nginx.ingress.kubernetes.io/ssl-redirect: "true"
    nginx.ingress.kubernetes.io/proxy-body-size: "50m"
spec:
  tls:
  - hosts:
    - your-domain.com
    secretName: hotel-admin-tls
  rules:
  - host: your-domain.com
    http:
      paths:
      - path: /
        pathType: Prefix
        backend:
          service:
            name: hotel-admin-service
            port:
              number: 80
      - path: /api/documents
        pathType: Prefix
        backend:
          service:
            name: document-service
            port:
              number: 8001
```

#### Horizontal Pod Autoscaler

Create `k8s/hpa.yaml`:

```yaml
apiVersion: autoscaling/v2
kind: HorizontalPodAutoscaler
metadata:
  name: hotel-admin-app-hpa
  namespace: hotel-admin
spec:
  scaleTargetRef:
    apiVersion: apps/v1
    kind: Deployment
    name: hotel-admin-app
  minReplicas: 3
  maxReplicas: 10
  metrics:
  - type: Resource
    resource:
      name: cpu
      target:
        type: Utilization
        averageUtilization: 70
  - type: Resource
    resource:
      name: memory
      target:
        type: Utilization
        averageUtilization: 80

---
apiVersion: autoscaling/v2
kind: HorizontalPodAutoscaler
metadata:
  name: document-service-hpa
  namespace: hotel-admin
spec:
  scaleTargetRef:
    apiVersion: apps/v1
    kind: Deployment
    name: document-service
  minReplicas: 2
  maxReplicas: 5
  metrics:
  - type: Resource
    resource:
      name: cpu
      target:
        type: Utilization
        averageUtilization: 70
```

#### Deployment Commands

```bash
# Apply all configurations
kubectl apply -f k8s/

# Check deployment status
kubectl get pods -n hotel-admin
kubectl get services -n hotel-admin
kubectl get ingress -n hotel-admin

# Scale specific services
kubectl scale deployment document-service --replicas=5 -n hotel-admin

# View logs
kubectl logs -f deployment/hotel-admin-app -n hotel-admin

# Delete deployment
kubectl delete -f k8s/
```

### Option 3: Cloud Provider (AWS/Azure/GCP)

#### AWS ECS Deployment

Create `ecs/task-definition.json`:

```json
{
  "family": "hotel-admin-microservices",
  "networkMode": "awsvpc",
  "requiresCompatibilities": ["FARGATE"],
  "cpu": "1024",
  "memory": "2048",
  "executionRoleArn": "arn:aws:iam::account:role/ecsTaskExecutionRole",
  "taskRoleArn": "arn:aws:iam::account:role/ecsTaskRole",
  "containerDefinitions": [
    {
      "name": "app",
      "image": "your-account.dkr.ecr.region.amazonaws.com/hotel-admin:latest",
      "portMappings": [
        {
          "containerPort": 8000,
          "protocol": "tcp"
        }
      ],
      "environment": [
        {
          "name": "APP_ENV",
          "value": "production"
        },
        {
          "name": "DOCUMENT_SERVICE_URL",
          "value": "http://document-service:8001"
        }
      ],
      "secrets": [
        {
          "name": "DB_PASSWORD",
          "valueFrom": "arn:aws:secretsmanager:region:account:secret:hotel-admin/db-password"
        }
      ],
      "logConfiguration": {
        "logDriver": "awslogs",
        "options": {
          "awslogs-group": "/ecs/hotel-admin",
          "awslogs-region": "us-west-2",
          "awslogs-stream-prefix": "ecs"
        }
      },
      "healthCheck": {
        "command": ["CMD-SHELL", "curl -f http://localhost:8000/health || exit 1"],
        "interval": 30,
        "timeout": 5,
        "retries": 3
      }
    }
  ]
}
```

#### Azure Container Instances

Create `aci/deployment.json`:

```json
{
  "apiVersion": "2019-12-01",
  "type": "Microsoft.ContainerInstance/containerGroups",
  "name": "hotel-admin",
  "location": "eastus",
  "properties": {
    "containers": [
      {
        "name": "app",
        "properties": {
          "image": "yourregistry.azurecr.io/hotel-admin:latest",
          "ports": [
            {
              "port": 8000
            }
          ],
          "environmentVariables": [
            {
              "name": "APP_ENV",
              "value": "production"
            }
          ],
          "resources": {
            "requests": {
              "cpu": 1.0,
              "memoryInGb": 2.0
            }
          }
        }
      }
    ],
    "osType": "Linux",
    "ipAddress": {
      "type": "Public",
      "ports": [
        {
          "port": 8000,
          "protocol": "TCP"
        }
      ]
    }
  }
}
```

## CI/CD Pipeline

### GitHub Actions

Create `.github/workflows/deploy-microservices.yml`:

```yaml
name: Deploy Microservices

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

env:
  REGISTRY: ghcr.io
  IMAGE_NAME: ${{ github.repository }}

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        extensions: mbstring, xml, mysql, pgsql
        
    - name: Copy environment file
      run: cp .env.example .env
      
    - name: Install dependencies
      run: composer install --no-progress --no-interaction --prefer-dist
      
    - name: Run tests
      run: vendor/bin/phpunit
      
    - name: Run microservice tests
      run: php artisan test --testsuite=Microservices

  build:
    needs: test
    runs-on: ubuntu-latest
    permissions:
      contents: read
      packages: write
      
    strategy:
      matrix:
        service: [app, document, visitor, facility, legal, notification, auth, ai]
        
    steps:
    - name: Checkout
      uses: actions/checkout@v3
      
    - name: Log in to Container Registry
      uses: docker/login-action@v2
      with:
        registry: ${{ env.REGISTRY }}
        username: ${{ github.actor }}
        password: ${{ secrets.GITHUB_TOKEN }}
        
    - name: Extract metadata
      id: meta
      uses: docker/metadata-action@v4
      with:
        images: ${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}-${{ matrix.service }}
        
    - name: Build and push Docker image
      uses: docker/build-push-action@v4
      with:
        context: .
        file: ./services/${{ matrix.service }}/Dockerfile
        push: true
        tags: ${{ steps.meta.outputs.tags }}
        labels: ${{ steps.meta.outputs.labels }}

  deploy:
    needs: build
    runs-on: ubuntu-latest
    if: github.ref == 'refs/heads/main'
    
    steps:
    - name: Checkout
      uses: actions/checkout@v3
      
    - name: Setup kubectl
      uses: azure/setup-kubectl@v3
      with:
        version: 'v1.24.0'
        
    - name: Configure kubectl
      run: |
        echo "${{ secrets.KUBE_CONFIG }}" | base64 -d > kubeconfig
        export KUBECONFIG=kubeconfig
        
    - name: Deploy to Kubernetes
      run: |
        export KUBECONFIG=kubeconfig
        kubectl set image deployment/hotel-admin-app app=${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}-app:main -n hotel-admin
        kubectl set image deployment/document-service document-service=${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}-document:main -n hotel-admin
        
    - name: Verify deployment
      run: |
        export KUBECONFIG=kubeconfig
        kubectl rollout status deployment/hotel-admin-app -n hotel-admin
        kubectl rollout status deployment/document-service -n hotel-admin
```

### GitLab CI/CD

Create `.gitlab-ci.yml`:

```yaml
stages:
  - test
  - build
  - deploy

variables:
  DOCKER_REGISTRY: $CI_REGISTRY
  DOCKER_DRIVER: overlay2

test:
  stage: test
  image: php:8.1-cli
  services:
    - mysql:8.0
    - redis:6.2
  variables:
    MYSQL_ROOT_PASSWORD: $DB_ROOT_PASSWORD
    MYSQL_DATABASE: $DB_DATABASE
    MYSQL_USER: $DB_USERNAME
    MYSQL_PASSWORD: $DB_PASSWORD
  before_script:
    - apt-get update -yqq
    - apt-get install -yqq git libzip-dev zip unzip
    - docker-php-ext-install pdo_mysql zip
    - pecl install redis
    - docker-php-ext-enable redis
    - curl -sS https://getcomposer.org/installer | php
    - php composer.phar install --no-interaction --no-progress
  script:
    - cp .env.example .env
    - php artisan config:cache
    - vendor/bin/phpunit
    - php artisan test --testsuite=Microservices

build:
  stage: build
  image: docker:latest
  services:
    - docker:dind
  before_script:
    - docker login -u $CI_REGISTRY_USER -p $CI_REGISTRY_PASSWORD $CI_REGISTRY
  script:
    - docker build -t $CI_REGISTRY_IMAGE/app:$CI_COMMIT_SHA -f ./services/app/Dockerfile .
    - docker build -t $CI_REGISTRY_IMAGE/document:$CI_COMMIT_SHA -f ./services/document/Dockerfile .
    - docker push $CI_REGISTRY_IMAGE/app:$CI_COMMIT_SHA
    - docker push $CI_REGISTRY_IMAGE/document:$CI_COMMIT_SHA
  only:
    - main

deploy:
  stage: deploy
  image: bitnami/kubectl:latest
  script:
    - kubectl config use-context $KUBE_CONTEXT
    - kubectl set image deployment/hotel-admin-app app=$CI_REGISTRY_IMAGE/app:$CI_COMMIT_SHA -n hotel-admin
    - kubectl set image deployment/document-service document-service=$CI_REGISTRY_IMAGE/document:$CI_COMMIT_SHA -n hotel-admin
    - kubectl rollout status deployment/hotel-admin-app -n hotel-admin
  only:
    - main
  when: manual
```

## Monitoring and Observability

### Prometheus Configuration

Create `monitoring/prometheus.yml`:

```yaml
global:
  scrape_interval: 15s
  evaluation_interval: 15s

rule_files:
  - "microservices_rules.yml"

scrape_configs:
  - job_name: 'hotel-admin-app'
    static_configs:
      - targets: ['app:8000']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'document-service'
    static_configs:
      - targets: ['document-service:8001']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'visitor-service'
    static_configs:
      - targets: ['visitor-service:8002']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'facility-service'
    static_configs:
      - targets: ['facility-service:8003']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'legal-service'
    static_configs:
      - targets: ['legal-service:8004']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'notification-service'
    static_configs:
      - targets: ['notification-service:8005']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'auth-service'
    static_configs:
      - targets: ['auth-service:8006']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'ai-service'
    static_configs:
      - targets: ['ai-service:8007']
    metrics_path: '/metrics'
    scrape_interval: 30s

alerting:
  alertmanagers:
    - static_configs:
        - targets:
          - alertmanager:9093
```

### Grafana Dashboards

Create `monitoring/grafana/dashboards/microservices.json`:

```json
{
  "dashboard": {
    "title": "Microservices Overview",
    "panels": [
      {
        "title": "Service Health",
        "type": "stat",
        "targets": [
          {
            "expr": "up{job=~\".*-service\"}",
            "legendFormat": "{{job}}"
          }
        ]
      },
      {
        "title": "Request Rate",
        "type": "graph",
        "targets": [
          {
            "expr": "rate(http_requests_total[5m])",
            "legendFormat": "{{job}} - {{method}}"
          }
        ]
      },
      {
        "title": "Response Time",
        "type": "graph",
        "targets": [
          {
            "expr": "histogram_quantile(0.95, rate(http_request_duration_seconds_bucket[5m]))",
            "legendFormat": "{{job}}"
          }
        ]
      },
      {
        "title": "Error Rate",
        "type": "graph",
        "targets": [
          {
            "expr": "rate(http_requests_total{status=~\"5..\"}[5m]) / rate(http_requests_total[5m])",
            "legendFormat": "{{job}}"
          }
        ]
      }
    ]
  }
}
```

### Alerting Rules

Create `monitoring/microservices_rules.yml`:

```yaml
groups:
  - name: microservices
    rules:
      - alert: ServiceDown
        expr: up{job=~".*-service"} == 0
        for: 1m
        labels:
          severity: critical
        annotations:
          summary: "Service {{ $labels.job }} is down"
          description: "Service {{ $labels.job }} has been down for more than 1 minute."

      - alert: HighErrorRate
        expr: rate(http_requests_total{status=~"5.."}[5m]) / rate(http_requests_total[5m]) > 0.1
        for: 5m
        labels:
          severity: warning
        annotations:
          summary: "High error rate on {{ $labels.job }}"
          description: "Error rate is {{ $value | humanizePercentage }} on {{ $labels.job }}"

      - alert: HighResponseTime
        expr: histogram_quantile(0.95, rate(http_request_duration_seconds_bucket[5m])) > 1
        for: 5m
        labels:
          severity: warning
        annotations:
          summary: "High response time on {{ $labels.job }}"
          description: "95th percentile response time is {{ $value }}s on {{ $labels.job }}"

      - alert: CircuitBreakerOpen
        expr: circuit_breaker_open == 1
        for: 2m
        labels:
          severity: critical
        annotations:
          summary: "Circuit breaker open for {{ $labels.service }}"
          description: "Circuit breaker has been open for more than 2 minutes."
```

## Security Considerations

### Network Security

```yaml
# Network policies for Kubernetes
apiVersion: networking.k8s.io/v1
kind: NetworkPolicy
metadata:
  name: microservices-network-policy
  namespace: hotel-admin
spec:
  podSelector: {}
  policyTypes:
  - Ingress
  - Egress
  ingress:
  - from:
    - namespaceSelector:
        matchLabels:
          name: hotel-admin
    ports:
    - protocol: TCP
      port: 8000
    - protocol: TCP
      port: 8001
    - protocol: TCP
      port: 8002
    - protocol: TCP
      port: 8003
    - protocol: TCP
      port: 8004
    - protocol: TCP
      port: 8005
    - protocol: TCP
      port: 8006
    - protocol: TCP
      port: 8007
  egress:
  - to:
    - namespaceSelector:
        matchLabels:
          name: hotel-admin
  - to: []
    ports:
    - protocol: TCP
      port: 53
    - protocol: UDP
      port: 53
```

### Pod Security

```yaml
# Pod security context
apiVersion: v1
kind: Pod
metadata:
  name: secure-pod
spec:
  securityContext:
    runAsNonRoot: true
    runAsUser: 1000
    fsGroup: 1000
  containers:
  - name: app
    securityContext:
      allowPrivilegeEscalation: false
      readOnlyRootFilesystem: true
      capabilities:
        drop:
        - ALL
```

## Backup and Disaster Recovery

### Database Backup

```bash
#!/bin/bash
# backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups"
DB_NAME="hotel_admin"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -h mysql -u root -p$DB_ROOT_PASSWORD $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/db_backup_$DATE.sql

# Upload to S3 (if configured)
if [ ! -z "$AWS_S3_BUCKET" ]; then
  aws s3 cp $BACKUP_DIR/db_backup_$DATE.sql.gz s3://$AWS_S3_BUCKET/backups/
fi

# Clean old backups (keep last 7 days)
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +7 -delete

echo "Backup completed: $BACKUP_DIR/db_backup_$DATE.sql.gz"
```

### Service Recovery

```bash
#!/bin/bash
# recover.sh

BACKUP_FILE=$1
SERVICE_NAME=$2

if [ -z "$BACKUP_FILE" ] || [ -z "$SERVICE_NAME" ]; then
  echo "Usage: $0 <backup_file> <service_name>"
  exit 1
fi

echo "Recovering $SERVICE_NAME from $BACKUP_FILE"

# Scale down service
kubectl scale deployment $SERVICE_NAME --replicas=0 -n hotel-admin

# Wait for pods to terminate
kubectl wait --for=delete pod -l app=$SERVICE_NAME -n hotel-admin --timeout=60s

# Restore database
gunzip -c $BACKUP_FILE | mysql -h mysql -u root -p$DB_ROOT_PASSWORD hotel_admin

# Scale up service
kubectl scale deployment $SERVICE_NAME --replicas=3 -n hotel-admin

# Wait for service to be ready
kubectl rollout status deployment/$SERVICE_NAME -n hotel-admin

echo "Recovery completed for $SERVICE_NAME"
```

## Troubleshooting

### Common Issues

1. **Service Not Starting**
   ```bash
   # Check pod logs
   kubectl logs -f deployment/document-service -n hotel-admin
   
   # Check events
   kubectl get events -n hotel-admin --sort-by='.lastTimestamp'
   
   # Describe pod
   kubectl describe pod -l app=document-service -n hotel-admin
   ```

2. **High Memory Usage**
   ```bash
   # Check resource usage
   kubectl top pods -n hotel-admin
   
   # Check pod limits
   kubectl describe pod -l app=document-service -n hotel-admin | grep -A 10 Limits
   ```

3. **Network Connectivity**
   ```bash
   # Test service connectivity
   kubectl exec -it deployment/hotel-admin-app -n hotel-admin -- curl -f http://document-service:8001/health
   
   # Check network policies
   kubectl get networkpolicy -n hotel-admin
   ```

### Performance Tuning

1. **Database Optimization**
   ```sql
   -- Add indexes for frequently queried columns
   CREATE INDEX idx_documents_category ON documents(category);
   CREATE INDEX idx_visitors_check_in_date ON visitors(check_in_date);
   
   -- Optimize queries
   EXPLAIN SELECT * FROM documents WHERE category = 'contract' AND created_at > '2024-01-01';
   ```

2. **Caching Strategy**
   ```php
   // Cache frequently accessed data
   $documents = Cache::remember('documents.active', 3600, function () {
       return Document::where('status', 'active')->get();
   });
   ```

3. **Load Balancing**
   ```nginx
   upstream document_service {
       least_conn;
       server document-service-1:8001 weight=3;
       server document-service-2:8001 weight=2;
       server document-service-3:8001 weight=1 backup;
   }
   ```

This deployment guide provides comprehensive instructions for deploying the microservice architecture in various environments. Choose the deployment option that best fits your infrastructure and requirements.
